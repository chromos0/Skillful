<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="code/changeTheme.js"></script>
    <script src="code/courseViewerCode.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleCourseViewer.css">
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
        ?>
        <img class="img cursorPointer" id="themeButton" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
        <a href="home.php" id="homeButton">
            <img class="img" src="assets/icons/homePageButton/homePage0.png" width="50px" height="50px">
        </a>
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            if(isset($_GET['courseId'])){
                $requestedId = $_GET['courseId'];
                $sqlCode = "SELECT *, courses.id AS course_id, users.id AS user_id, users.role FROM courses INNER JOIN users ON user_created = users.id WHERE courses.id = $requestedId";
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
                        $role = $row['role'];
                        if($role == 1){
                            $userIsAdmin = true;
                        } else {
                            $userIsAdmin = false;
                        }
                        if($user_id == $user_created){
                            $myCourse = true;
                        } else {
                            $myCourse = false;
                        }
                    } else {
                        echo "<div id='noAccessContainer' style='width: 100%; text-align: center; margin-top: 50px'><h1>This course does not exist</h1></div>";
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
    if(!($state == 0 && !($admin || $myCourse))){
    ?>
    <div id="mainContainer">
        <div id="mainInfo" class="box">
            <?php
                echo '<h1 style="margin: 0">'.$name.'</h1><h5 style="margin-top: 0">Course ID: '.$requestedId.'</h5><a style="text-decoration: none; color: var(--textcolor); width: fit-content; display: block" href="viewProfile.php?userid='.$user_created.'"><h2 style="width: fit-content">By '.$username;
                if($userIsAdmin){
                    echo " [ADMIN]";
                }
                echo '</h2></a><h3>Description:</h3><h4>'.$desc.'</h4><img id="thumbnail" src="'.$folder.'thumbnail.png">';
                if($admin || $myCourse){
                    echo "<img id='editButton' class='img cursorPointer' src='assets/icons/optionsButton/optionsButton0.png'>";
                    echo "<div id='editButtonsContainer' class='hidden'><a href = 'editCourse.php?courseId=".$requestedId."'><img class='img editButtons' src='assets/icons/editButton/editButton0.png'></a><br><img id='deleteButton' class='img editButtons cursorPointer' src='assets/icons/deleteButton/deleteButton0.png'></div>";
                    echo "<div id='confirmDeleteContainer' class='hidden'><h2 style='margin-bottom: 75px'>Are you sure you want to delete this course?</h2><div id='options'><form action='updateCourse.php' method='POST' style='margin-left: 30px'><input type='hidden' name='folder' value='".$folder."'><button type='submit' value=".$requestedId." id='yes' class='cursorPointer' name='deleteCourse'><h2>Yes</h2></button></form><h2 style='margin-right: 30px' class='cursorPointer' id='no'>No</h2></div></div>";
                }
            ?>
        </div>
        <div id="chapterSelector" class="box">
            <?php 
                if(isset($_GET['chapter'])){
                    $chapter = $_GET['chapter'];
                    if(!file_exists($folder."chapter".$chapter)){
                        header('Location: viewCourse.php?courseId='.$requestedId);
                    }
                } else {
                    $chapter = 1;
                }
                $chaptersName = 'chapter*';
                $matches = glob($folder.$chaptersName, GLOB_ONLYDIR);
                $nChapters = count($matches);
                if($nChapters > 0){
                    echo "<h2>Select Chapter:<h2><div id='chapters'>";
                    for($i = 1; $i <= $nChapters; $i++){
                        echo '<a class="selectChapterButton" href="viewCourse.php?courseId='.$requestedId.'&chapter='.$i.'"><h3>'.$i.'</h3></a>';
                    }
                    echo "</div>";
                } else {
                    echo "<h2>No chapters found</h2>";
                }
            ?>
        </div>
        <div id="chapterContent" class="box" class="box">
            <?php
                $chapterFolder = $folder.'chapter'.$chapter.'/';
                $chapterNameFile = $chapterFolder."name.txt";
                if(file_exists($chapterNameFile)){
                    echo "<div id='chapterContainer'><h1>".file_get_contents($chapterNameFile)."</h1><div id='presentation'>";
                } else {
                    echo "<div id='chapterContainer'><div id='presentation'>";
                }
                $pdfFile = $chapterFolder.'presentation.pdf';
                if(file_exists($pdfFile)){
                    echo '<iframe src="'.$pdfFile.'" width="100%" height="700px"></iframe>';
                } else {
                    echo '<h2>No presentation found</h2>';
                }
                echo "</div></div>";
            ?>
        </div>
        <?php
            if($chapter == $nChapters){
                echo "<div class='box' id='finalQuiz'>";
                $sqlCode = "SELECT * FROM exams WHERE id_course = ".$requestedId." AND id_user = ".$user_id;
                $result = mysqli_query($connection, $sqlCode);
                if($result){
                    if(mysqli_num_rows($result) == 0){
                        echo "<h1>Final quiz</h1><form action='submitScore.php' method='POST' id='finalQuiz'>";
                        $sqlCode = "SELECT * from questions where id_course = ".$requestedId;
                        $result = mysqli_query($connection,$sqlCode);
                        $i = 0;
                        if($result){
                            $nQuestions = mysqli_num_rows($result);
                            echo "<input type='hidden' value='".$nQuestions."' name='nQuestions'>";
                            echo "<input type='hidden' value='".$user_id."' name='user_id'>";
                            echo "<input type='hidden' value='".$requestedId."' name='course_id'>";
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<input type='hidden' value='".$row['id']."' name='questionId".$i."'>";
                                echo "<h2>".$row['question']."</h2><br>";
                                $sqlCode = "SELECT * from answers where id_question = ".$row['id'];
                                $result2 = mysqli_query($connection, $sqlCode);
                                $j = 0;
                                if($result2){
                                    $nAnswers = mysqli_num_rows($result2);
                                    echo "<ul>";
                                    while($rowA = mysqli_fetch_assoc($result2)){
                                        echo "<li><input type='radio' value='".$rowA['id']."' name='selectedAnswer".$i."'><h3 class='answer'>".$rowA['answer']."</h3></li><br>";
                                        $j++;
                                    }
                                    echo "</ul>";
                                }
                                $i++;
                            }
                            echo "<button type='submit' name='quizSubmission' id='submitAnswersButton'>Submit answers</button></form>";
                        }
                    } else {
                        $row = mysqli_fetch_assoc($result);
                        echo "<h2>You already completed the final quiz for this course with a score of ".$row['examScore'];
                        $sqlCode = "SELECT COUNT(*) AS n FROM questions WHERE id_course = ".$requestedId;
                        $result = mysqli_query($connection, $sqlCode);
                        if($result){
                            $row = mysqli_fetch_assoc($result);
                            echo "/".$row['n']."</h2>";
                        }
                    }
                }
                echo "</div>";
            }
        ?>
        <div id="commentsAreaContainer" class="box" style="width: 99%">
            <h2>Comments</h2>
            <div id="addComment">
                <form action="addComment.php" method="POST">
                    <input required type="text" placeholder="Add a comment..." name="comment">
                    <label for="rating">Rate: </label>
                    <select name="rate" id="rating">
                        <option value=0>0⭐</option>
                        <option value=0.5>0.5⭐</option>
                        <option value=1>1⭐</option>
                        <option value=1.5>1.5⭐</option>
                        <option value=2>2⭐</option>
                        <option value=2.5>2.5⭐</option>
                        <option value=3>3⭐</option>
                        <option value=3.5>3.5⭐</option>
                        <option value=4>4⭐</option>
                        <option value=4.5>4.5⭐</option>
                        <option selected value=5>5⭐</option>
                    </select>
                    <?php
                        echo '<input type="hidden" name="userId" value="'.$user_id.'"><input type="hidden" name="courseId" value="'.$requestedId.'">';
                    ?>
                    <button type="submit" id="submitComment">Submit comment</button>
                </form>
            </div>
            <div id="comments">
                <?php
                    $sqlCode = "SELECT *, comments.id as comment_id, users.id as user_id FROM comments INNER JOIN users on comments.id_user = users.id WHERE id_course = '$requestedId' ORDER BY date_added DESC";
                    $result = mysqli_query($connection, $sqlCode);
                    if($result){
                        if(mysqli_num_rows($result) > 0){
                            echo '<div id="commentsResults">';
                            while($row = mysqli_fetch_assoc($result)){
                                echo '<div id="'.$row['comment_id'].'" class="comment"><div class="userInfo"><img class="userPfp" width="70px" height="70px" src="'.$row['pfp'].'"><div class="infoContainer"><a href="viewProfile.php?userid='.$row['user_id'].'"><h2>'.$row['username'].'</h2></a><h3>'.$row['rating'].'⭐</h3></div></div><h4>'.$row['comment'].'</h4>';
                                if($admin || $user_id == $row['id_user']){
                                    echo '<img style="width: 30px; height: 30px" class="img edit" id="'.$row['comment_id'].'" src="assets/icons/deleteButton/deleteButton0.png">';
                                }
                                echo '</div>';
                            }
                            echo '</div>';
                        } else {
                            echo '<h2>No comments yet</h2>';
                        }
                    }
                    echo '<script>$(document).ready(function(){$(".edit").click(function(){window.location.replace("addComment.php?id=" + $(this).attr("id"))})})</script>';
                ?>
            </div>
        </div>
    </div>
    <?php
    } else {
    ?>
    <div id="noAccessContainer" style="width: 100%; text-align: center; margin-top: 50px">
        <h1>You don't have access to this course</h1>
    </div>
    <?php
    }
    ?>
</body>