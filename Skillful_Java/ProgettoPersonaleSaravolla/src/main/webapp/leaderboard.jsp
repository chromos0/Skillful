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
    <script src="code/leaderboardCode.js"></script>
    <script src="code/homePageCodeShared.js"></script>
    <link rel="icon" href="assets/icons/logo.ico" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleHomeShared.css">
    <link rel="stylesheet" type="text/css" href="styles/styleLeaderboard.css">
    <title>Skillful</title>
</head>
<body>
    <%
    HttpSession sessione;
    sessione = request.getSession();
	int user_id = 0;
	String profilePic = "";
	int role = 0;
	if(sessione.getAttribute("user_id") == null){
		response.sendRedirect("login.jsp");
	} else {
		user_id = (int)sessione.getAttribute("user_id");
		profilePic = (String)sessione.getAttribute("pfp");
		role = (int)sessione.getAttribute("role");
	}
	%>
    <div id="header">
        <a href="home.jsp" id="logoBox">
            <img id="logo" class="img" src="assets/icons/logo/logo0.png">
            <h1 id="title">Skillful</h1>
        </a>
        <div id="rightHeader">
            <div id="profileIcon">
                <%
            	out.print("<a href='viewProfile.jsp?userid=" + user_id +"'><img id='pfp' src='" + profilePic + "'></a>");
            	%>
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
        <a id="backHome" href="home.jsp">
            <img class="img" src="assets/icons/homePageButton/homePage0.png" width="50px" height="50px">
            <h3>Go back to the home page</h3>
        </a>
        <a id="logOut" href="home.jsp?logout=y">
            <img class="img" src="assets/icons/logOut/logOutButton0.png" width="50px" height="50px">
            <h3>Log Out</h3>
        </a>
    </div>
    <div style="display: flex; width: 100%; align-items: center; justify-content: center; margin: 20px; font-size: 35px; margin-left: 50%; transform: translateX(-50%);"><img style="margin-right: 20px" src="assets/icons/leaderboardButton/leaderboard0.png" class="img" width="50px" height="50px"><h1">Leaderboard</h1></div>
    <div id="leaderboard">
    </div>
</body>
</html>