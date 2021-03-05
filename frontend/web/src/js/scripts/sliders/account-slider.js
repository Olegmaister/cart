var $heroSliderAccountThumbs = $('.js-slider-account-thumbs');
$heroSliderAccountThumbs.slick({
    arrows: true,
    dots: false,
    centerMode: false,
    focusOnSelect: true,
    infinite: false,
    slidesToShow: 8,
    slidesToScroll: 1,
    prevArrow:'.account-tabs-nav-but--prev',
    nextArrow:'.account-tabs-nav-but--next',
    responsive:
        [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 5
                }
            },
            {
                breakpoint: 599,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 400,
                settings: {
                    slidesToShow: 2
                }
            }
        ]
});

$('.js-slider-account-thumbs').on('afterChange', function (event, slick, currentSlide) {

    if(currentSlide === 0) {
        $('.account-tabs-nav-but--prev').removeClass('show');
        $('.account-tabs-nav-list').removeClass('_show');
    }
    else {
        $('.account-tabs-nav-but--prev').addClass('show');
        $('.account-tabs-nav-list').addClass('_show');
    }

});

$('.account-tabs-nav-but--prev,.account-tabs-nav-but--next').click(function () {
    $(this).closest('.account-tabs-nav').find('.slick-slide').removeClass('active');
});

$('.slick-current').addClass('active');