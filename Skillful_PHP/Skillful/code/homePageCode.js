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
})