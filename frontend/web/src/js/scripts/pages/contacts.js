$(window).resize(function () {
    
    var distance2 = $('.header--two-variant .header-col_left').width();
    var distance = $('.header-ordering-wrap').width()-30;

    $('.js-page-paddings').css('padding-right',distance);
    $('.js-page-paddings').css('padding-left',distance2);

});

$(document).ready(function () {

    var distance2 = $('.header--two-variant .header-col_left').width();
    var distance = $('.header-ordering-wrap').width()-30;

    $('.js-page-paddings').css('padding-right',distance);
    $('.js-page-paddings').css('padding-left',distance2);

});

