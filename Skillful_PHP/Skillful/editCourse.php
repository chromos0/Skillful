<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="code/changeTheme.js"></script>
    <script src="code/editCourseCode.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleCourseViewer.css">
    <link rel="stylesheet" type="text/css" href="styles/styleCourseEditor.css">
    <title>Skillful</title>
</head>
<body>
    <?php
        session_start();
        include "db_connection.php";
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
        } else {
            $admin = false;
            $user_id = $_SESSION['user_id'];
            $getUsername = "SELECT * FROM users WHERE id = $user_id";
            $result = mysqli_query($connection, $getUsername);
            if($result){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    if($row['role'] == 1){
                        $admin = true;
                    } else {
                        $admin = 0;
                    }
                } else {
                    header('Location: login.php');
                }
            }
        }
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            if(isset($_GET['courseId'])){
                $requestedId = $_GET['courseId'];
                $sqlCode = "SELECT *, courses.id AS course_id, users.id AS user_id FROM courses INNER JOIN users ON user_created = users.id WHERE courses.id = $requestedId";
                $result = mysqli_query($connection, $sqlCode);
                if($result){
                    if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_assoc($result);
                        $user_created = $row['user_created'];
                        $folder = $row['folder'];
                        $name = $row['name'];
                        $desc = $row['description'];
                        $creationDate = $row['creation_date'];
                        $username = $row['username'];
                        $state = $row['state'];
                        $verified = $row['verified'];
                        if($user_id == $user_created){
                            $myCourse = true;
                        } else {
                            $myCourse = false;
                        }
                    } else {
                        echo "<img class='img cursorPointer' id='themeButton' src='assets/icons/themeButton/themeButton0.png' width='50px' height='50px'><a href='home.php' id='homeButton'><img class='img' src='assets/icons/homePageButton/homePage0.png' width='50px' height='50px'></a>";
                        echo "<div id='noAccessContainer' style='width: 100%; text-align: center; margin-top: 50px'><h1>This course does not exist</h1></div>";
                        exit();
                    }
                }
            } else {
                header('Location: home.php');
            }
        }
    ?>
    <?php
    if($admin || $myCourse){
    ?>
    <a href='viewCourse.php?courseId=<?php echo $requestedId ?>' id="backButton"><img class="img" src="assets/icons/backButton/backButton0.png" width="50px" height="50px"></a>
    <img class="img cursorPointer" id="themeButton" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
    <div id="mainContainer">
        <div id="mainInfo" class='box'>
            <?php
                echo "<form action='updateCourse.php' method='POST' id='verification'><input type='hidden' name='courseId' value = ".$requestedId.">";
                if($state == 0){
                    echo "<button type='submit' name='publish'>Publish Course</button>";
                } else {
                    echo "<button type='submit' name='private'>Set course as private</button>";
                }
                echo "<br>";
                if($verified == 0 && $admin){
                    if($state == 1)
                        echo "<button type='submit' name='verify'>Verify course</button>";
                } else if($admin){
                    echo "<button type='submit' name='unverify'>Unverify course</button>";
                }
                echo "</form>";
            ?>
            <form method="POST" action="updateCourse.php" enctype="multipart/form-data">
                <?php echo '<input type="hidden" name="courseId" value='.$requestedId.'>' ?>
                <?php echo '<input type="hidden" name="folder" value='.$folder.'>' ?>
                <h2>Course name</h2>
                <?php echo "<input type='text' class='input' name='courseName' value='".$name."'>";
                echo '<h5 style="margin-top: 0">Course ID: '.$requestedId.'</h5><h2>By '.$username.'</h2><h3>Description:</h3>';
                echo "<textarea name='description'>".$desc."</textarea><br>" ?>
                <?php
                    echo '<img id="preview" src="'.$folder.'thumbnail.png" width="512px" height="288px"><br>';
                ?>
                <input id="thumbnailInput" type="file" name="thumbnail" accept="image/*">
                <input class="button" type="button" value="Reset" id="reset">
                <br><button type="submit" name="mainInfo">Update</button>
            </form>
            <?php
            echo "<script>$(document).ready(function(){
                $('#thumbnailInput').change(function(){
                    $('#preview').attr('src', window.URL.createObjectURL(this.files[0]))
                })
                $('#reset').click(function(){
                    document.getElementById('thumbnailInput').value = '';
                    $('#preview').attr('src', '".$folder."thumbnail.png');
                })
            })</script>";
            ?>
        </div>
        <div id="chaptersEditor" class="box">
            <div id="chapters">
            <?php
            $chaptersName = 'chapter*';
            $matches = glob($folder.$chaptersName, GLOB_ONLYDIR);
            $nChapters = count($matches);
            for($i = 1; $i <= $nChapters; $i++){
                $currentChapterFolder = $folder.'chapter'.$i.'/';
                echo "<div class='chapter' id='chapter".$i."'><h2>Chapter ".$i."</h2><form method='POST' action='updateCourse.php' enctype='multipart/form-data'><input type='hidden' name='folder' value='".$currentChapterFolder."'>";
                $pptxFile = $currentChapterFolder.'presentation.pptx';
                $nameFilePath = $currentChapterFolder.'name.txt';
                echo "<input type='text' class='input' name='chapterName' placeholder='Chapter Name'";
                if(file_exists($nameFilePath)){
                    echo " value='".file_get_contents($nameFilePath)."'";
                }
                echo "><br><input type='file' class='fileInput' name='presentation' accept='.pptx,application/vnd.openxmlformats-officedocument.presentationml.presentation'>";
                if(file_exists($pptxFile)){
                    echo '<br><a href="'.$pptxFile.'" download="chapter'.$i.'">Download current presentation</a>';
                }
                echo "<br><button type='submit' name='updatingCourse'>Update</button></form>";
                if($i == $nChapters){
                    echo "<br><form action='updateCourse.php' method='POST'><input type='hidden' name='chapterNumber' value = ".$i."><input type='hidden' name='folder' value='".$folder."'><button type='submit' name='removeChapter'>Remove Chapter</button></form>";
                }
                echo "</div>";
            }
            echo "</div><br><form action='updateCourse.php' method='POST'><input type='hidden' name='chapterNumber' value = ".$i."><input type='hidden' name='folder' value='".$folder."'><button type='submit' name='addChapter'>Add Chapter</button></form>";
            ?>
            
        </div>
        <div id="finalQuizEditor" class="box">
        <?php
            echo "<br><h2 id='createQuiz'>Final quiz</h2>";
            echo "<br><form action='updateCourse.php' method='POST' cid='finalQuiz'><div id='quizGrid'>";
            $sqlCode = "SELECT * from questions where id_course = ".$requestedId;
            $result = mysqli_query($connection,$sqlCode);
            $i = 0;
            if($result){
                $nQuestions = mysqli_num_rows($result);
                echo "<input type='hidden' value='".$nQuestions."' name='nQuestions'>";
                while($row = mysqli_fetch_assoc($result)){
                    echo "<div class='question'><input type='hidden' value='".$row['id']."' name='questionId".$i."'>";
                    echo "<input type='text' class='input' value='".$row['question']."' class='question' name='question".$i."'><button class='deleteButton' type='submit' name='deleteQuestion' value='".$row['id']."'><img class='deleteQuestion img' height='30px' width='30px' src='assets/icons/deleteButton/deleteButton0.png'></button><br>";
                    $sqlCode = "SELECT * from answers where id_question = ".$row['id'];
                    $result2 = mysqli_query($connection, $sqlCode);
                    $j = 0;
                    if($result2){
                        $nAnswers = mysqli_num_rows($result2);
                        echo "<input type='hidden' value='".$nAnswers."' name='nAnswersForQuestion".$i."'><ul>";
                        while($rowA = mysqli_fetch_assoc($result2)){
                            echo "<input type='hidden' value='".$rowA['id']."' name='answerId".$j."question".$i."'>";
                            echo "<li><input type='text' class='input' value='".$rowA['answer']."' class='answer' name='answer".$j."question".$i."'>";
                            echo "<input type='radio' value='".$j."' name='rightAnswerForQuestion".$i."'";
                            if($rowA['correct'] == 1){
                                echo " checked";
                            }
                            echo "><button class='deleteButton' type='submit' name='deleteAnswer' value='".$rowA['id']."'><img class='deleteAnswer img' height='30px' width='30px' src='assets/icons/deleteButton/deleteButton0.png'></button></li><br>";
                            $j++;
                        }
                    }
                    echo "</ul><button type='submit' name='addAnswer' value='".$row['id']."'>Add answer</button></div>";
                    $i++;
                }
            }
            echo "</div><button type='submit' name='addQuestion' value='".$requestedId."'>Add question</button><br>";
            echo "<button type='submit' name='updateQuiz' style='margin-top: 10px'>Update quiz</button>";
            echo "</form>";
            ?>
        </div>
    </div>
    <?php
    } else {
    ?>
    <img class="img cursorPointer" id="themeButton" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
    <a href="home.php" id="homeButton">
        <img class="img" src="assets/icons/homePageButton/homePage0.png" width="50px" height="50px">
    </a>
    <div id="noAccessContainer" style="width: 100%; text-align: center; margin-top: 50px">
        <h1>You don't have access to this course</h1>
    </div>
    <?php
    }
    ?>
</body>