$(document).ready(function(){
    $('#editButton').click(function(){
        $('#editProfile').show();
    })
    $('#closeEditMenu').click(function(){
        $('#editProfile').hide();
    })
    var parameters=new URLSearchParams(window.location.search);
	var getParameter;
   	if(parameters.get("userid") != null){
	   getParameter = parameters.get("userid");
	   
	   $.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getUserById/' + getParameter,
		success: function(data){
			console.log(data)
			if(data.length == 1){
				document.getElementById("changeUsername").value = data[0].username;
				document.getElementById("changeBio").innerHTML = data[0].bio;
				document.getElementById("usernameH1").innerHTML = data[0].username;
				document.getElementById("bioH4").innerHTML = data[0].bio;
				document.getElementById("scoreH2").innerHTML = "Score: " + data[0].score;
				document.getElementById("preview").src = data[0].pfp;
				document.getElementById("hiddenPfpPath").value = data[0].pfp;
				document.getElementById("profilePic").src = data[0].pfp;
				changePfp(data[0].pfp);
				
			}
		}, 
		error: function(){
			console.log('errore')
		}
		})
	   
	   $.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getCoursesByUserCreated/' + getParameter, 
		success: function(data){
			console.log(data)
			for(var i = 0; i < data.length; i++){
				var course;
				course = "<a class='courseResult clickableBoxLink' href='viewCourse.jsp?courseId=" + data[i].id + "'><div class='courseDiv'>";
				if(data[i].verified == 1){
                    course += "<img class='verifiedIcon img' src='assets/icons/verifiedIcon/verifiedIcon0.png'>";
                } else if(data[i].state == 0){
                	course += "<img class='verifiedIcon img' src='assets/icons/lockIcon/lockIcon0.png'>";
               	}
				course += "<img class='courseThumbnail' src='" + data[i].folder + "thumbnail.png'><h2>" + data[i].name + "</h2><h5>Course ID: " + data[i].id + "<h3>By: " + data[i].username + "</h3></h5>";
				if(data[i].nComments > 0){
        			course += "<h4>Rating: " + data[i].avgRating + "⭐ (" + data[i].nComments + ")</h4>";
        		} else {
        			course += "<h4>No rating</h4>";
        		}
    			course += "</div></a>";
    			course = $(course);
    			course.appendTo("#UserMadeCoursesResults");
			}
			if(data.length == 0){
				var course = "<h2>User hasn't made any course yet</h2>";
				course = $(course);
    			course.appendTo("#userMadeCourses");
			}
		}, 
		error: function(){
			console.log('errore')
		}
		})
		
		$.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getCoursesCompletedByUser/' + getParameter, 
		success: function(data){
			console.log(data)
			for(var i = 0; i < data.length; i++){
				var course;
				course = "<a class='courseResult clickableBoxLink' href='viewCourse.jsp?courseId=" + data[i].id + "'><div class='courseDiv'>";
				if(data[i].verified == 1){
                    course += "<img class='verifiedIcon img' src='assets/icons/verifiedIcon/verifiedIcon0.png'>";
                } else if(data[i].state == 0){
                	course += "<img class='verifiedIcon img' src='assets/icons/lockIcon/lockIcon0.png'>";
               	}
				course += "<img class='courseThumbnail' src='" + data[i].folder + "thumbnail.png'><h2>" + data[i].name + "</h2><h5>Course ID: " + data[i].id + "<h3>By: " + data[i].username + "</h3></h5>";
				if(data[i].nComments > 0){
        			course += "<h4>Rating: " + data[i].avgRating + "⭐ (" + data[i].nComments + ")</h4>";
        		} else {
        			course += "<h4>No rating</h4>";
        		}
    			course += "</div></a>";
    			course = $(course);
    			course.appendTo("#UserCompletedCoursesResults");
			}
			if(data.length == 0){
				var course = "<h2>User hasn't completed any course yet</h2>";
				course = $(course);
    			course.appendTo("#completedCourses");
			}
		}, 
		error: function(){
			console.log('errore')
		}
		})
   	}
})

function changePfp(pfp){
	$('#pfp').change(function(){
                $('#preview').attr('src', window.URL.createObjectURL(this.files[0]))
            })
            $('#reset').click(function(){
                document.getElementById('pfp').value = '';
                $('#preview').attr('src', pfp);
            })
}