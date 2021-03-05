$('.brands-slider-wrap').slick({
    centerMode: false,
    arrows: true,
    dots: false,
    slidesToShow: 9,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 5000,
    appendArrows:'.brands-arrows',
    prevArrow:'.brands-arrows__arrow.brands-arrows__arrow_prev',
    nextArrow:'.brands-arrows__arrow.brands-arrows__arrow_next',
    responsive:
        [
            {
                breakpoint: 1367,
                settings: {
                    slidesToShow: 7
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