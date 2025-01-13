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
    <script src="code/courseCreatorCode.js"></script>
    <link rel="icon" href="assets/icons/logo.ico" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleCourseCreator.css">
    <title>Skillful</title>
</head>
<body>
	<%
	HttpSession sessione;
	sessione = request.getSession();
	if(sessione.getAttribute("user_id") == null){
		response.sendRedirect("login.jsp");
	}
	%>
    <a href='home.jsp' id="backButton"><img class="img" src="assets/icons/backButton/backButton0.png" width="50px" height="50px"></a>
    <img class="img" id="themeButton" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
    <div id="mainContainer">
        <form method="POST" action="http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler" enctype="multipart/form-data">
        <input type="hidden" name="action" value="creation">
        <div id="changeName">
                <h2>Give a name to your course</h2>
                <input type="text" name="name" class="input" required>
            </div>
            <div id="changeThumbnail">
                <h2>Choose a thumbnail for your course</h2>
                <div id="ThumbnailPreview">
                    <h3>Preview</h3>
                    <img src="assets/defaults/defaultThumbnail.png" id="preview" height="234px" width="416px">
                </div>
                <input id="thumbnail" type="file" name="thumbnail" accept="image/*">
                <input type="button" value="Reset" id="reset" class="button" style="font-size: 15px">
            </div>
            <div id="changeDesc">
                <h2>Add a description to this course</h2>
                <textarea name="desc"></textarea>
            </div>
            <div id="chooseCategory">
                <h2>Choose a category</h2>
                <select id="categories" name="category" class='input'>
                    <option selected disabled value=0></option>
                </select>
            </div>
            <div id="send">
                <button type="submit" class="button">Submit course</button>
            </div>
        </form>
    </div>
</body>
</html>