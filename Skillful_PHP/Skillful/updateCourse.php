<?php
include 'db_connection.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['updatingCourse'])){
        $folder = $_POST['folder'];
        $name = $_POST['chapterName'];
        $presentation = $_FILES['presentation'];
        $nameFile = fopen($folder.'name.txt', 'w');
        fwrite($nameFile, $name);
        fclose($nameFile);
        $targetFile = $folder . "presentation.pptx";
        if(!empty($_FILES['presentation']['name'])){
            if(file_exists($targetFile)) {
                unlink($targetFile);
            }
            if(move_uploaded_file($presentation["tmp_name"], $targetFile)) {
                echo "The file ". basename($presentation["name"]). " has been uploaded.";
                exec('"C:/Program Files/LibreOffice/program/soffice.exe" --headless --convert-to pdf "'.$targetFile.'" --outdir "'.$folder.'"');
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else if(isset($_POST['addChapter'])){
        $folder = $_POST['folder'];
        $n = $_POST['chapterNumber'];
        $newChapterFolder = $folder.'chapter'.$n.'/';
        if (mkdir($newChapterFolder, 0777, true)) {
            echo 'Folder created successfully';
        } else {
            echo 'Failed to create folder';
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else if(isset($_POST['removeChapter'])){
        $folder = $_POST['folder'];
        $n = $_POST['chapterNumber'];
        $chapterFolder = $folder."chapter".$n;
        array_map('unlink', glob($chapterFolder . "/*"));
        rmdir($chapterFolder);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else if(isset($_POST['mainInfo'])){
        $id = $_POST['courseId'];
        $name = $_POST['courseName'];
        $desc = $_POST['description'];
        $thumbnail = $_FILES['thumbnail'];
        $folder = $_POST['folder'];
        if($thumbnail['error'] != UPLOAD_ERR_NO_FILE){
            $path = $folder . 'thumbnail.png';
            if(move_uploaded_file($thumbnail['tmp_name'], $path)){
                echo 'file uploaded successfully';
            } else {
                echo 'file error';
            }
        }
        $sqlCode = "UPDATE courses SET name = '".$name."', description = '".$desc."' WHERE id = ".$id;
        if(mysqli_query($connection, $sqlCode)){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Error updating course";
        }
    } else if(isset($_POST['publish'])){
        $id = $_POST['courseId'];
        $sqlCode = "UPDATE courses SET state = 1 WHERE id = ".$id;
        if(mysqli_query($connection, $sqlCode)){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Error updating course";
        }
    } else if(isset($_POST['private'])){
        $id = $_POST['courseId'];
        $sqlCode = "UPDATE courses SET state = 0, verified = 0 WHERE id = ".$id;
        if(mysqli_query($connection, $sqlCode)){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Error updating course";
        }
    } else if(isset($_POST['verify'])){
        $id = $_POST['courseId'];
        $sqlCode = "UPDATE courses SET verified = 1 WHERE id = ".$id;
        if(mysqli_query($connection, $sqlCode)){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Error updating course";
        }
    } else if(isset($_POST['unverify'])){
        $id = $_POST['courseId'];
        $sqlCode = "UPDATE courses SET verified = 0 WHERE id = ".$id;
        if(mysqli_query($connection, $sqlCode)){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            echo "Error updating course";
        }
    } else if(isset($_POST['addQuestion'])){
        $sqlCode = "INSERT INTO questions (`id_course`) VALUES ('".$_POST['addQuestion']."')";
        $result = mysqli_query($connection, $sqlCode);
        if($result){
            updateQuiz();
        } else {
            echo "Error adding question";
        }
    } else if(isset($_POST['deleteQuestion'])){
        $sqlCode = "DELETE FROM questions WHERE id = ".$_POST['deleteQuestion'];
        $result = mysqli_query($connection, $sqlCode);
        if($result){
            updateQuiz();
        } else {
            echo "Error deleting question";
        }
    } else if(isset($_POST['addAnswer'])){
        $sqlCode = "INSERT INTO answers (`id_question`) VALUES ('".$_POST['addAnswer']."')";
        $result = mysqli_query($connection, $sqlCode);
        if($result){
            updateQuiz();
        } else {
            echo "Error adding answer";
        }
    } else if(isset($_POST['deleteAnswer'])){
        $sqlCode = "DELETE FROM answers WHERE id = ".$_POST['deleteAnswer'];
        $result = mysqli_query($connection, $sqlCode);
        if($result){
            updateQuiz();
        } else {
            echo "Error deleting question";
        }
    } else if(isset($_POST['updateQuiz'])){
        //var_dump($_POST);
        updateQuiz();
    } else if(isset($_POST['deleteCourse'])){
        $sqlCode = "DELETE FROM courses WHERE id = ".$_POST['deleteCourse'];
        $folder = $_POST['folder'];
        $folder = rtrim($folder, "/");
        $result = mysqli_query($connection, $sqlCode);
        if($result){
            deleteDirectory($folder);
            header('Location: home.php');
        } else {
            echo "Error deleting course";
        }
    } else {
        header("Location: home.php");
    }
} else {
    header("Location: home.php");
}

function updateQuiz(){
    include 'db_connection.php';
    //var_dump($_POST);
    $nQuestions = $_POST['nQuestions'];
    for($i = 0; $i < $nQuestions; $i++){
        $question = $_POST['question'.$i];
        $questionId = $_POST['questionId'.$i];
        $sqlCode = "UPDATE questions SET question = '".$question."' WHERE id=".$questionId;
        if(mysqli_query($connection, $sqlCode)){
            $nAnswers = $_POST['nAnswersForQuestion'.$i];
            for($j = 0; $j < $nAnswers; $j++){
                $answer = $_POST['answer'.$j.'question'.$i];
                $answerId = $_POST['answerId'.$j.'question'.$i];
                $correct = 0;
                if($_POST['rightAnswerForQuestion'.$i] == $j){
                    $correct = 1;
                }
                $sqlCode = "UPDATE answers SET answer = '".$answer."', correct = ".$correct." WHERE id=".$answerId;
                if(!mysqli_query($connection, $sqlCode)){
                    echo "Error updating answers";
                }
            }
        } else {
            echo "Error updating questions";
        }
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function deleteDirectory($dir){
    if (!file_exists($dir)) {
        return true;
    }
    if (!is_dir($dir)) {
        return unlink($dir);
    }
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }
    }
    return rmdir($dir);
}