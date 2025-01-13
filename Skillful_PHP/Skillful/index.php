<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="code/changeTheme.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/styleLoginPages.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Skillful</title>
</head>
<body>
    <?php
        session_start();
        include "db_connection.php";
        if (isset($_SESSION['user_id'])) {
            header('Location: home.php');
        }
    ?>
    <div id="loginHeader">
            <img id="logo" class="img" src="assets/icons/logo/logo0.png">
            <h1 id="title">Skillful</h1>
    </div>
    <div id="welcomeContainer">
        <h1>Welcome to Skillful!</h1>
        <h2 style="font-size: 35px">Start creating and completing courses</h2>
        <a href="signup.php">Create an account</a>
        <div id="alreadyWelcomePage">
            <div id="line"></div>
            <div id="alreadyText">
                <h2>Already have an account?</h2>
                <a href="login.php">Log In</a>
            </div>
        </div>
    </div>
</body>
</html>