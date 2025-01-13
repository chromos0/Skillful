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
    <script src="code/profileViewerCode.js"></script>
    <link rel="icon" href="assets/icons/logo.ico" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleProfileViewer.css">
    <title>Skillful</title>
</head>
<body>
	<%
	HttpSession sessione;
	sessione = request.getSession();
	int user_id = 0;
	String profilePic = "";
	int role = 0;
	int requestedId = 0;
	boolean myProfile = false;
	if(sessione.getAttribute("user_id") == null){
		response.sendRedirect("login.jsp");
	} else {
		user_id = (int)sessione.getAttribute("user_id");
		profilePic = (String)sessione.getAttribute("pfp");
		role = (int)sessione.getAttribute("role");
		if(request.getParameter("userid") != null){
			requestedId = Integer.parseInt(request.getParameter("userid"));
			if(requestedId == user_id){
				myProfile = true;
			}
		}
	}
	%>    
	<div id="themeButton">
        <img class="img" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
    </div>
    <a href="home.jsp" id="homeButton">
            <img class="img" src="assets/icons/homePageButton/homePage0.png" width="50px" height="50px">
        </a>
    <div id="editProfile" class="hidden">
                <img id="closeEditMenu" class="img cursorPointer" src="assets/icons/closeButton/closeButton0.png" width="50px" height="50px">
                <h1>Customize your profile</h1>
                <form method="POST" action="http://localhost:8082/ProgettoPersonaleSaravolla/Login" enctype="multipart/form-data">
                <input type="hidden" name="logType" value="update">
                    <div id="customization">
                        <div id="changePfp" style="margin-right: 15px">
                            <h2>Change your profile picture</h2>
                            <div id="PFPpreview">
                                <h3>Preview</h3>
                                <img id="preview" height="200px" width="200px">
                            </div>
                            <input id="pfp" type="file" name="profilePic" accept="image/*">
                            <input class="button" type="button" value="Reset" id="reset">
                        </div>
                        <div id="changeMainInfo" style="margin-left: 15px">
                            <input type="hidden" name="pfpPath" id="hiddenPfpPath">
                            <h2>Username</h2>
                            <input id="changeUsername" class="textarea" type="text" name="username">
                            <h2>Biography</h2>
                            <textarea id="changeBio" class="textarea" type="text" name="bio" style="height: 120px;width: 170px;"></textarea>
                        </div>
                    </div>
                    <br><button class="button" type="submit" name="updateProfile" id="updateButton">Update</button>
                </form>
            </div>
    <div id="mainContainer">
        <div id="mainProfileInfo" class="box">
        	<%
        	if(myProfile || role == 1){
        	%>
        		<img id='editButton' style="cursor: pointer" class='img' src='assets/icons/editButton/editButton0.png' width='50px' height='50px'>
        	<%
        	}
        	%>
            <div id="pfp">
            	<img id='profilePic' width='200px' height='200px'>
            	<div style='margin-left: 20px'><h1 id="usernameH1"></h1>
            	<h5>User ID: <%= requestedId %></h5></div>
            </div>
            <div id="info">
                <div id="score">
                    <h2 id="scoreH2">
                    </h2>
                </div>
                <div id="bio">
                	<h3>Biography:</h3>
                	<h4 id="bioH4"></h4>
                </div>
            </div>
        </div>
        <div id="userMadeCourses" class="box">
        	<h3>Courses made:</h3>
        	<div id="UserMadeCoursesResults" class="results">
        	</div>
        </div>
        <div id="completedCourses" class="box">
            <h3>Courses completed by this user:</h3>
            <div id="UserCompletedCoursesResults" class="results">
            </div>
        </div>
    </div>
</body>
</html>