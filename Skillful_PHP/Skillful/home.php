<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="code/changeTheme.js"></script>
    <script src="code/homePageCode.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleHomePage.css">
    <link rel="stylesheet" type="text/css" href="styles/styleHomeShared.css">
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
            $getUser = "SELECT * FROM users WHERE id = $user_id";
            $result = mysqli_query($connection, $getUser);
            if($result){
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    $username = $row['username'];
                    $profilePic = $row['pfp'];
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
        if(isset($_GET['logout'])){
            if($_GET['logout'] == 'y'){
                unset($_SESSION['user_id']);
                header('Location: login.php');
            }
        }
    ?>
    <div id="header">
        <a href="home.php" id="logoBox">
            <img id="logo" class="img" src="assets/icons/logo/logo0.png">
            <h1 id="title">Skillful</h1>
        </a>
        <div id="rightHeader">
            <div id="leaderboardButton">
                <a href="leaderboard.php" style="margin-right: 10px; width: 50px; height: 50px"><img class="img" src="assets/icons/leaderboardButton/leaderboard0.png" width=50px height=50px></a>
            </div>
            <div id="categoriesButton">
                <h2>Categories</h2>
            </div>
            <div id="searchBar">
                <form id="searchForm" action="" method="GET">
                    <input id="bar" type="text" placeholder="Search" name="search">
                    <button type="submit" style="background-color: transparent; margin-left: 10px; border: none; cursor: pointer"><img width="25px" height="25px" class="img" src="assets/icons/searchButton/searchButton0.png"></button>
                </form>
            </div>
            <div id="profileIcon">
                <?php
                    echo "<a href='viewProfile.php?userid=".$GLOBALS['user_id']."'><img id='pfp' src='".$GLOBALS['profilePic']."'></a>";
                ?>
            </div>
            <div id="optionsButton" state=0>
                <img src="assets/icons/optionsButton/optionsButton0.png" id="options" class="img">
            </div>
        </div>
    </div>
    <div id="optionsBar">   
        <div id="themeButton">
            <img class="img" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
            <h3>Change theme</h3>
        </div>
        <a id="searchUsers" href="searchUsers.php">
            <img class="img" src="assets/icons/findUsers/findUsers0.png" width="50px" height="50px">
            <h3>Search for other users</h3>
        </a>
        <a id="createCourse" href="createCourse.php">
            <img class="img" src="assets/icons/createCourse/createCourse0.png" width="50px" height="50px">
            <h3>Create a course yourself</h3>
        </a>
        <a id="logOut" href="home.php?logout=y">
            <img class="img" src="assets/icons/logOut/logOutButton0.png" width="50px" height="50px">
            <h3>Log Out</h3>
        </a>
    </div>
    <div id="categories" state=0>
        <a href="home.php">None</a>
        <?php
            $sqlCode = "SELECT * FROM categories";
            $result = mysqli_query($connection, $sqlCode);
            if($result){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<a href='home.php?category=".$row['id']."'>".$row['name']."</a>";
                }
            }
        ?>
    </div>
    <div id="mainBody">
        
        <?php
            if($_SERVER['REQUEST_METHOD'] == 'GET'){
                if(isset($_GET['category'])){
                    echo '<div id="results">';
                    $category = $_GET['category'];
                    $sqlCode = "SELECT * FROM courses_view WHERE category = '$category' AND (state = 1 OR user_created = ".$user_id." OR ".$admin." = TRUE) ORDER BY verified DESC, state DESC, avgRating DESC";
                    $result = mysqli_query($connection, $sqlCode);
                } else if(isset($_GET["search"])){
                    echo '<div id="results">';
                    $search = $_GET['search'];
                    $sqlCode = "SELECT * FROM courses_view WHERE name LIKE '%$search%' AND (state = 1 OR user_created = ".$user_id." OR ".$admin." = TRUE) ORDER BY verified DESC, state DESC, avgRating DESC";
                    $result = mysqli_query($connection, $sqlCode);
                } else {
                    echo '<h1 style="margin-left: 20px; margin-bottom: 0">Popular courses</h1><div id="results">';
                    $sqlCode = "SELECT * FROM courses_view WHERE (state = 1 OR user_created = ".$user_id." OR ".$admin." = TRUE) ORDER BY verified DESC, state DESC, avgRating DESC";
                    $result = mysqli_query($connection, $sqlCode);
                }
                if($result){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<a class='courseResult clickableBoxLink' href='viewCourse.php?courseId=".$row["course_id"]."'><div class='courseDiv'>";
                            if($row['verified'] == 1){
                                echo "<img class='verifiedIcon img' src='assets/icons/verifiedIcon/verifiedIcon0.png'>";
                            } else if($row['state'] == 0){
                                echo "<img class='verifiedIcon img' src='assets/icons/lockIcon/lockIcon0.png'>";
                            }
                            echo "<img class='courseThumbnail' src='".$row['folder']."thumbnail.png'><h2>".$row['name']."</h2><h5>Course ID: ".$row['course_id']."<h3>By: ".$row['username']."</h3></h5>";
                            if($row['nComments']>0){
                                echo "<h4>Rating: ".$row['avgRating']."⭐ (".$row['nComments'].")</h4>";
                            } else {
                                echo "<h4>No rating</h4>";
                            }
                            echo "</div></a>";
                        }
                    } else {
                        echo "<h2>No results</h2>";
                    }
                } else {
                    echo "Errore nella query";
                }
            }
            echo '</div>';
        ?>
        </div>
    </div>
</body>
</html>