<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="code/changeTheme.js"></script>
    <script src="code/profileViewerCode.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleProfileViewer.css">
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
                    $username = $row['username'];
                    if($row['role'] == 1){
                        $admin = true;
                    }
                } else {
                    header('Location: login.php');
                }
            }
        }
        ?>
        <div id="themeButton">
            <img class="img cursorPointer" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
        </div>
        <a href="home.php" id="homeButton">
            <img class="img" src="assets/icons/homePageButton/homePage0.png" width="50px" height="50px">
        </a>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            if(isset($_GET['userid'])){
                $requestedId = $_GET['userid'];
                $sqlCode = "SELECT id, username, email, pfp, bio, score, role FROM users_view WHERE id = $requestedId";
                $result = mysqli_query($connection, $sqlCode);
                if($result){
                    if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_assoc($result);
                        $username = $row['username'];
                        $userid = $row['id'];
                        $email = $row['email'];
                        $pfp = $row['pfp'];
                        $bio = $row['bio'];
                        $score = $row['score'];
                        $role = $row['role'];
                        if($role == 1){
                            $userIsAdmin = true;
                        } else {
                            $userIsAdmin = false;
                        }
                        if($user_id == $requestedId){
                            $myProfile = true;
                        } else {
                            $myProfile = false;
                        }
                    } else {
                        echo "<div id='noAccessContainer' style='width: 100%; text-align: center; margin-top: 50px'><h1>This user does not exist</h1></div>";
                        exit();
                    }
                }
            } else {
                header('Location: home.php');
            }
        }
        //echo 'currently logged in as user '.$user_id;
    ?>
    <?php
        if($myProfile || $admin){ 
    ?>
            <div id="editProfile" class="hidden">
                <img id="closeEditMenu" class="img cursorPointer" src="assets/icons/closeButton/closeButton0.png" width="50px" height="50px">
                <h1>Customize your profile</h1>
                <form method="POST" action="updateProfile.php" enctype="multipart/form-data">
                    <div id="customization">
                        <div id="changePfp" style="margin-right: 15px">
                            <h2>Change your profile picture</h2>
                            <div id="PFPpreview">
                                <h3>Preview</h3>
                                <img src=<?php echo "'".$pfp."'" ?> id="preview" height="200px" width="200px">
                            </div>
                            <input id="pfp" type="file" name="profilePic" accept="image/*">
                            <input class="button" type="button" value="Reset" id="reset">
                        </div>
                        <div id="changeMainInfo" style="margin-left: 15px">
                            <input type="hidden" name="accountId" value= <?php echo $userid ?>>
                            <input type="hidden" name="pfpPath" value= <?php echo $pfp ?>>
                            <h2>Username</h2>
                            <input class="textarea" type="text" name="username" value= <?php echo "'".$username."'" ?>>
                            <h2>Biography</h2>
                            <textarea class="textarea" type="text" name="bio" style="height: 120px;width: 170px;"><?php echo $bio ?></textarea>
                        </div>
                    </div>
                    <br><button class="button" type="submit" name="updateProfile" id="updateButton">Update</button>
                </form>
            </div>
    <?php
        }
        echo "<script>$(document).ready(function(){
            $('#pfp').change(function(){
                $('#preview').attr('src', window.URL.createObjectURL(this.files[0]))
            })
            $('#reset').click(function(){
                document.getElementById('pfp').value = '';
                $('#preview').attr('src', '".$pfp."');
            })
        })</script>";
    ?>
    <div id="mainContainer">
        <div id="mainProfileInfo" class="box">
            <?php
                if($myProfile || $admin){
                    echo '<img id="editButton" class="img cursorPointer" src="assets/icons/editButton/editButton0.png" width="50px" height="50px">';
                }
            ?>
            <div id="pfp">
                <?php
                    echo "<img id='profilePic' src='".$GLOBALS['pfp']."' width='200px' height='200px'>";
                    echo "<div style='margin-left: 20px'><h1>".$GLOBALS['username'];
                    if($userIsAdmin){
                        echo " [ADMIN]";
                    }
                    echo "</h1>";
                    echo "<h5>User ID: ".$GLOBALS['requestedId']."</h5></div>";
                ?>
            </div>
            <div id="info">
                <div id="score">
                    <h2>Score: 
                    <?php
                        echo $GLOBALS['score'];
                    ?>
                    </h2>
                </div>
                <div id="bio">
                    <?php
                        echo '<h3>Biography:<h3>';
                        echo "<h4>".$GLOBALS['bio']."</h4>";
                    ?>
                </div>
            </div>
        </div>
        <div id="userMadeCourses" class="box">
            <h3>Courses made:</h3>
            <?php
                if($admin || $myProfile){
                    $sqlCode = "SELECT * FROM courses_view WHERE user_created = '".$GLOBALS['requestedId']."' ORDER BY verified DESC, state DESC, avgRating DESC";
                } else {
                    $sqlCode = "SELECT * FROM courses_view WHERE user_created = '".$GLOBALS['requestedId']."' AND state = 1 ORDER BY verified DESC, state DESC, avgRating DESC";
                }
                $result = mysqli_query($connection, $sqlCode);
                if($result){
                    if(mysqli_num_rows($result) > 0){
                        echo '<div id="results">';
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<a class='courseResult clickableBoxLink' href='viewCourse.php?courseId=".$row["course_id"]."'><div class='courseDiv'>";
                            if($row['verified'] == 1){
                                echo "<img class='verifiedIcon img' src='assets/icons/verifiedIcon/verifiedIcon0.png'>";
                            } else if($row['state'] == 0){
                                echo "<img class='verifiedIcon img' src='assets/icons/lockIcon/lockIcon0.png'>";
                            }
                            echo "<img class='courseThumbnail' src='".$row['folder']."thumbnail.png'><h2>".$row['name']."</h2><h5>Course ID: ".$row['id']."</h5>";
                            if($row['nComments']>0){
                                echo "<h4>".$row['avgRating']."⭐ (".$row['nComments'].")</h4>";
                            } else {
                                echo "<h4>No rating</h4>";
                            }
                            echo "</div></a>";
                        }
                        echo "</div>";
                    } else {
                        echo "<h2>User hasn't made any course yet</h2>";
                    }
                } else {
                    echo "Errore nella query";
                }
            ?>
        </div>
        <div id="completedCourses" class="box">
            <h3>Courses completed by this user:</h3>
            <?php
                if($admin || $myProfile){
                    $sqlCode = "SELECT courses_view.* FROM courses_view INNER JOIN exams ON exams.id_course = courses_view.id WHERE exams.id_user = '".$GLOBALS['requestedId']."' AND courses_view.user_created != ".$requestedId." ORDER BY verified DESC, state DESC, avgRating DESC";
                } else {
                    $sqlCode = "SELECT courses_view.* FROM courses_view INNER JOIN exams ON exams.id_course = courses_view.id WHERE exams.id_user = '".$GLOBALS['requestedId']."' AND courses_view.state = 1 AND courses_view.user_created != ".$requestedId." ORDER BY verified DESC, state DESC, avgRating DESC";
                }
                $result = mysqli_query($connection, $sqlCode);
                if($result){
                    if(mysqli_num_rows($result) > 0){
                        echo '<div id="results">';
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<a class='courseResult clickableBoxLink' href='viewCourse.php?courseId=".$row["course_id"]."'><div class='courseDiv'>";
                            if($row['verified'] == 1){
                                echo "<img class='verifiedIcon img' src='assets/icons/verifiedIcon/verifiedIcon0.png'>";
                            }
                            echo "<img class='courseThumbnail' src='".$row['folder']."thumbnail.png'><h2>".$row['name']."</h2><h5>Course ID: ".$row['id']."</h5>";
                            if($row['nComments']>0){
                                echo "<h4>".$row['avgRating']."⭐ (".$row['nComments'].")</h4>";
                            } else {
                                echo "<h4>No rating</h4>";
                            }
                            echo "</div></a>";
                        }
                        echo "</div>";  
                    } else {
                        echo "<h2>User hasn't completed any course yet</h2>";
                    }
                } else {
                    echo "Errore nella query";
                }
            ?>
        </div>
    </div>
</body>
</html>