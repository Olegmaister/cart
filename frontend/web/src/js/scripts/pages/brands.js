$(document).ready(function () {

  //Высота содержимого в описании на стр Брендов
  const $text = $('.js-height-brands-desc');

  //Высота описания на стр Брендов
  if ($text.length) {
    const heightBlock = $text.outerHeight();

    if (heightBlock < 140) {
      $('.js-brands-view-desc').hide();
    } else {
      $('.js-brands-view-desc').show();
    }
  }

});

//view sizes table
$(document).on('click', '.js-brands-view-desc', function () {

  $(this).prev().toggleClass('brand-head__desc--show');

});
