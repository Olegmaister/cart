var openModalQuikBuy = $('.js-open-modal-quik-buy');
var closeModalQuikBuy = $('.modal__close--quik-buy, #overlay');
var modalQuikBuy = $('.modal--quik-buy');

openModalQuikBuy.click(function (event) {
  event.preventDefault();
  const $button = $(this);
  const is_compare = $button.closest('.p-compare-buttons').length;
  let productColor;
  let productName;
  let productSize;


  if (!isGiftSelected()) {
    return false;
  }

  var div = $(this).attr('href');
  overlay.fadeIn(400,
    function () {
      $(modalQuikBuy)
        .css('display', 'flex')
        .animate({opacity: 1}, 200);
      if (is_compare) {
        const $parent = $button.parents('.p-compare-slider-col-inner');
        productName = $parent.find('a.product-card__name-link').text();
        productColor = $parent.find('.product-colors__item._active img').attr('alt');
        productSize = $parent.find('.sizes-switch__item--active').text();
      } else {
        productColor = $('.product-colors__item._active img').attr('alt');
        productName = $('h1.product__name.mob-hide-x1279').text();
        productSize = $('.sizes-switch__item--active').text().slice(0, -1);
      }
      modalQuikBuy.find('h2').find('span').remove();
      modalQuikBuy.find('h2').append('<span class="text-danger">' + productName + ', ' + productColor + ', ' + productSize + '</span>');
      $fastformCitySelect = $('#fastform-city');
      if ($fastformCitySelect.val() !== 'promt') {
        $('#fastform-city').trigger('change');
      }
    });
  scrollLock()
});
closeModalQuikBuy.click(function () {
  modalQuikBuy
    .animate({opacity: 0}, 200,
      function () {
        $(this).css('display', 'none');
        overlay.fadeOut(400);
      }
    );
  scrollUnlock()
});