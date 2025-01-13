<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="code/changeTheme.js"></script>
    <script src="code/createCourseCode.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleCourseCreator.css">
    <title>Skillful</title>
</head>
<body>
<?php
        session_start();
        include "db_connection.php";
        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
        } else {
            $user_id = $_SESSION['user_id'];
            $getUsername = "SELECT username FROM users WHERE id = $user_id";
            $result = mysqli_query($connection, $getUsername);
            if($result){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    $username = $row['username'];
                } else {
                    header('Location: login.php');
                }
            }
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['desc']) && isset($_FILES['thumbnail']) && isset($_POST['name'])){
                $thumbnail = $_FILES['thumbnail'];
                $dir = 'assets/courses/';
                $folder = $dir . uniqid() . '/';
                if($thumbnail['error'] === UPLOAD_ERR_NO_FILE){
                    $defaultPath = 'assets/defaults/defaultThumbnail.png';
                    $path = $folder . 'thumbnail.png';
                    if (mkdir($folder, 0777, true)) {
                        echo 'folder created successfully';
                        if (copy($defaultPath, $path)) {
                            echo 'using default file';
                        } else {
                            echo 'failed to copy default file';
                        }
                        $chapter1Folder = $folder . 'chapter1/';
                        if (mkdir($chapter1Folder, 0777, true)) {
                            echo 'Folder created successfully';
                        } else {
                            echo 'Failed to create folder';
                        }
                    } else {
                        echo 'Failed to create folder';
                    }
                } else {
                    if (mkdir($folder, 0777, true)) {
                        echo 'Folder created successfully';
                        $path = $folder . 'thumbnail.png';
                        if(move_uploaded_file($thumbnail['tmp_name'], $path)){
                            echo 'file uploaded successfully';
                        } else {
                            echo 'file error';
                        }
                        $chapter1Folder = $folder . 'chapter1/';
                        if (mkdir($chapter1Folder, 0777, true)) {
                            echo 'Folder created successfully';
                        } else {
                            echo 'Failed to create folder';
                        }
                    } else {
                        echo 'Failed to create folder';
                    }
                }
                $desc = $_POST['desc'];
                $name = $_POST['name'];
                if($desc == '')
                    $desc = 'No description added';
                if(!isset($_POST['category'])){
                    $sqlCode = "INSERT INTO courses(`name`, `description`, `folder`, `creation_date`, `user_created`) VALUES ('$name', '$desc', '$folder', CURRENT_TIMESTAMP, '$user_id')";
                } else {
                    $category = $_POST['category'];
                    $sqlCode = "INSERT INTO courses(`name`, `description`, `folder`, `category`, `creation_date`, `user_created`) VALUES ('$name', '$desc', '$folder', '$category', CURRENT_TIMESTAMP, '$user_id')";
                }
                if(mysqli_query($connection, $sqlCode)){
                    $course_id = $connection -> insert_id;
                    header('Location: editCourse.php?courseId='.$course_id);
                }else{
                    echo 'Errore nella creazione del corso';
                }
            }
        }
    ?>
    <a href='home.php' id="backButton"><img class="img" src="assets/icons/backButton/backButton0.png" width="50px" height="50px"></a>
    <img class="img" id="themeButton" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
    <div id="mainContainer">
        <form method="POST" action="" enctype="multipart/form-data">
        <div id="changeName">
                <h2>Give a name to your course</h2>
                <input type="text" name="name" class="input" required>
            </div>
            <div id="changeThumbnail">
                <h2>Choose a thumbnail for your course</h2>
                <div id="ThumbnailPreview">
                    <h3>Preview</h3>
                    <img src="assets/defaults/defaultThumbnail.png" id="preview" height="234px" width="416px">
                </div>
                <input id="thumbnail" type="file" name="thumbnail" accept="image/*">
                <input type="button" value="Reset" id="reset" class="button" style="font-size: 15px">
            </div>
            <div id="changeDesc">
                <h2>Add a description to this course</h2>
                <textarea name="desc"></textarea>
            </div>
            <div id="chooseCategory">
                <h2>Choose a category</h2>
                <select name="category" class='input'>
                    <option selected disabled></option>
                    <?php
                        $sqlCode = "SELECT * FROM categories";
                        $result = mysqli_query($connection, $sqlCode);
                        if($result){
                            while($row = mysqli_fetch_array($result)){
                                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                            }
                        }
                    ?>
                </select>
            </div>
            <div id="send">
                <button type="submit" class="button">Submit course</button>
            </div>
        </form>
    </div>
</body>
</html>