<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="code/changeTheme.js"></script>
    <script src="code/searchUsersCode.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleSearchUsers.css">
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
                } else {
                    header('Location: login.php');
                }
            }
        }
    ?>
    <div id="header">
        <a href="home.php" id="logoBox">
            <img id="logo" class="img" src="assets/icons/logo/logo0.png">
            <h1 id="title">Skillful</h1>
        </a>
        <div id="rightHeader">
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
        <a id="backHome" href="home.php">
            <img class="img" src="assets/icons/homePageButton/homePage0.png" width="50px" height="50px">
            <h3>Go back to the home page</h3>
        </a>
        <a id="logOut" href="home.php?logout=y">
            <img class="img" src="assets/icons/logOut/logOutButton0.png" width="50px" height="50px">
            <h3>Log Out</h3>
        </a>
    </div>
    <div id="mainBody">
        <div id="searchBar">
            <form action="" method="GET" id="searchForm">
                <input id="bar" type="search" placeholder="Search username or ID" name="search">
                <button id="searchButton" type="submit"><img class="img cursorPointer" src="assets/icons/searchButton/searchButton0.png" width="38px" height="38px"></button>
            </form>
        </div>
        <div id="results">
            <?php
                if($_SERVER['REQUEST_METHOD'] == 'GET'){
                    if(isset($_GET['search'])){
                        $search = $_GET['search'];
                    } else {
                        $search = "";
                    }
                    $foundUsers = false;
                    $sqlCode = "SELECT id, username, email, pfp, bio, score FROM users_view WHERE id = '$search'";
                    $result = mysqli_query($connection, $sqlCode);
                    if($result){
                        if(mysqli_num_rows($result) > 0){
                            $foundUsers = true;
                            $row = mysqli_fetch_assoc($result);
                            echo "<a class='userResult clickableBoxLink' href='viewProfile.php?userid=".$row['id']."'><img class='pfp' src='".$row['pfp']."'><h2>".$row['username']."</h2><h5>User id: ".$row['id']."</h5></a>";
                        }
                    } else {
                        echo "Errore nella query";
                    }
                    $sqlCode = "SELECT id, username, email, pfp, bio, score FROM users_view WHERE username LIKE '%$search%' ORDER BY username";
                    $result = mysqli_query($connection, $sqlCode);
                    if($result){
                        if(mysqli_num_rows($result) > 0){
                            $foundUsers = true;
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<a class='userResult clickableBoxLink' href='viewProfile.php?userid=".$row['id']."'><img class='pfp' src='".$row['pfp']."'><h2>".$row['username']."</h2><h5>User id: ".$row['id']."</h5></a>";
                            }
                        }
                    } else {
                        echo "Errore nella query";
                    }
                    if(!$foundUsers){
                        echo "<h2>No users found</h2>";
                    }

                }
            ?>
        </div>
    </div>
</body>