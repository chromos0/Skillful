$(document).ready(function(){
    $("#pfp").change(function(){
        $('#preview').attr('src', window.URL.createObjectURL(this.files[0]))
    })
    $('#reset').click(function(){
        document.getElementById('pfp').value = '';
        $('#preview').attr('src', 'assets/defaults/defaultPFP.png');
    })
})