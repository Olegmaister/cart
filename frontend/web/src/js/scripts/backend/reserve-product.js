$('.js-warning-login').on('click', function () {
  $('.modal--shop').animate({opacity: 0}, 200,
    function () {
      $(this).css('display', 'none');
      $('.js-open-modal-login').trigger('click');
      $('.js-register-height-login').trigger('click');
    }
  );
});

$('.js-warning-register').on('click', function () {
  $('.modal--shop').animate({opacity: 0}, 200,
    function () {
      $(this).css('display', 'none');
      $('.js-open-modal-login').trigger('click');
      $('.js-register-height-reg').trigger('click');
    }
  );
});

// Броинрование товара в магазине
$('.js-reserve-product-btn').on('click', function () {
  // ловим или залогинен юзер
  let logined = $('[data-login]').attr('data-login');

  // юзер не залогинен
  if (!+logined) {
    // $('.popup-shop-bot').addClass('is-show');
    $('.auth-warning').show();
    return false;
  }

  // удаляем сообщение об ошибке
  $('.js-reserve-product-no-size').remove();

  // Проверяем или выбрали размер
  let sizeBtn = $('.js-popup-shop-size-height').find('.sizes-switch__item--active');
  if (!sizeBtn.length) {
    $(this).closest('tr').find('.popup-shop-table-size').after('<div class="js-reserve-product-no-size text-danger mt-1 w-100">' + _tr('choose-size') + '</div>');
    return false;
  }

  const $cartButton = $('.js-product-add-cart');
  let product = $(this).attr('data-product-id');
  let option = sizeBtn.attr('data-option-id');
  let store = $(this).attr('data-store-id');
  const presentOptionId = $cartButton.attr('data-gift-id');
  const presentOptionName = $cartButton.attr('data-gift-option-name');
  const presentProductId = $cartButton.attr('data-gift-option-id');


  $.ajax({
    url: '/create-product-reserve',
    type: 'POST',
    data: {
      product: product,
      option: option,
      store: store,
      presentProductId: presentProductId,
      presentOptionId: presentOptionId,
      presentOptionName: presentOptionName
    },
    beforeSend: function () {
      showSpinnerOverlay('.modal--shop');
    },
    success: function (data) {
      hideSpinnerOverlay('.modal--shop');
      const orderId = data['order_id'];
      const shopId = data['shop_id'];
      const address = data['shop_address'];
      const schedule = data['shop_schedule'];
      const name = data['shop_name'];
      $('.popup-shop')
        .hide()
        .after('<h2 class="reserve-success-text">' + _tr('reserve-thanks') + '!' +
          ' ' + _tr('your-order') + ' <span class="text-danger">#' + orderId + '</span> ' + _tr('awaits-you') + ' (' + name + ') <a href="/our-stores#' + shopId + '" target="_blank" class="link-line-dotted--red">' + address + '</a><br/>' + _tr('schedule') + ': ' + schedule + '</h2>');
    }
  });
});
