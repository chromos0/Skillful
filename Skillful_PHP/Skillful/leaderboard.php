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
    <link rel="stylesheet" type="text/css" href="styles/styleHomeShared.css">
    <link rel="stylesheet" type="text/css" href="styles/styleLeaderboard.css">
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
    <div style="display: flex; width: 100%; align-items: center; justify-content: center; margin: 20px; font-size: 35px; margin-left: 50%; transform: translateX(-50%);"><img style="margin-right: 20px" src="assets/icons/leaderboardButton/leaderboard0.png" class="img" width="50px" height="50px"><h1">Leaderboard</h1></div>
    <div id="leaderboard">
        <?php
        $i=1;
            $sqlCode = "SELECT username, pfp, id, score FROM users_view ORDER BY score DESC";
            $result = mysqli_query($connection, $sqlCode);
            if($result){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<div class='leaderboardResult'><div class='left'><p>#$i</p><img class='pfp' src='".$row['pfp']."'><a href='viewProfile.php?userid=".$row['id']."' class='username'>".$row['username']."</a></div><div class='right'><p>".$row['score']."</p></div></div>";
                    $i++;
                }
            }
        ?>
    </div>
</body>
</html>