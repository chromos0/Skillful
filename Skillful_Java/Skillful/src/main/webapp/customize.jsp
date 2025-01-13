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
    <script src="code/customizeCode.js"></script>
    <link rel="icon" href="assets/icons/logo.ico" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleCustomizePage.css">
    <title>Skillful</title>
</head>
<body>
	<%
	HttpSession sessione;
	sessione = request.getSession();
	int user_id = 0;
	String profilePic = "";
	int role = 0;
	String username = "";
	if(sessione.getAttribute("user_id") == null){
		response.sendRedirect("signup.jsp");
	} else {
		user_id = (int)sessione.getAttribute("user_id");
		profilePic = (String)sessione.getAttribute("pfp");
		role = (int)sessione.getAttribute("role");
		username = (String)sessione.getAttribute("username");
	}
	%>
    <div id="mainContainer">
        <div id="info">
        	<h1>Welcome <%= username %></h1>
        </div>
        <!--    -->
        <form method="POST" action="http://localhost:8082/ProgettoPersonaleSaravolla/Login" enctype="multipart/form-data">
        	<input type="hidden" name="logType" value="customize">
            <div id="customization">
                <div id="changePFP" style="margin-right: 15px">
                    <h2>Change your profile picture</h2>
                    <div id="PFPpreview">
                        <h3>Preview</h3>
                        <img src="assets/defaults/defaultPFP.png" id="preview" height="250px" width="250px">
                    </div>
                    <input id="pfp" type="file" name="pfp" accept="image/*">
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