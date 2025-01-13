<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="code/changeTheme.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/styleLoginPages.css">
    <title>Skillful</title>
</head>
<body>
    <?php
        session_start();
        include "db_connection.php";
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['username']) && isset($_POST['psw'])){
                $username = $_POST["username"];
                $psw = $_POST["psw"];
                $sqlCode = "SELECT * FROM users WHERE username = '$username'";
                $result = mysqli_query($connection, $sqlCode);
                $usersFound = 0;
                if($result){
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            if($row["username"] == $username){
                                $userPassword = $row["password"];
                                if(password_verify($psw, $userPassword)){
                                    $user_id = $row['id'];
                                    $_SESSION['user_id'] = $user_id;
                                    header('Location: home.php');
                                } else {
                                    echo "password sbagliata";
                                }
                            } else {
                                $usersFound++;
                            }
                        }
                    } else {
                        echo "Username inesistente";
                    }
                }else{
                    echo "Errore nel login";
                }
            }
            if($usersFound>0){
                echo "Username inesistente";
            }
        }
    ?>
    <div id="themeButton">
        <img class="img" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
    </div>
    <div id="fullLoginPage">
        <div id="loginHeader">
            <img id="logo" class="img" src="assets/icons/logo/logo0.png">
            <h1 id="title">Skillful</h1>
        </div>
        <div id="loginScreen">
            <div id="mainText">
                <h1>Log In</h1>
            </div>
            <div id="login">
                <form method="POST" action="">
                    <div class="formItem">
                        <label for="username">Username</label>
                        <input id="username" type="text" name="username" required><br>
                    </div>
                    <div class="formItem">
                        <label for="psw">Password</label>
                        <input id="psw" type="password" name="psw" required><br>
                    </div>
                    <div id="fp" class="formItem">
                        <a href="signup.php">Forgot passowrd?</a>
                    </div>
                    <button type="submit" class="button">Log In</button>
                </form>
            </div>
            <div id="already">
                <div id="line"></div>
                <div id="alreadyText">
                    <h2>Don't have an account?</h2>
                    <a href="signup.php">Sign Up</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>