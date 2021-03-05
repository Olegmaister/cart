var $heroSlider = $('.slider-main-wrap');
var $heroSliderCurrent = $('.js-hero-slider-current');
var $heroSliderTotal = $('.js-hero-slider-total');

$heroSlider.on('init', function(event, slick) {
    $heroSliderTotal.text('0' + slick.slideCount);
});

$heroSlider.slick({
    arrows: true,
    dots: false,
    fade: true,
    autoplay: true,
    autoplaySpeed: 10000,
    pauseOnFocus: false,
    pauseOnHover: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    appendArrows:'.slider-arrows',
    prevArrow:'.slider-arrow.slider-arrow__prev',
    nextArrow:'.slider-arrow.slider-arrow__next'
});

$heroSlider.on('afterChange', function(event, slick, currentSlide){
    $heroSliderCurrent.text(currentSlide + 1);
});