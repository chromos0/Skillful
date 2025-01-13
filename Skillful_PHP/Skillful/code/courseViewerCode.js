$(document).ready(function(){
    $('#editButton').click(function(){
        if($('#editButtonsContainer').is(':visible')){
            $('#editButtonsContainer').hide();
        } else {
            $('#editButtonsContainer').show();
        }
    })

    $('#deleteButton').click(function(){
        $('#confirmDeleteContainer').show();
    })

    $('#no').click(function(){
        $('#confirmDeleteContainer').hide();
    })
})