var openModalShop = $('.js-open-modal-shop');
var closeModalShop = $('.modal__close--shop, #overlay');
var modalModalShop = $('.modal--shop');

openModalShop.click(function (event) {
  event.preventDefault();

  // удаляем сообщение об успешном резервировании
  $('.reserve-success-text').remove();
  $('.popup-shop').show();

  // gift validation
  if (!isGiftSelected()) {
    return false;
  }

  // auth validation
  if (!IS_LOGGED) {
    openModal('.modal--login');
    return;
  }


  var div = $(this).attr('href');
  overlay.fadeIn(400,
    function () {
      $(modalModalShop)
        .css('display', 'flex')
        .animate({opacity: 1}, 200);
    });
  scrollLock();
});
closeModalShop.click(function () {
  modalModalShop
    .animate({opacity: 0}, 200,
      function () {
        $(this).css('display', 'none');
        overlay.fadeOut(400);
      }
    );
  scrollUnlock();
});

// $('.popup-shop-table').scroll(function(){
//     var the_top = $('.popup-shop-table').scrollTop();
//     if (the_top > 1) {
//         $('.popup-shop-table').addClass('fixed');
//     }
//     else {
//         $('.popup-shop-table').removeClass('fixed');
//     }
// });


$('.modal__close--watch, #overlay').click(function () {
  $('.modal.modal--watch')
    .animate({opacity: 0}, 200,
      function () {
        $(this).css('display', 'none');
        overlay.fadeOut(400);
        $('.modal--watch').find('.text-success').remove();
      }
    );
  scrollUnlock();
});

// открыть модальное окно "следить за ценой и скидками"
$('.js-modal-watch').on('click', function () {
  const productId = $('.page--product').data('product_id');
  const data = {product: productId};

  if ($(this).hasClass('watch-active')) {
    unfollowPriceRequest(data);
    return;
  }
  openModal('.modal--watch');

  if (!IS_LOGGED) {
    $('#follow-price').show();
  } else {
    followPriceRequest(data);
  }
});

$('#follow-price').on('submit', function (e) {
  e.preventDefault();
  const email = $(this).find('.input-1').val();
  const productId = $('.page--product').data('product_id');
  const data = {product: productId};

  if (!IS_LOGGED) {
    data.email = email;
  }
  followPriceRequest(data);
});

function followPriceRequest(data) {
  $.post('/' + currentLang() + '/price-watch/add', data, function (res) {
    $('.js-modal-watch').addClass('watch-active');
    $('.product-watches__txt').text(function () {
      $(this).text($(this).data('unset-text'));
    });
    if (!$('.follow-price-success').length) {
      $('#follow-price').after('<div class="follow-price-success">' + res.msg + '</div>');
    }
    if (!IS_LOGGED) {
      $('#follow-price').hide();
    }
  }).fail(function (err) {
    console.log(err);
    closeModal('.modal--watch');
  });
}

function unfollowPriceRequest(data) {
  $.post('/' + currentLang() + '/price-watch/delete', data, function (res) {
    $('.js-modal-watch').removeClass('watch-active');
    $('.product-watches__txt').text(function () {
      $(this).text($(this).data('set-text'));
    });
    notify(res.msg);
  }).fail(function (err) {
    console.log(err);
  });
}