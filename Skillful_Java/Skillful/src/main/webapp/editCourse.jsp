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
    <script src="code/editCourseCode.js"></script>
    <link rel="icon" href="assets/icons/logo.ico" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleCourseViewer.css">
    <link rel="stylesheet" type="text/css" href="styles/styleCourseEditor.css">
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
	if(request.getParameter("courseId") != null){
		requestedId = Integer.parseInt(request.getParameter("courseId"));
	} else {
		response.sendRedirect("home.jsp");
	}
	if(sessione.getAttribute("user_id") == null){
		response.sendRedirect("login.jsp");
	} else {
		user_id = (int)sessione.getAttribute("user_id");
		profilePic = (String)sessione.getAttribute("pfp");
		role = (int)sessione.getAttribute("role");
	}
	boolean accessGranted = false;
	boolean courseDoesntExist = false;
	if(sessione.getAttribute("grantEditAccess") == null && sessione.getAttribute("courseDoesntExist") == null && sessione.getAttribute("noAccess") == null){
		response.sendRedirect("http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler?courseid=" + requestedId + "&grantEditAccess=a");
	} else{
		if(sessione.getAttribute("grantEditAccess") != null){
			if((int)sessione.getAttribute("grantEditAccess") == requestedId){
				accessGranted = true;
			}
			sessione.removeAttribute("grantEditAccess");
		} else if(sessione.getAttribute("courseDoesntExist") != null){
			if((int)sessione.getAttribute("courseDoesntExist") == requestedId){
				courseDoesntExist = true;
			}
			sessione.removeAttribute("courseDoesntExist");
		} else {
			sessione.removeAttribute("noAccess");
		}
	}
	%>
	<% if(accessGranted){ %>
    <a href='viewCourse.jsp?courseId=<%= requestedId %>' id="backButton"><img class="img" src="assets/icons/backButton/backButton0.png" width="50px" height="50px"></a>
    <img class="img cursorPointer" id="themeButton" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
    <div id="mainContainer">
        <div id="mainInfo" class='box'>
        	<form action='http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler' method='POST' id='verification'><input type='hidden' name='courseId' value = "<%= requestedId %>">
        		<input type="hidden" name="action" value="verification">
        		<div id="publish">
                </div>
                <br>
                <% if(role == 1) { %>
                <div id="verify">
                </div>
                <% } %>
            </form>
            <form method="POST" action="http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler" enctype="multipart/form-data" id="editMainInfoForm">
            	<input type="hidden" name="action" value="editMainInfo">
                <input type="hidden" name="courseId" value="<%= requestedId %>">
                <input type="hidden" name="folder" value='' id="folderHiddenInput">
                <h2>Course name</h2>
                <input type='text' class='input' name='courseName' value='' id="courseNameInput">
                <h5 style="margin-top: 0" id="courseIdH5">Course ID: </h5><h2 id="courseCreatorH2">By </h2><h3>Description:</h3>
                <textarea name='description' id="descriptionTextarea"></textarea><br>
                <img id="preview" src="" width="512px" height="288px"><br>
                <input id="thumbnailInput" type="file" name="thumbnail" accept="image/*">
                <input class="button" type="button" value="Reset" id="reset">
                <br><button type="submit" name="mainInfo">Update</button>
            </form>
        </div>
        <div id="chaptersEditor" class="box">
            <div id="chapters">
            </div>
        </div>
        <div id="finalQuizEditor" class="box">
        <br><h2 id='createQuiz'>Final quiz</h2>
        <br>
        <form action='http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler' method='POST' id='finalQuiz'>
        <input type="hidden" name="courseId" value="<%= requestedId %>">
        <div id='quizGrid'>
        	
        </div>
        <button type='submit' name='addQuestion' value='<%= requestedId %>'>Add question</button><br>
        <button type='submit' name='updateQuiz' style='margin-top: 10px'>Update quiz</button>
        </form>
        </div>
    </div>
    <% } else if(courseDoesntExist){ %>
    <img class="img cursorPointer" id="themeButton" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
    <a href="home.jsp" id="homeButton">
        <img class="img" src="assets/icons/homePageButton/homePage0.png" width="50px" height="50px">
    </a>
    <div id="noAccessContainer" style="width: 100%; text-align: center; margin-top: 50px">
        <h1>This course doesn't exist</h1>
    </div>
    <% } else { %>
    <img class="img cursorPointer" id="themeButton" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
    <a href="home.jsp" id="homeButton">
        <img class="img" src="assets/icons/homePageButton/homePage0.png" width="50px" height="50px">
    </a>
    <div id="noAccessContainer" style="width: 100%; text-align: center; margin-top: 50px">
        <h1>You don't have access to this course</h1>
    </div>
    <% } %>
</body>