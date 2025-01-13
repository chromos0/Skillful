$(document).ready(function(){
	$.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getLeaderboard', 
		success: function(data){
			console.log(data)
			for(var i = 0; i < data.length; i++){
				var user = "<div class='leaderboardResult'><div class='left'><p>#" + (i+1) + "</p><img class='pfp' src='" + data[i].pfp + "'><a href='viewProfile.jsp?userid=" + data[i].id + "' class='username'>" + data[i].username + "</a></div><div class='right'><p>" + data[i].score + "</p></div></div>";
				user = $(user);
				user.appendTo("#leaderboard");
			}
			if(data.length == 0){
				user = "<h2>No users</h2>";
				user = $(user);
				user.appendTo("#leaderboard");
			}
		}, 
		error: function(e){
			console.log(e)
		}
	})
})