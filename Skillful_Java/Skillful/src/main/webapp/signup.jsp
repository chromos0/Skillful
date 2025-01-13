<%@ page language="java" contentType="text/html; charset=UTF-8"
    pageEncoding="UTF-8"%>
<%@ page import="javax.servlet.http.HttpSession"%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="code/changeTheme.js"></script>
    <link rel="icon" href="assets/icons/logo.ico" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/styleLoginPages.css">
    <title>Skillful</title>
</head>
<body>
	<%
	HttpSession sessione;
	sessione = request.getSession();
	if(sessione.getAttribute("user_id") != null){
		response.sendRedirect("home.jsp");
	}
	%>
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
                <h1>Sign Up</h1>
            </div>
            <div id="login">
                <form method="POST" action="http://localhost:8082/ProgettoPersonaleSaravolla/Login">
                	<input type="hidden" name="logType" value="signup">
                    <div class="formItem">
                        <label for="username">Username</label>
                        <input id="username" type="text" name="username" required><br>
                    </div>
                    <div class="formItem">
                        <label for="email">E-Mail</label>
                        <input id="email" type="email" name="email" required><br>
                    </div>
                    <div class="formItem">
                        <label for="psw">Password</label>
                        <input id="psw" type="password" name="psw" required><br>
                    </div>
                    <button class="button" type="submit">Sign up</button>
                </form>
            </div>
            <div id="already">
                <div id="line"></div>
                <div id="alreadyText">
                    <h2>Already have an account?</h2>
                    <a href="login.jsp">Log In</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>