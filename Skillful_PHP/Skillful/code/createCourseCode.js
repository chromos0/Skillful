$(document).ready(function(){
    $("#thumbnail").change(function(){
        $('#preview').attr('src', window.URL.createObjectURL(this.files[0]))
    })
    $('#reset').click(function(){
        console.log('aifhiasfh');
        document.getElementById('thumbnail').value = '';
        $('#preview').attr('src', 'assets/defaults/defaultThumbnail.png');
    })
})