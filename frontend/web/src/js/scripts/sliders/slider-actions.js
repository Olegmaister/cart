var $heroSliderActions = $('.js-slider-action');
var $heroSliderActionslThumbs = $('.js-slider-actions-thumbs');

$heroSliderActions.slick({
    asNavFor: $heroSliderActionslThumbs,
    arrows: true,
    dots: false,
    fade: true,
    autoplay: 5000,
    autoplaySpeed: 10000,
    pauseOnFocus: false,
    pauseOnHover: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    appendArrows:'.slider-arrows',
    prevArrow:'.slider-arrow.slider-arrow__prev',
    nextArrow:'.slider-arrow.slider-arrow__next'
});

$heroSliderActionslThumbs.slick({
    asNavFor: $heroSliderActions,
    arrows: false,
    dots: false,
    fade: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    touchMove: false,
    swipe: false,
    draggable: false
});