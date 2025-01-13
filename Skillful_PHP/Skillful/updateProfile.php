<?php
include 'db_connection.php';
if(isset($_POST['updateProfile'])){
    $profilePic = $_FILES['profilePic'];
    if($profilePic['error'] != UPLOAD_ERR_NO_FILE){
        if($_POST['pfpPath'] == "assets/defaults/defaultPFP.png"){
            $dir = 'assets/usersPics/';
            $path = $dir . uniqid() . '.png';
        } else {
            $path = $_POST['pfpPath'];
        }
        if(move_uploaded_file($profilePic['tmp_name'], $path)){
            echo 'file uploaded successfully';
        } else {
            echo 'file error';
        }
    } else {
        $path = $_POST['pfpPath'];
    }
    $user_id = $_POST['accountId'];
    $username = $_POST['username'];
    $aboutMe = $_POST['bio'];
    $sqlCode = "UPDATE users SET bio = '$aboutMe', pfp = '$path', username = '$username' WHERE id = $user_id";
    if(mysqli_query($connection, $sqlCode)){
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }else{
        echo 'Errore nell aggiornamento dell utente';
    }
} else {
    header("Location: home.php");
}