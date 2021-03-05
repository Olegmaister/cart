$('.cat-slider-wrap').not('.slick-initialized').slick({
    centerMode: false,
    arrows: true,
    dots: false,
    slidesToShow: 8,
    autoplay: false,
    autoplaySpeed: 5000,
    slidesToScroll: 1,
    appendArrows:'.cat-slider-arrows',
    prevArrow:'<div class="cat-slider-arrow cat-slider-arrow_prev" tabindex="0"></div>',
    nextArrow:'<div class="cat-slider-arrow cat-slider-arrow_next" tabindex="0"></div>',
    responsive:
        [
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 6
                }
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 376,
                settings: {
                    slidesToShow: 2
                }
            }
        ]
});