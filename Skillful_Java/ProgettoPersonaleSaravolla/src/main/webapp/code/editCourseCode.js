var gotCourse = false;
var folder;
var parameters=new URLSearchParams(window.location.search);
var getParameter;
if(parameters.get("courseId") != null)
	getParameter = parameters.get("courseId");

$(document).ready(function(){
	$.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getCourseById/' + getParameter, 
		success: function(data){
			console.log(data)
			if(data.length == 1){
				folder = data[0].folder;
				gotCourse = true;
				var button;
				if(data[0].state == 0){
					button = "<button type='submit' name='publish'>Publish Course</button>";
				} else {
					button = "<button type='submit' name='private'>Set course as private</button>";
				}
				button = $(button);
				button.appendTo("#publish");
				var button2;
				if(data[0].verified == 0 && data[0].state == 1){
					button2 = "<button type='submit' name='verify'>Verify course</button>";
				} else if(data[0].verified == 1 && data[0].state == 1){
					button2 = "<button type='submit' name='unverify'>Unverify course</button>";
				}
				button2 = $(button2);
				button2.appendTo("#verify");
				document.getElementById("folderHiddenInput").value = data[0].folder;
				document.getElementById("courseNameInput").value = data[0].name;
				document.getElementById("courseIdH5").innerHTML = "Course ID: " + data[0].id;
				document.getElementById("courseCreatorH2").innerHTML = "By " + data[0].username;
				document.getElementById("descriptionTextarea").innerHTML = data[0].description;
				document.getElementById("preview").src = folder + "thumbnail.png";
				
				getChapters();
			}
		}, 
		error: function(){
			console.log('errore')
		}
	})
	
	$.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getQuestionsForCourse/' + getParameter, 
		success: function(data){
			console.log(data)
			for(var i = 0; i < data.length; i++){
				var question = "<div class='question'><input type='hidden' value='" + data[i].id + "' name='questionId" + i + "'><input type='text' class='input' value='" + data[i].question + "' class='question' name='question" + i + "'><button class='deleteButton' type='submit' name='deleteQuestion' value='" + data[i].id + "'><img class='deleteQuestion img' height='30px' width='30px' src='assets/icons/deleteButton/deleteButton0.png'></button><br><div><br><ul id='answersForQuestion" + i + "'></ul></div><button type='submit' name='addAnswer' value='" + data[i].id + "'>Add answer</button></div>";
				question = $(question);
				question.appendTo("#quizGrid");
				getAnswers(data[i].id, i);
			}
		}, 
		error: function(){
			console.log('errore')
		}
	})
	
	$('#thumbnailInput').change(function(){
        $('#preview').attr('src', window.URL.createObjectURL(this.files[0]))
    })
    $('#reset').click(function(){
        document.getElementById('thumbnailInput').value = '';
        $('#preview').attr('src', folder + 'thumbnail.png');
    })
})

function getAnswers(id, i){
	$.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getAnswersForQuestion/' + id, 
		success: function(data){
			console.log(data);
			for(var j = 0; j < data.length; j++){
				$("<input type='hidden' value='" + data.length + "' name='nAnswersForQuestion" + i + "'><ul>").appendTo("answersForQuestion" + i);
				var answer = "<input type='hidden' value='" + data[j].id + "' name='answerId" + j + "question" + i + "'><li><input type='text' class='input' value='" + data[j].answer + "' class='answer' name='answer" + j + "question" + i + "'><input type='radio' value='" + j + "' name='rightAnswerForQuestion" + i + "'";
				if(data[j].correct == 1){
					answer += " checked";
				}
				answer += "><button class='deleteButton' type='submit' name='deleteAnswer' value='" + data[j].id + "'><img class='deleteAnswer img' height='30px' width='30px' src='assets/icons/deleteButton/deleteButton0.png'></button></li><br>";
				answer = $(answer);
				answer.appendTo("#answersForQuestion" + i);
			}
		}, 
		error: function(){
			console.log('errore')
		}
	})
}

function getChapters(){
	$.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getChaptersForCourse/' + getParameter, 
		success: function(data){
			console.log(data);
			var i = 1;
			for(i = 1; i <= data.length; i++){
				var currentChapterFolder = folder + "chapter" + i + "/";
				var singleChapterEditorBox = "<div class='chapter' id='chapter" + i + "'><h2>Chapter " + i + "</h2><form method='POST' action='http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler' enctype='multipart/form-data'><input type='hidden' name='action' value='updateChapter'><input type='hidden' name='folder' value='" + currentChapterFolder + "'><input type='hidden' name='chapterNumber' value='" + i + "'><input type='hidden' name='chapterId' value='" + data[i-1].id + "'><input type='text' class='input' name='chapterName' placeholder='Chapter Name' value='" + data[i-1].name + "'><br><input type='file' class='fileInput' name='presentation' accept='application/pdf'><br><a href='" + currentChapterFolder + "presentation.pdf' download='chapter" + i +"'>Download current presentation</a><br><button type='submit' name='updatingCourse'>Update</button></form>";
				if(i == data.length){
                    singleChapterEditorBox += "<br><form action='http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler' method='POST'><input type='hidden' name='action' value='removeChapter'><input type='hidden' name='chapterNumber' value = " + i + "><input type='hidden' name='chapterId' value = " + data[i-1].id + "><input type='hidden' name='folder' value='" + folder + "'><button type='submit' name='removeChapter'>Remove Chapter</button></form>";
                }
                singleChapterEditorBox += "</div>";
                singleChapterEditorBox = $(singleChapterEditorBox);
                singleChapterEditorBox.appendTo("#chapters");
			}
			var addChaptersButton = "<br><form action='http://localhost:8082/ProgettoPersonaleSaravolla/CourseHandler' method='POST'><input type='hidden' name='action' value='addChapter'><input type='hidden' name='courseId' value='" + getParameter + "'><input type='hidden' name='chaptersNumber' value = " + i + "><input type='hidden' name='folder' value='" + folder + "'><button type='submit' name='addChapter'>Add Chapter</button></form>";
			addChaptersButton = $(addChaptersButton);
			addChaptersButton.appendTo("#chaptersEditor");
		}, 
		error: function(){
			console.log('errore');
		}
	})
}