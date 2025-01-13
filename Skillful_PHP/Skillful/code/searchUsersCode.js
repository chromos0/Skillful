$(document).ready(function(){
    $('#optionsButton').click(function(){
        if($('#optionsButton').attr('state') == 0){
            $('#options').animate({
                rotate: '-90deg'
            }, 200);
            $('#optionsBar').animate({
                'right': '0px'
            }, 200)
            $('#optionsButton').attr('state', 1);
        } else {
            $('#options').animate({
                rotate: '0deg'
            }, 200);
            $('#optionsBar').animate({
                'right': '-1000px'
            }, 200)
            $('#optionsButton').attr('state', 0);
        }
    })
})