$(document).ready(function(){
    /*$('#createQuiz').click(function(){
        $('#createQuiz').hide();
        $('#finalQuiz').show();
    })

    $('.addAnswer').click(function(){
        var questionId = $(this).attr('question');
        $.ajax({
            url: 'updateCourse.php',
            type: 'POST',
            data: {
                question: questionId,
                addAnswer: '',
            },
            success: function(response) {
                console.log('Response:', response);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    })

    $('.deleteAnswer').click(function(){
        var answerId = $(this).attr('id');
        $.ajax({
            url: 'updateCourse.php',
            type: 'POST',
            data: {
                id: answerId,
                deleteAnswer: '',
            },
            success: function(response) {
                console.log('Response:', response);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    })

    $('.addQuestion').click(function(){
        var courseId = $(this).attr('course');
        $.ajax({
            url: 'updateCourse.php',
            type: 'POST',
            data: {
                course: courseId,
                addQuestion: '',
            },
            success: function(response) {
                console.log('Response:', response);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    })

    $('.deleteQuestion').click(function(){
        var questionId = $(this).attr('id');
        $.ajax({
            url: 'updateCourse.php',
            type: 'POST',
            data: {
                id: questionId,
                deleteQuestion: '',
            },
            success: function(response) {
                console.log('Response:', response);
                window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });
    })*/
})