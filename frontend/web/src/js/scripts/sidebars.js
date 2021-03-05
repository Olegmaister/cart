var overlay = $('#overlay');

$(document).on('click', '.js-toggle-sidebar', function() {

    if($(this).next().css('left') == '-331px') {
        $(this).next().css('left','-14px');
        overlay.fadeIn(400);
    } else {
        $(this).next().css('left','-331px');
        overlay.fadeOut(400);
    }

});

$(document).on('click', '#overlay', function() {
    $('.js-toggle-sidebar').next().css('left','-331px');
    overlay.fadeOut(400);
});

$(document).on('click', '.js-toggle-sidebar-close', function() {
    $('.js-toggle-sidebar').next().css('left','-331px');
    overlay.fadeOut(400);
});