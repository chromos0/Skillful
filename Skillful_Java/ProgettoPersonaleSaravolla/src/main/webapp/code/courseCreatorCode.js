$(document).ready(function(){
	$("#thumbnail").change(function(){
        $('#preview').attr('src', window.URL.createObjectURL(this.files[0]))
    })
    $('#reset').click(function(){
        console.log('aifhiasfh');
        document.getElementById('thumbnail').value = '';
        $('#preview').attr('src', 'assets/defaults/defaultThumbnail.png');
    })
	
	$.ajax({
		type:'POST', 
		contentType: 'application/json',
		url: 'http://localhost:8080/getCategories', 
		success: function(data){
			console.log(data)
			for(var i = 0; i < data.length; i++){
				var category;
				category = "<option value='" + data[i].id + "'>" + data[i].name + "</option>";
    			category = $(category);
    			category.appendTo("#categories");
			}
		}, 
		error: function(){
			console.log('errore')
		}
	})
})