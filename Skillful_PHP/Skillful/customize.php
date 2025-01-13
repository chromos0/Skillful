<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="code/changeTheme.js"></script>
    <script src="code/customizeCode.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleCustomizePage.css">
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
            if(isset($_POST['aboutMe']) && isset($_FILES['profilePic'])){
                $profilePic = $_FILES['profilePic'];
                if($profilePic['error'] === UPLOAD_ERR_NO_FILE){
                    $path = 'assets/defaults/defaultPFP.png';
                } else {
                    $dir = 'assets/usersPics/';
                    $path = $dir . uniqid() . '.png';
                    if(move_uploaded_file($profilePic['tmp_name'], $path)){
                        echo 'file uploaded successfully';
                    } else {
                        echo 'file error';
                    }
                }
                $aboutMe = $_POST['aboutMe'];
                if($aboutMe != '')
                    $sqlCode = "UPDATE users SET bio = '$aboutMe', pfp = '$path' WHERE id = $user_id";
                else
                    $sqlCode = "UPDATE users SET pfp = '$path' WHERE id = $user_id";
                if(mysqli_query($connection, $sqlCode)){
                    header('Location: home.php');
                }else{
                    echo 'Errore nell aggiornamento dell utente';
                }
            }
        }
    ?>
    <div id="mainContainer">
        <div id="info">
            <?php echo "<h1>Welcome ".$GLOBALS['username']."!</h1>" ?>
        </div>
        <form method="POST" action="" enctype="multipart/form-data">
            <div id="customization">
                <div id="changePFP" style="margin-right: 15px">
                    <h2>Change your profile picture</h2>
                    <div id="PFPpreview">
                        <h3>Preview</h3>
                        <img src="assets/defaults/defaultPFP.png" id="preview" height="250px" width="250px">
                    </div>
                    <input id="pfp" type="file" name="profilePic" accept="image/*">
                    <input class="button" type="button" value="Reset" id="reset">
                </div>
                <div id="changeBio" style="margin-left: 15px">
                    <h2>Add a description to your profile</h2>
                    <textarea name="aboutMe" style="width: 370px; height: 150px"></textarea>
                </div>
            </div>
            <div>
                <button type="submit" id="confirm">Confirm</button>
            </div>
        </form>
    </div>
</body>
</html>