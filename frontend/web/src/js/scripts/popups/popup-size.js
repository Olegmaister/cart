// var openModalSize = $('.js-open-modal-size');
// var closeModalSize = $('.modal__close--size');
var modalSize = $('.modal--size');

$(document).on('click', '.js-open-modal-size', function (event) {
  event.preventDefault();
  const sizesImage = $(this).data('table_size');
  const $sizesSwitch = modalSize.find('.sizes-switch');
  const $button = modalSize.find('.js-popup-table-sizes-open');

  overlay.fadeIn(400,
    function () {
      $(modalSize).find('.js-popup-table-sizes').hide();
      $(modalSize).find('.modal-content--size').show();
      if (sizesImage) {
        $(modalSize).find('.modal-size-table__img').attr('src', sizesImage);
        $button.show();
      } else {
        $button.hide();
      }
      $(modalSize)
        .css('display', 'flex')
        .animate({opacity: 1}, 200);
    });
  $sizesSwitch.each(initSizeSwitch);
  scrollLock();
});

$(document).on('click', '.modal__close--size', function () {
  modalSize
    .animate({opacity: 0}, 200,
      function () {
        $(this).css('display', 'none');
        overlay.fadeOut(400);
      }
    );

  // $('.js-popup-table-sizes-open').closest('.modal-content--size').next().slideUp( "fast", function() {});
  scrollUnlock()
});

//view sizes table
$(document).on('click', '.js-popup-table-sizes-open', function () {

  // if($('.js-popup-table-sizes').css('display') == 'none') {
  //     $(this).closest('.modal-content--size').next().slideDown( "fast", function() {});
  // } else {
  //     $(this).closest('.modal-content--size').next().slideUp( "fast", function() {});
  // }
  const $arrowBack = $('<button class="close-size-table">Вернуться к размерам</button>');
  const $sizes = $(this).closest('.modal-content--size');
  $sizes.hide();
  $sizes.next().show();
  if (!$('.close-size-table').length) {
    $sizes.next().prepend($arrowBack);
  }

});

$(document).on('click', '.close-size-table', function () {
  const $table = $(this).closest('.modal-size-table');
  $table.hide();
  $table.prev().show();
});