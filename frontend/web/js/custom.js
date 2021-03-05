//$(document).ready(function(){
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
        $('body').addClass('ios');
    };
    $('body').removeClass('loaded');

    $('.header-cat__but').click(function(){
        if ($(this).next().css('display') == 'block')
        {
            $(this).next().slideUp( "fast", function() {});
            $(this).removeClass('b_arrow_up');
            $(this).parent().parent().nextAll().find('.header-cat__nav').prev().removeClass('b_arrow_up');
        }
        else
        {
            $(this).next().slideDown( "fast", function() {});
            $(this).addClass('b_arrow_up');

            $(this).parent().parent().prevAll().find('.header-cat__nav').slideUp( "fast", function() {}).prev().removeClass('b_arrow_up');
            $(this).parent().parent().nextAll().find('.header-cat__nav').slideUp( "fast", function() {}).prev().removeClass('b_arrow_up');
        }
    });

    //header cart popup - show, hidden
    $('.header-ordering__icon.header-ordering__icon_cart').click(function(){
        $('.header-options-col').removeClass('_overflow_hidden');
        $('.switch ').removeClass('_show b_arrow_up');
        $(this).next().toggleClass('_show');
        $('.header-row_bot').removeClass('search-form_show');
    });

    //menu catalog - show, hidden
    $('.header-cat__show').click(function(){
        $(this).css('display','none');
        $('.header-cat__show._hidden').css('display','block');
        $(this).prev().toggleClass('_show');
        $(this).parent().parent().parent().toggleClass('_show');
    });
    $('.header-cat__show._hidden').click(function(){
        $('.header-cat__show').css('display','block');
        $(this).parent().parent().toggleClass('_show');
        $(this).parent().parent().parent().parent().parent().toggleClass('_show');
    });

    //BURGERS BUTTON MOBILE
    $('.js-toggle-show.js-toggle-show_cat').click(function () {
        $(this).next().toggleClass('hidden-content_show');

        $('.header-burgers').find('.search-form_mob').removeClass('hidden-content_show');
        overlay_search.fadeOut(400);
        $('.header-burger-content').removeClass('hidden-content_show');
        $('.cart-m-popup').removeClass('_show');
    });
    //search
    $('.js-toggle-show.js-toggle-show_search').click(function(){
        $('.header-burgers').find('.search-form_mob').addClass('hidden-content_show');
        overlay_search.fadeIn(400);
        $('.cart-m-popup').removeClass('_show');
    });
    $('#overlay-search').click(function () {
        $('.search-form_mob').removeClass('hidden-content_show');
        overlay_search.fadeOut(400);
        $('.cart-m-popup').removeClass('_show');
    });
    //menu
    $('.js-toggle-show.js-toggle-show_menu').click(function(){
        $(this).next().toggleClass('hidden-content_show');

        $('.header-burgers').find('.search-form_mob').removeClass('hidden-content_show');
        overlay_search.fadeOut(400);
        $('.header-cat-menu').removeClass('hidden-content_show');
        $('.cart-m-popup').removeClass('_show');
    });

    /****** Selects */ 
    $('.s_select_box_value').click(function() {
        $('.cart-m-popup').removeClass('_show');
        $(this).parent().toggleClass('_show b_arrow_up');
        $(this).parent().parent().toggleClass('_overflow_hidden');

        $(this).parent().parent().nextAll().removeClass('_overflow_hidden').find('.switch ').removeClass('_show b_arrow_up');
        $(this).parent().parent().prevAll().removeClass('_overflow_hidden').find('.switch ').removeClass('_show b_arrow_up');

        $('.header-row_bot').removeClass('search-form_show');
    });
    $('li').click(function() {
        $(this).nextAll().removeClass('selected');
        $(this).prevAll().removeClass('selected');
        $(this).addClass('selected');
        $(this).closest(".s_select_box").find('.s_select_box_value span').text($(this).text()).parent().parent().removeClass('_show b_arrow_up');
        $(this).parent().parent().parent().parent().removeClass('_overflow_hidden');
    });

    //SEARCH - HIDDEN/SHOW
    $('.header-ordering-col_search').click(function () {
        $('.header-row_bot').addClass('search-form_show');

        $('.cart-m-popup').removeClass('_show');
        $('.switch').removeClass('_show b_arrow_up')
    });
    $('.search-form__close').click(function () {
        $('.header-row_bot').removeClass('search-form_show');
    });

    //SIZES CHECK
    $('.product-card-slider-wrap__item').click(function () {
        $(this).addClass('_active');
        $(this).prevAll().removeClass('_active');
        $(this).nextAll().removeClass('_active');
    });

    /****** POPUP */
    var overlay = $('#overlay');
    var overlay_search = $('#overlay-search');
    var open_modal = $('.s_open_modal');
    var close = $('.modal__close, #overlay');
    var modal = $('.modal_div');

    open_modal.click( function(event){
        event.preventDefault();
        var div = $(this).attr('href');
        overlay.fadeIn(400,
            function(){
                $(modal)
                    .css('display', 'block')
                    .animate({opacity: 1, top: '0'}, 200);
            });
    });
    close.click( function(){
        modal
            .animate({opacity: 0}, 200,
                function(){
                    $(this).css('display', 'none');
                    overlay.fadeOut(400);
                }
            );
    });
    //TABS
    $('ul.s_tabs_list').each(function() {
        $(this).find('li').each(function(i) {
            $(this).click(function(){
                $(this).addClass('active').siblings().removeClass('active')
                    .closest('section.s_tabs').find('div.s_tabs_content').removeClass('active').eq(i).addClass('active');
            });
        });
    });

    //CLICK body
    $('body').click(function (e) {
        if($(e.target).closest(".s_select_box_value,.header-ordering__icon_cart,.cart-m-popup,.header-ordering__icon_search,.search-form__but,.js-toggle-show,.hidden-content_show").length==0) {
            $('.switch').removeClass('_show b_arrow_up');
            $('.cart-m-popup').removeClass('_show');
            $('.header-options-col').removeClass('_overflow_hidden');
            $('.header-row_bot').removeClass('search-form_show');
            $('.hidden-content_hidden').removeClass('hidden-content_show');
        }
    });
    
    $('.slider-main-wrap').slick({ 
        arrows: true,
        dots: false,
        slidesToShow: 1,
        slidesToScroll: 1,
        appendArrows:'.slider-arrows',
        prevArrow:'.slider-arrow.slider-arrow__prev',
        nextArrow:'.slider-arrow.slider-arrow__next'
    });
    $('.brands-slider-wrap').slick({
        centerMode: false,
        arrows: true,
        dots: false,
        slidesToShow: 6,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        appendArrows:'.brands-arrows',
        prevArrow:'.brands-arrows__arrow.brands-arrows__arrow_prev',
        nextArrow:'.brands-arrows__arrow.brands-arrows__arrow_next',
        responsive:
        [
          {
            breakpoint: 1279, 
            settings: {
              slidesToShow: 6
            }
          },
          {
            breakpoint: 1023, 
            settings: {
              slidesToShow: 4
            }
          },
          {
            breakpoint: 766, 
            settings: {
              slidesToShow: 2 
            }
          }
        ]
    });
    $('.product-card-slider-wrap').slick({
        centerMode: false,
        arrows: true,
        dots: false,
        slidesToShow: 7,
        slidesToScroll: 1,
        appendArrows:'.product-card-slider-arrows',
        prevArrow:'.product-card-slider-arrow.product-card-slider-arrow_prev',
        nextArrow:'.product-card-slider-arrow.product-card-slider-arrow_next',
        responsive:
        [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 6
                }
            },
          {
            breakpoint: 480, 
            settings: {
              slidesToShow: 5
            }
          }
        ]
    });
    $('.cat-slider-wrap').slick({
        centerMode: false,
        arrows: true,
        dots: false,
        slidesToShow: 8,
        slidesToScroll: 1,
        appendArrows:'.cat-slider-arrows',
        prevArrow:'.cat-slider-arrow.cat-slider-arrow_prev',
        nextArrow:'.cat-slider-arrow.cat-slider-arrow_next',
        responsive:
            [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 6
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 5
                    }
                }
            ]
    });
    $(".slider-main-wrap").on('afterChange', function(event, slick, currentSlide){
        $(".s-num-counter").text(currentSlide + 1);
    });
//});

//CART SCROLL
$(".cart-m-popup-inner").niceScroll({
    cursorcolor:"#757575",
    cursorwidth:"6px",
    background:"rgba(20,20,20,0)",
    cursorborder:"1px solid #757575",
    cursorborderradius:0,
    autohidemode: false
});
$(".header-burger-content-inner").niceScroll({
    cursorcolor:"#757575",
    cursorwidth:"6px",
    background:"rgba(20,20,20,0)",
    cursorborder:"1px solid #757575",
    cursorborderradius:0,
    autohidemode: false
});
// $('.header-cat__show').click(function () {
//     $(".header-cat-menu_main").niceScroll({
//         cursorcolor:"#757575",
//         cursorwidth:"6px",
//         background:"rgba(20,20,20,0)",
//         cursorborder:"1px solid #757575",
//         cursorborderradius:0,
//         autohidemode: false,
//         //railalign: right
//     });
// });
// $('.header-cat__show._hidden').click(function () {
//     $(".header-cat-menu_main").niceScroll().remove();
//     $('.header-cat-menu_main').css('overflow','hidden');
// });

//custom youtube player
// $('.js-videoPoster').click(function (e) {
//     e.preventDefault();
//     var poster = $(this);
//     // ищем родителя ближайшего по классу
//     var wrapper = poster.closest('.js-videoWrapper');
//     videoPlay(wrapper);
// });
