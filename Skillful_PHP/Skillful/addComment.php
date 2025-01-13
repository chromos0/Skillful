<?php
include 'db_connection.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $comment = $_POST['comment'];
    $rating = $_POST['rate'];
    $id_user = $_POST['userId'];
    $id_course = $_POST['courseId'];
    $sqlCode = "INSERT INTO comments(`comment`, `rating`, `id_user`, `id_course`, `date_added`) VALUES ('".$comment."', ".$rating.", '".$id_user."', '".$id_course."', CURRENT_TIMESTAMP)";
}
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $id = $_GET['id'];
    $sqlCode = "DELETE FROM comments WHERE comments.id = '$id'";
}
$result = mysqli_query($connection, $sqlCode);
if($result){
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    header("Location: home.php");
}