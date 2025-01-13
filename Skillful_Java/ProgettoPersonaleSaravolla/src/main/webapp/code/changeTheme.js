var theme = [
    {
        'primary' : '#171717',
        'textcolor' : '#fbdaff',
        'windowbg' : '#09002e',
        'boxbg' : '#270042'
    },
    {
        'primary' : '#ffffff',
        'textcolor' : '#000350',
        'windowbg' : '#ccebfe',
        'boxbg' : '#e3f7fe'
    }
]

var selectedTheme = 0;

if(localStorage.getItem('selectedTheme')){
    selectedTheme = localStorage.getItem('selectedTheme');
} else {
    localStorage.setItem('selectedTheme', 0);
}

$(document).ready(function(){
    loadTheme(selectedTheme);
    $('#themeButton').click(function(){
        if(selectedTheme == 0){
            loadTheme(1);
            selectedTheme = 1;
        } else {
            loadTheme(0);
            selectedTheme = 0;
        }
        localStorage.setItem('selectedTheme', selectedTheme);
    })
})

function setStratingTheme(sel){
    selectedTheme = sel;
}

function loadTheme(sel){
    $('html').css({
        '--primary': theme[sel].primary,
        '--textcolor': theme[sel].textcolor,
        '--windowbg': theme[sel].windowbg,
        '--boxbg': theme[sel].boxbg
    });
    $('.img').each(function(index, img){
        $(img).attr('src', $(img).attr('src').slice(0, -5) + sel + '.png');
    })
}