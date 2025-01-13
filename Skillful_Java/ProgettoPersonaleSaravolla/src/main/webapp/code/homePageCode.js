$(document).ready(function(){
	$('#categoriesButton').click(function(){
        if($('#categories').attr('state') == 0){
            $('#categories').animate({
                'margin-top': '0px'
            }, 200)
            $('#categories').attr('state', 1);
        } else {
            $('#categories').animate({
                'margin-top': '-1000px'
            }, 200)
            $('#categories').attr('state', 0);
        }
    })
	
	var parameters=new URLSearchParams(window.location.search);
	var getParameter;
   	if(parameters.get("search") != null){
	   getParameter = parameters.get("search");
	   $.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getCoursesBySearch/' + getParameter, 
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
    			course.appendTo("#results");
			}
		}, 
		error: function(){
			console.log('errore')
		}
		})
   	} else if(parameters.get("category") != null){
		   getParameter = parameters.get("category");
	   $.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getCoursesByCategory/' + getParameter, 
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
    			course.appendTo("#results");
			}
		}, 
		error: function(){
			console.log('errore')
		}
		})
	 } else {
		 $.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getCourses', 
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
    			course.appendTo("#results");
			}
		}, 
		error: function(){
			console.log('errore')
		}
		})
	 }
	
	$.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getCategories', 
		success: function(data){
			console.log(data)
			for(var i = 0; i < data.length; i++){
				var category;
				category = "<a href='home.jsp?category=" + data[i].id + "'>" + data[i].name + "</a>";
    			category = $(category);
    			category.appendTo("#categories");
			}
		}, 
		error: function(){
			console.log('errore')
		}
	})
})