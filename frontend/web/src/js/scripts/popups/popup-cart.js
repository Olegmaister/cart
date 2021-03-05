
var openModalCart = $('.js-open-modal-cart');
var modalCart = $('.modal--cart');
var modalSize = $('.modal--size');
const $body = $('body');

openModalCart.click(function (event) {
  event.preventDefault();

  modalSize.css('display', 'none');

  overlay.fadeIn(400,
    function () {
      $(modalCart)
        .css('display', 'flex')
        .animate({opacity: 1}, 200);
    });

  scrollLock();
});


$(document).on('click', '.js-modal-close-cart, #overlay', function () {
  // добавить стобытия для закрытия модальной корзины
  if ($body.hasClass('active-edit-cart')) {
    const deliveryMethod = $('.js-delivery-method:checked').data('id');
    const $addressSelect = $('#couriernpform-city');
    const $officeSelect = $('#officenpform-city');
    const country = $('#deliveryform-country').val();
    const promoCode = $('.js-promo-data-input').val();
    const params = {
      country: country,
      token: promoCode
    };

    if (country !== 'УКРАИНА') {
      $(document).trigger('modal-cart-close', params);
    }

    // проверяем выбрана ли доставка по адресу
    if (deliveryMethod === 1) {
      if ($addressSelect.val() !== 'promt') {
        params.deliveryMethod = deliveryMethod;
        params.city = $addressSelect.val();
        $(document).trigger('modal-cart-close', params);
      }
    }

    // проверяем выбрана ли доставка в отделение
    if (deliveryMethod === 2) {
      if ($officeSelect.val() !== 'promt') {
        params.deliveryMethod = deliveryMethod;
        params.city = $officeSelect.val();
        $(document).trigger('modal-cart-close', params);
      }
    }


    //получение url взависимости от страны
    let url = getUrl(params['country']);

    //пересчет доставки
    recalculationCostDelivery(url, params);


    $body.removeClass('active-edit-cart');

  }

  modalCart
    .animate({opacity: 0}, 200,
      function () {
        $(this).css('display', 'none');
        overlay.fadeOut(400);
      }
    );
  modalSize
    .animate({opacity: 0}, 200,
      function () {
        $(this).css('display', 'none');
        overlay.fadeOut(400);
      }
    );
  scrollUnlock();
});

//пересчет доставки для украины
/**
 * string url
 * object params{country deliveryId cityId}
 * */
function recalculationCostDelivery(url, params)
{
    //ajax
    $.ajax({
      method: "post",
      data: {
        params: params
      },
      url: url,
      dataType: 'json',
      'success': function (data) {
          let wrapperElement = $('.js-wrapper-order-cart');
          wrapperElement.empty();
          wrapperElement.append(data['view']);
        if (data.deliveryCost && data.deliveryCost !== 0) {
          $('.js-order-cost-office-np').text(data.deliveryCost);
          $('.js-order-cost-address').text(data.deliveryCost);
          $('#orderform-cost').val(data.deliveryCost);
        } else {
          $('#orderform-cost').val(data.hryvnia);
        }


          let euroNum = data['euroNum'];

        // TODO - ОЛЕГ: надо подставить еще конвертированную стоимость в евро
          // верстка уже готова, просто подставить данные в переменной euroNum с бека
          var euro = document.querySelector('.js-abroad-euro');
          var usd = document.querySelector('.js-abroad-usd');
          euro.textContent = "(" + euroNum + ")";
          usd.textContent = "(" + data['dollarNum'] + ")";


      },
      'error': function (response) {
      }
    });
}

function getUrl(country) {
  if (country === '804') {
    return '/' + currentLang() + '/nova-poshta/recalculation-cost';
  }

  return '/ukr-pochta/recalculation-price-int';
}
