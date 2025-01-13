$(document).ready(function(){
    
    var parameters=new URLSearchParams(window.location.search);
	var getParameter;
   	if(parameters.get("search") != null){
	   getParameter = parameters.get("search");
	   $.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getUsers/' + getParameter, 
		success: function(data){
			console.log(data)
			for(var i = 0; i < data.length; i++){
				var user = "<a class='userResult clickableBoxLink' href='viewProfile.jsp?userid=" + data[i].id + "'><img class='pfp' src='" + data[i].pfp + "'><h2>" + data[i].username + "</h2><h5>User id: " + data[i].id + "</h5></a>";
				user = $(user);
				user.appendTo("#results");
			}
			if(data.length == 0){
				user = "<h2>No results</h2>";
				user = $(user);
				user.appendTo("#results");
			}
		}, 
		error: function(e){
			console.log(e)
		}
		})
   	}
})