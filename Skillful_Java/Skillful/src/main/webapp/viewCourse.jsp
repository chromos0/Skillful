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
    <script src="code/courseViewerCode.js"></script>
    <link rel="icon" href="assets/icons/logo.ico" type="image/x-icon"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/styleCourseViewer.css">
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
	int chapter = 1;
	if(request.getParameter("chapter") != null){
		chapter = Integer.parseInt(request.getParameter("chapter"));
	}
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
	if(sessione.getAttribute("grantViewAccess") == null && sessione.getAttribute("courseDoesntExist") == null && sessione.getAttribute("noAccess") == null){
		response.sendRedirect("http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler?courseid=" + requestedId + "&chapter=" + chapter + "&grantViewAccess=a");
	} else {
		if(sessione.getAttribute("grantViewAccess") != null){
			if((int)sessione.getAttribute("grantViewAccess") == requestedId){
				accessGranted = true;
			}
			sessione.removeAttribute("grantViewAccess");
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
        <img class="img cursorPointer" id="themeButton" src="assets/icons/themeButton/themeButton0.png" width="50px" height="50px">
        <a href="home.jsp" id="homeButton">
            <img class="img" src="assets/icons/homePageButton/homePage0.png" width="50px" height="50px">
        </a>
    <% if(accessGranted){ %>
    <div id="mainContainer">
        <div id="mainInfo" class="box">
        <h1 id="courseName" style="margin: 0"></h1>
        <h5 style="margin-top: 0">Course ID: <%= requestedId %></h5>
        <a id="creatorProfileLink" style="text-decoration: none; color: var(--textcolor); width: fit-content; display: block" href="">
        	<h2 style="width: fit-content" id="creatorUsername"></h2>
        </a>
        <h3>Description:</h3>
        <h4 id="courseDescription"></h4>
        <img id="thumbnail" src="">
        <script>
        var folder;
        var nChapters;
        $(document).ready(function(){
        	$.ajax({
        		type:'POST', 
        		contentType: 'application/json',
        		url: 'http://localhost:8080/getCourseById/' + <%= requestedId %>, 
        		success: function(data){
        			console.log(data)
        			if(data.length == 1){
        				folder = data[0].folder;
        				document.getElementById("courseName").innerHTML = data[0].name;
        				document.getElementById("creatorProfileLink").href = "viewProfile.jsp?userid=" + data[0].user_created;
        				document.getElementById("creatorUsername").innerHTML = "By " + data[0].username;
        				document.getElementById("courseDescription").innerHTML = data[0].description;
        				document.getElementById("thumbnail").src = data[0].folder + "thumbnail.png";
        				if(<%= role == 1 %> || data[0].user_created == <%= user_id %>){
        					console.log("i made this course");
        					var editCourse = "<img id='editButton' class='img cursorPointer' src='assets/icons/optionsButton/optionsButton0.png'><div id='editButtonsContainer' class='hidden'><a href = 'editCourse.jsp?courseId=" + data[0].id + "'><img class='img editButtons' src='assets/icons/editButton/editButton0.png'></a><br><img id='deleteButton' class='img editButtons cursorPointer' src='assets/icons/deleteButton/deleteButton0.png'></div><div id='confirmDeleteContainer' class='hidden'><h2 style='margin-bottom: 75px'>Are you sure you want to delete this course?</h2><div id='options'><form action='http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler' method='POST' style='margin-left: 30px'><input type='hidden' name='action' value='deleteCourse'><input type='hidden' name='folder' value='" + data[0].folder + "'><button type='submit' value=" + data[0].id + " id='yes' class='cursorPointer' name='deleteCourse'><h2>Yes</h2></button></form><h2 style='margin-right: 30px' class='cursorPointer' id='no'>No</h2></div></div>";
        					editCourse = $(editCourse);
        					editCourse.appendTo("#mainInfo");
        					canEditCourse();
        				}
        				nChapters = data[0].nChapters;
        				getChapters();
        			}
        		}, 
        		error: function(){
        			console.log('errore')
        		}
        		})
        	function canEditCourse(){
        		$('#editButton').click(function(){
        	        if($('#editButtonsContainer').is(':visible')){
        	            $('#editButtonsContainer').hide();
        	        } else {
        	            $('#editButtonsContainer').show();
        	        }
        	    })

        	    $('#deleteButton').click(function(){
        	        $('#confirmDeleteContainer').show();
        	    })

        	    $('#no').click(function(){
        	        $('#confirmDeleteContainer').hide();
        	    })
        	}
        })
        </script>
                    
        
        </div>
        <div id="chapterSelector" class="box">
        	<script>
        	<% 
        	boolean finalChapter = false;
        	%>
        	function getChapters(){
        		$.ajax({
        			type:'POST', 
        			contentType: 'application/json',
        			url: 'http://localhost:8080/getChaptersForCourse/' + <%= requestedId %>, 
        			success: function(data){
        				console.log(data);
        				
        				if(data.length > 0){
        					var i = 1;
        					var chaptersDiv = "<h2>Select Chapter:<h2><div id='chapters'></div>";
        					chaptersDiv = $(chaptersDiv);
        					chaptersDiv.appendTo("#chapterSelector");
        					for(i = 1; i <= data.length; i++){
            					var chapter = "<a class='selectChapterButton' href='viewCourse.jsp?courseId=" + <%= requestedId %> + "&chapter=" + i + "'><h3>" + i + "</h3></a>";
            					chapter = $(chapter);
            					chapter.appendTo("#chapters");
            					if(i == <%= chapter %>){
            						var chapterContainer = "<div id='chapterContainer'><h1>" + data[i-1].name + "</h1><div id='presentation'>";
            						if(data[i-1].fileExists){
            							var file = folder + "chapter" + i + "/presentation.pdf";
                						chapterContainer += "<iframe src='" + file + "' width='100%' height='700px' onerror='this.parentElement.remove()'></iframe>";
            						} else {
            							chapterContainer += "<h2>No presentation found</h2>";
            						}
            						chapterContainer += "</div></div>";
            						chapterContainer = $(chapterContainer);
            						chapterContainer.appendTo("#chapterContent");
            					}
            				}
        					if(data.length == <%= chapter %>){
        						console.log("final chapter");
        						getFinalQuiz();
        					} else {
        						$("#finalQuiz").addClass("hidden");
        					}
        				} else {
        					var noChapters = "<h2>No chapters found</h2>";
        					noChapters = $(noChapters);
        					noChapters.appendTo("#chapterSelector");
        				}
        			}, 
        			error: function(){
        				console.log('errore');
        			}
        		})
        	}
        	</script>
        </div>
        <div id="chapterContent" class="box" class="box">
        </div>
        <div class='box' id='finalQuiz'>
        <script>
       	function getFinalQuiz(){
        	$.ajax({
        		type:'POST', 
        		contentType: 'application/json',
        		url: 'http://localhost:8080/getScore/' + <%= requestedId %> + "/" + <%= user_id %>, 
        		success: function(data){
        			console.log(data)
        			if(data.length == 1){
        				var examResult = "<h2>You already completed the final quiz for this course with a score of " + data[0].score + "/" + data[0].nQuestions + "</h2>";
        				examResult = $(examResult);
        				examResult.appendTo("#finalQuiz");
        			} else if(data.length == 0){
        				$.ajax({
        					type:'POST', 
        					contentType: 'application/json',
        					url: 'http://localhost:8080/getQuestionsForCourse/' + <%= requestedId %>, 
        					success: function(data){
        						console.log(data)
        						var finalQuiz = "<h1>Final quiz</h1><form id='quizForm' action='http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler' method='POST' id='finalQuiz'><input type='hidden' name='nQuestions' value=" + data.length + "><input type='hidden' name='course_id' value='" + <%= requestedId %> + "'></form>";
        						finalQuiz = $(finalQuiz);
        						finalQuiz.appendTo("#finalQuiz");
        						for(var i = 0; i < data.length; i++){
        							var question = "<div class='question' id='question" + i + "'><input type='hidden' value='" + data[i].id + "' name='questionId" + i + "'><h2>" + data[i].question + "</h2><br></div>";
        							question = $(question);
        							question.appendTo("#quizForm");
        							getAnswers(data[i].id, i);
        						}
        						var submitButton = "<button type='submit' name='quizSubmission' id='submitAnswersButton'>Submit answers</button>";
        						submitButton = $(submitButton);
        						submitButton.appendTo("#quizForm");
        					}, 
        					error: function(){
        						console.log('errore')
        					}
        				})
        			}
        		}, 
        		error: function(){
        			console.log('errore')
        		}
        		})
        }
        
        function getAnswers(id, i){
        	$.ajax({
        		type:'POST', 
        		contentType: 'application/json',
        		url: 'http://localhost:8080/getAnswersForQuestion/' + id, 
        		success: function(data){
        			console.log(data);
        			var answers = "<ul id='answersForQuestion" + i + "'></ul>";
        			answers = $(answers);
        			answers.appendTo("#question" + i);
        			for(var j = 0; j < data.length; j++){
        				$("<input type='hidden' value='" + data.length + "' name='nAnswersForQuestion" + i + "'><ul>").appendTo("answersForQuestion" + i);
        				var answer = "<li><input type='radio' value='" + data[j].id + "' name='selectedAnswer" + i + "'><h3 class='answer'>" + data[j].answer + "</h3></li><br>";
        				answer = $(answer);
        				answer.appendTo("#answersForQuestion" + i);
        			}
        		}, 
        		error: function(){
        			console.log('errore')
        		}
        	})
        }
        </script>
        </div>
        <div id="commentsAreaContainer" class="box" style="width: 99%">
            <h2>Comments</h2>
            <div id="addComment">
                <form action="http://localhost:8082/ProgettoPersonaleSaravolla/CommentsHandler" method="POST">
                <input type="hidden" name="action" value="addComment">
                <input type="hidden" name="courseId" value="<%= requestedId %>">
                    <input required type="text" placeholder="Add a comment..." name="comment">
                    <label for="rating">Rate: </label>
                    <select name="rate" id="rating">
                        <option value=0>0⭐</option>
                        <option value=0.5>0.5⭐</option>
                        <option value=1>1⭐</option>
                        <option value=1.5>1.5⭐</option>
                        <option value=2>2⭐</option>
                        <option value=2.5>2.5⭐</option>
                        <option value=3>3⭐</option>
                        <option value=3.5>3.5⭐</option>
                        <option value=4>4⭐</option>
                        <option value=4.5>4.5⭐</option>
                        <option selected value=5>5⭐</option>
                    </select>
                    <button type="submit" id="submitComment">Submit comment</button>
                </form>
            </div>
            <div id="comments">
            	<script>
            	$.ajax({
        			type:'POST', 
        			contentType: 'application/json',
        			url: 'http://localhost:8080/getCommentsForCourse/' + <%= requestedId %>, 
        			success: function(data){
        				console.log(data);
        				if(data.length > 0){
        					var commentsBox = "<div id='commentsResults'></div>"
        					commentsBox = $(commentsBox);
        					commentsBox.appendTo("#comments");
        					for(i = 0; i < data.length; i++){
        						var comment = "<div id=" + data[i].id + " class='comment'><div class='userInfo'><img class='userPfp' width='70px' height='70px' src='" + data[i].pfp + "'><div class='infoContainer'><a href='viewProfile.jsp?userid=" + data[i].id_user + "'><h2>" + data[i].username + "</h2></a><h3>" + data[i].rating + "⭐</h3></div></div><h4>" + data[i].comment + "</h4>";
        						if(data[i].id_user == <%= user_id %> || <%= role %> == 1){
        							comment += "<img style='width: 30px; height: 30px' class='img edit' id=" + data[i].id + " src='assets/icons/deleteButton/deleteButton0.png'>";
        						}
        						comment += "</div>";
        						comment = $(comment);
        						comment.appendTo("#commentsResults");
            				}
        					canDeleteComment();
        				} else {
        					var noComments = "<h2>No comments yet</h2>";
        					noComments = $(noComments);
        					noComments.appendTo("#comments");
        				}
        			}, 
        			error: function(){
        				console.log('errore');
        			}
        		})
        		function canDeleteComment(){
            		$(".edit").click(function(){
            			window.location.replace("http://localhost:8082/ProgettoPersonaleSaravolla/CommentsHandler?id=" + $(this).attr("id"));
            		})
            	}
            	</script>
            </div>
        </div>
    </div>
    <% } else if(courseDoesntExist){ %>
    <div id="noAccessContainer" style="width: 100%; text-align: center; margin-top: 50px">
        <h1>This course doesn't exist</h1>
    </div>
    <% } else { %>
    <div id="noAccessContainer" style="width: 100%; text-align: center; margin-top: 50px">
        <h1>You don't have access to this course</h1>
    </div>
    <% } %>
</body>