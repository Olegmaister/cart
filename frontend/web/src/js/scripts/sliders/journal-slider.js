var $heroSliderJournal = $('.js-slider-journal');
var $heroSliderJournalThumbs = $('.js-slider-journal-thumbs');
$heroSliderJournal.slick({
    asNavFor: '.js-slider-journal-thumbs',
    arrows: true,
    dots: false,
    fade: true,
    autoplay: true,
    autoplaySpeed: 5000,
    pauseOnFocus: false,
    pauseOnHover: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    appendArrows:'.slider-arrows',
    prevArrow:'.slider-arrow.slider-arrow__prev',
    nextArrow:'.slider-arrow.slider-arrow__next'
});
$heroSliderJournalThumbs.slick({
    asNavFor: '.js-slider-journal',
    arrows: false,
    dots: false,
    centerMode: false,
    focusOnSelect: true,
    infinite: true,
    vertical: true,
    slidesToShow: 3,
    slidesToScroll: 1
});