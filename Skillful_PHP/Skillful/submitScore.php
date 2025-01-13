<?php
include 'db_connection.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['quizSubmission'])){
        $nQuestions = $_POST['nQuestions'];
        $user_id = $_POST['user_id'];
        $course_id = $_POST['course_id'];
        $score = 0;
        for($i = 0; $i < $nQuestions; $i++){
            $sqlCode = "SELECT correct FROM answers WHERE id = ".$_POST['selectedAnswer'.$i];
            $result = mysqli_query($connection, $sqlCode);
            if($result){
                $row = mysqli_fetch_assoc($result);
                if($row['correct'] == 1){
                    $score++;
                }
            }
        }
        $sqlCode = "INSERT INTO exams (`examScore`,`id_course`,`id_user`, `date_done`) VALUES ('".$score."', ".$course_id.", ".$user_id.", CURRENT_TIMESTAMP)";
        $result = mysqli_query($connection, $sqlCode);
        if($result){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    } else {
        header("Location: home.php");
    }
} else {
    header("Location: home.php");
}
