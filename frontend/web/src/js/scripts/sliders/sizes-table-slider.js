var $heroSliderTableSize = $('.js-slider-table-size');
$heroSliderTableSize.slick({
    arrows: true,
    dots: false,
    centerMode: false,
    focusOnSelect: true,
    infinite: false,
    slidesToShow: 6,
    slidesToScroll: 1,
    prevArrow:'.account-table-size-slider-but--prev',
    nextArrow:'.account-table-size-slider-but--next',
    responsive:
        [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 4
                }
            }
        ]
});