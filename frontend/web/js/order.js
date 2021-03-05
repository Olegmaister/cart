$(document).ready(function () {

  // //временный код
  // $('.product-card__color-img').on('click',function()
  // {
  //     let productId = $(this).data('product-id');
  //
  //     let price = 100;
  //     let oldPrice = 200;
  //
  //
  //   $.ajax({
  //     url: '/products/price',
  //     method: 'post',
  //     data: {
  //       productId : productId
  //     },
  //     success: function (data) {
  //
  //     }
  //   });
  //
  //
  // })
  // //временный код


  /*работа с подарком*/

  // Добавление товара в корзину со страницы товара
  $('.js-product-add-cart2').on('click', function (e) {

    const $gifts = $('.product-gifts');

    if ($gifts.length) {
      if ($('.product-gifts__item.active').length === 0) {
        const $title = $gifts.find('.product-sizes__title');
        $('.gift-error').remove();
        $title.after('<div class="gift-error">' + $title.data('error') + '</div>');
        $('html, body').animate({scrollTop: $gifts.offset().top}, 300);
        return false;
      }
    }

    // Удаляем класс для пустой корзины
    $('.modal--cart').removeClass('cart-is-empty');

    e.preventDefault();
    //get collection sizes
    let sizeElements = $('.js-product-size');
    let colorElements = $('.product-colors__item');
    let optionId;
    let optionName;
    let productId;
    let productColorImage;
    let quantity = 1;


    //present
    let presentProductId = $(this).data('gift-id');
    let presentOptionId = $(this).data('gift-option-id');
    let presentOptionName = '';
    let sizeElementsPresent = $('.js-sizes-switch-present .sizes-switch__item');


    $(".product-gifts__item ").each(function (row, element) {
      let currentElement = $(element);
      if (currentElement.hasClass('active')) {
        presentProductId = currentElement.data('id');
      }
    });


    sizeElements.each(function (index, value) {
      let currentElement = $(value);
      if (currentElement.hasClass('sizes-switch__item--active')) {
        optionId = currentElement.data('option_id');
        productId = currentElement.data('product_id');
        optionName = currentElement.text();
      }
    });

    sizeElementsPresent.each(function (index, value) {
      let currentElement = $(value);
      if (currentElement.hasClass('sizes-switch__item--active')) {
        presentOptionName = currentElement.text();
      }
    });

    colorElements.each(function (index, value) {
      let currentElement = $(value);
      if (currentElement.hasClass('_active')) {
        let currentImgActive = currentElement.find('img');
        productColorImage = currentImgActive.attr('src');
      }
    });


    $.ajax({
      url: '/' + currentLang() + '/cart/add',
      method: 'post',
      data: {
        'productId': productId,
        'quantity': quantity,
        'option': optionId,
        'optionName': optionName,
        'productColorImage': productColorImage,
        'presentOptionId': presentOptionId,
        'presentOptionName': presentOptionName,
        'presentProductId': presentProductId,
        'languageId': currentLang()
      },
      success: function (data) {
        if (data['success'] === true) {
          updateCart(data);
        }

        scrollLock();
      }
    });
  });


  /*
  * удаление
  *
  * **/

  $(document).on('click', '.js-header-remove-product-present-cart', function () {
    let productId = $(this).data('product-id');
    let optionId = $(this).data('option');


    $.ajax({
      url: '/present/remove',
      method: 'post',
      data: {
        'productId': productId,
        'optionId': optionId,
      },
      success: function (data) {
        if (data['success'] === true) {
          updateCart(data);
        }

        scrollLock();
      }
    });
  });


  /*
*   Файлы с бекенда
* */
  /* НАЧАЛО
  **==================== Добавление товара в корзину ====================*/

  // ответ сервера обновляем корзину
  function updateCart(data) {
    let wrapperElement = $('.wrapper-popup-cart');
    wrapperElement.empty();
    wrapperElement.append(data['view']);

    // Удаляем старую корзину и вставляем новую
    $('.js-wrapper-header-cart').remove();
    $('.header-cart').append(data['viewHeader']);


    $('#overlay').fadeIn(400,
      function () {
        $('.modal--cart')
          .outerHeight(window.innerHeight)
          .css('display', 'flex')
          .animate({opacity: 1}, 200);
      }
    );

    initProductCounter();
  }


  let deliveryCostAddress = 0;
  let deliveryCostOffice = 0;

  function addToTotalPrice(servicePrice) {
    const priceElement = document.querySelector('.js-cart-popup-cost-total');
    const initialPrice = priceElement.getAttribute('data-cost');
    priceElement.textContent = parseInt(initialPrice) + servicePrice;
  }

  function updateDeliveryCost(cost) {
    const $deliveryCost = $('.js-order-cart-delivery-cost');
    if (cost) {
      $('.js-currency').text(currencySign());
      $deliveryCost.text(cost);
    } else {
      $('.js-currency').text('');
      $deliveryCost.text('');
    }
  }

  // при выборе магазина отобразить ссылку на него на карте
  $('#storereservationform-store').on('change', function () {
    const $link = $('.checkout-delivery__address');
    $link.find('a').attr('href', '/our-stores#' + $(this).val());
  });

  /*===удалить===*/
  $('.js-show-discount').on('click', function (e) {
    e.preventDefault();
    $('.wrapper-discount').css({'display': 'block'});
  })

  $('.wrapper-discount-close').on('click', function (e) {
    e.preventDefault();
    $('.wrapper-discount').css({'display': 'none'});
  })

  // Без этого не работает липкая корзина
  if (document.querySelector('.sticky-cart')) {
    document.querySelector('.main-wrapper').style.overflow = 'initial';
  }

  //если пользователь хочет пройти регистраицю
  //показываем данные для регистрации
  $('.js-show-registration-data').on('change', function () {
    let element = $('.js-wrapper-registration-data');

    if ($(element).is(":hidden")) {
      element.css({'display': 'block'});
      $('[for="orderform-registration"]').addClass('is-checked');
    } else {
      element.css({'display': 'none'});
      $('[for="orderform-registration"]').removeClass('is-checked');
    }
    $('#checkout-no-email, #checkout-email-required').toggle();

  });


  $('#storereservationform-city').on('change', function () {
    let city = $(this).val();

    $.ajax({
      method: "post",
      data: {
        city: city
      },
      url: '/' + currentLang() + "/checkout/stores",
      dataType: 'json',
      'success': function (data) {
        if (data['stores']) {
          let $deliverOffice = $('#storereservationform-store');
          $deliverOffice.empty();
          $deliverOffice.niceSelect('destroy');
          $.each(data['stores'], function (index, value) {
            $deliverOffice.append('<option value="' + index + '">' + value + '</option>');
          });
          $deliverOffice.change(); // тригерим чтобы можно было подхватить изменения
          $deliverOffice.niceSelect();
        }
      },
      'error': function (response) {
      }
    });
  });


  // Выбор способа оплаты - в зависимости от выбора доставки
  $('.js-delivery-method').click(function () {

    let deliveryId = $(this).data('id');
    let language = currentLang();
    let token = getPromo();


    $.ajax({
      method: "post",
      data: {
        deliveryId: deliveryId,
        language: language,
        token: token
      },
      url: "/checkout/payment",
      dataType: 'json',
      'success': function (data) {

        /*====работа с корзиной====*/
        updateDelivery(data['totalCost']);
        /*====работа с корзиной====*/


        var $parent = $('.checkout-payment__choices');
        var $typePayment = $('.field-paymentform-typepayment');
        $parent.append($typePayment);

        var $el = $("#paymentform-paymentmethod2");
        $el.empty(); // remove old options

        var $elOption = $("#paymentform-typepayment");
        $elOption.empty(); // remove old options

        $.each(data['payment'], function (key, value) {
          // Ветвление сделано для добавленяи изображений где оно есть по дизайну
          // Если поменяют значение value['name'] в базе, то скрипт ляжет
          if (value['name'] === 'Оплата банковской картой') {
            $el.append(
              $("<div class='checkout-payment__item js-payment-item'>" +
                "<label class='checkout-payment__label js-payment-choices'>" +
                "<input type='radio' class='checkout-payment__input js-fuck-payment js-payment-input'" +
                "name='PaymentForm[paymentMethod2]' value='" + value['id'] + "'/>" +
                "<span class='checkout-payment__input-fake'></span>" +
                "<span class='checkout-payment__label-text'>" + value['name'] + "</span>" +
                "<img src='/images/checkout/visa-bank.svg' class='checkout-payment__logo' alt=''>" +
                "</label>" +
                "<p class='checkout-payment__description text text--gray4'>" + value['description'] + "</p>" +
                "</div>")
            );
          } else if (value['name'] === 'Оплата частями') {
            $el.append(
              $("<div class='checkout-payment__item js-payment-item'>" +
                "<label class='checkout-payment__label js-payment-choices'>" +
                "<input type='radio' class='checkout-payment__input js-fuck-payment js-payment-input'" +
                "name='PaymentForm[paymentMethod2]' value='" + value['id'] + "'/>" +
                "<span class='checkout-payment__input-fake'></span>" +
                "<span class='checkout-payment__label-text'>" + value['name'] + "</span>" +
                "<img src='/images/checkout/pay-part.svg' class='checkout-payment__logo' alt=''>" +
                "</label>" +
                "<p class='checkout-payment__description text text--gray4'>" + value['description'] + "</p>" +
                "</div>")
            );
          } else {
            $el.append(
              $("<div class='checkout-payment__item js-payment-item'>" +
                "<label class='checkout-payment__label js-payment-choices'>" +
                "<input type='radio' class='checkout-payment__input js-fuck-payment js-payment-input'" +
                "name='PaymentForm[paymentMethod2]' value='" + value['id'] + "'/>" +
                "<span class='checkout-payment__input-fake'></span>" +
                "<span class='checkout-payment__label-text'>" + value['name'] + "</span>" +
                "</label>" +
                "<p class='checkout-payment__description text text--gray4'>" + value['description'] + "</p>" +
                "</div>")
            );
          }
        });
      },
      'error': function (response) {
      }
    });
  });

  // дополнительная инфа способа оплаты - в зависимости от выбора способа оплаты
  $(document).on('click', '.js-payment-input', function () {


    //alert('payment');


    let paymentId = $(this).val();

    $('#js-slider-parts-privat').addClass('hidden');

    $.ajax({
      method: "post",
      data: {
        paymentId: paymentId
      },
      url: "/checkout/payment-additional",
      dataType: 'json',
      'success': function (data) {
        var $el = $("#paymentform-typepayment");
        $el.empty();

        if (data['privatPP']) {
          $('#js-slider-parts-privat').removeClass('hidden');
        }

        $.each(data['payment'], function (key, value) {
          // Вычисляем выбор "Оплата частями", что бы отрисовать рендж для выбора
          // Слетит скрипт, если поменяется key
          if (key === "4") {
            $el.append(
              $("<div class='checkout-payment__pay-part js-payment-form'>" +
                "<p class='checkout-payment__pay-part-description'>" +
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit." +
                "Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo." +
                "</p>" +
                "<div class='checkout-payment__pay-part-range js-pay-part-range'" +
                "data-value='1' data-min='1'" +
                "data-step='1' data-max='5'" +
                "data-max-text='"+_tr('up-to-5')+"'>" +
                "</div>" +
                "</div>"
              )
            );

            initPayPartRange();
          } else if (key === "1") {
            $el.append(
              $("<label class='checkout-payment__label'>" +
                "<input type='radio' value='" + key + "'" +
                "class='checkout-payment__input' name='PaymentForm[typePayment]'/>" +
                "<span class='checkout-payment__input-fake'></span>" +
                "<img src='/images/checkout/liqupay.jpg' alt='' class='checkout-payment__logo'>" +
                "</label>")
            );
          } else if (key === "2") {
            $el.append(
              $("<label class='checkout-payment__label'>" +
                "<input type='radio' value='" + key + "'" +
                "class='checkout-payment__input' name='PaymentForm[typePayment]'/>" +
                "<span class='checkout-payment__input-fake'></span>" +
                "<img src='/images/checkout/way-for-pay-bank.png' alt='' class='checkout-payment__logo'>" +
                "</label>")
            );
          } else if (key === "3") {
            $el.append(
              $("<label class='checkout-payment__label'>" +
                "<input type='radio' value='" + key + "'" +
                "class='checkout-payment__input' name='PaymentForm[typePayment]'/>" +
                "<span class='checkout-payment__input-fake'></span>" +
                "<img src='/images/checkout/PayPal.svg' alt='' class='checkout-payment__logo'>" +
                "</label>")
            );
          } else {
            $el.append(
              $("<label class='checkout-payment__label'>" +
                "<input type='radio' value='" + key + "'" +
                "class='checkout-payment__input' name='PaymentForm[typePayment]'/>" +
                "<span class='checkout-payment__input-fake'></span>" +
                value +
                "</label>")
            );
          }


          var paymentInputs = document.querySelectorAll('.js-payment-input');
          var $typePayment = $('.field-paymentform-typepayment');

          for (var i = 0; i < paymentInputs.length; i++) {
            if (paymentInputs[i].checked) {
              var $parent = $(paymentInputs[i]).closest('.js-payment-item');
              $parent.append($typePayment);
            }
          }
        });
      },
      'error': function (response) {
      }
    });
  });


  /*
  * @var int totalCost - сумма заказа без учета доставки
  * */
  function updateDelivery(totalCost) {
    //сбрасывем стоимость доставки
    updateDeliveryCost('');
    //устанавливаем сумму заказа(без скидки)
    $('.js-cart-popup-cost-total').text(totalCost);
    //устанавливаем сумму заказа(без скидки)
    // $('#orderform-cost').val(totalCost);
  }

  //доставка курьером
  $("#couriernpform-city").on('change', function () {

    let dataInfo = $('.js-order-info-data').data();
    let weight = dataInfo['weight'];
    let cost = dataInfo['cost'];
    let cityId = $(this).val();

    $.ajax({
      method: "post",
      data: {
        cityId: cityId,
        weight: weight,
        cost: cost
      },
      url: "/nova-poshta/cost",
      dataType: 'json',
      'success': function (data) {

        //вывод под доставкой , заменить
        $('.js-order-cost-address').text(data['cost']);

        //вывод правый блок доставка :
        updateDeliveryCost(data['cost']);


        $('.js-delivery-currency').fadeIn(0);

        //сумма общей доставки
        deliveryCostAddress = data['cost'];
        addToTotalPrice(deliveryCostAddress);
        $('#orderform-cost').val(data['cost']);

      },
      'error': function (response) {
      }
    });
  });

  //доставка в отделение
  $("#officenpform-city").on('change', function () {
    let dataInfo = $('.js-order-info-data').data();
    let weight = dataInfo['weight'];
    let cost = dataInfo['cost'];
    let cityId = $(this).val();

    $.ajax({
      method: "post",
      data: {
        cityId: cityId,
        weight: weight,
        cost: cost
      },
      url: "/nova-poshta/cost",
      dataType: 'json',
      'success': function (data) {
        $('.js-order-cost-office-np').text(data['cost']);

        updateDeliveryCost(data['cost']);

        $('#officenpform-cost').val(data['cost']);

        deliveryCostOffice = data['cost'];
        addToTotalPrice(deliveryCostOffice);
        $('#orderform-cost').val(data['cost']);

      },
      'error': function (response) {
      }
    });
    //}
  });

  //Если отправка зарубеж
  $('#deliveryform-country').on('change', function () {
    let currentCountry = $(this).val();
    const countryName = $(this).find('option:selected').text();
    const $commentField = $('.field-orderform-comment');


    //получение токена
    let token = getPromo();

    if (currentCountry !== '804') { // если это не Украина
      $.ajax({
        method: "post",
        data: {
          currentCountry: currentCountry,
          token: token
        },
        url: "/ukr-pochta/delivery-price-int",
        dataType: 'json',
        'success': function (data) {


          let deliveryInCurrency;
          // подставляем стоимость в форму
          $('#foreignersupform-cost').val(data['deliveryCost']);
          $('#orderform-cost').val(data['deliveryCost']);

          let wrapperElement = $('.js-wrapper-order-cart');
          wrapperElement.empty();
          wrapperElement.append(data['view']);

          if (currencySign() === '€') {
            deliveryInCurrency = data.euroNum;
          } else if (currencySign() === '$') {
            deliveryInCurrency = data.dollarNum;
          } else {
            deliveryInCurrency = data.hryvnia;
          }
          $('.js-order-cart-delivery-cost').text(deliveryInCurrency);
          $('.js-currency').text(currencySign());

          // подставляем страну в форму
          var countryText = document.querySelector('.js-abroad-country');
          countryText.innerHTML = '<span class="text-red"> ₴' + data.hryvnia + '</span> (' + countryName + ')';

          let euroNum = data['euroNum'];
          //$('#orderform-cost').val(data.hryvnia);

          // TODO - ОЛЕГ: надо подставить еще конвертированную стоимость в евро
          // верстка уже готова, просто подставить данные в переменной euroNum с бека
          var euro = document.querySelector('.js-abroad-euro');
          var usd = document.querySelector('.js-abroad-usd');
          euro.textContent = "(" + euroNum + ")";
          usd.textContent = "(" + data['dollarNum'] + ")";

          // перенести форму комментария
          $('.abroad-form__about-payment').after($commentField);
        },
        'error': function (response) {
        }
      });
    } else {

      $.ajax({
        method: "post",
        data: {
          currentCountry: currentCountry,
          token: token
        },
        url: '/' + currentLang() + "/nova-poshta/default-cost",
        dataType: 'json',
        'success': function (data) {

          let wrapperElement = $('.js-wrapper-order-cart');
          wrapperElement.empty();
          wrapperElement.append(data['view']);

          // перенести форму комментария
          $('.field-paymentform-parts').after($commentField);

        },
        'error': function (response) {
        }
      });
    }
  }).trigger('change');


  // 2:
  // 1. Инициализация для выбора отделения либы отрисовки селектов
  // 2. Добавляем по умолчанию выбор
  // 3. Дизейблим
  var $selectBranchDefoult = $('.js-officenpform-branch');
  $selectBranchDefoult.append($("<option>Выберите отделение</option>"));
  if ($selectBranchDefoult.length) {
    $selectBranchDefoult.select2({
      sorter: function (data) {
        /* Сортировка по алфавиту */
        return data.sort(function (a, b) {
          a = a.text.toLowerCase();
          b = b.text.toLowerCase();
          if (a > b) {
            return 1;
          } else if (a < b) {
            return -1;
          }
          return 0;
        });
      }
    });
  }
  var officeNPForm = document.querySelector('.field-officenpform-branch')
  if (officeNPForm) {
    officeNPForm.classList.add('disable-input');
  }

  function getPromo() {
    return document.querySelector('.js-promo-data-input').value;
  }

  // 2:
  // 1. Убираем дизейбл у выбора отделения
  // 2. Делаем запрос после выбора города
  // 3. Обновляем выбор отделения с новыми данными
  $("#officenpform-city").on('change', function () {

    let cityId = $(this).val();
    var $el = $("#officenpform-branch");
    $el.removeClass('disable-input');

    $.ajax({
      method: "post",
      data: {
        cityId: cityId
      },
      url: '/' + currentLang() + "/nova-poshta/branches",
      dataType: 'json',
      'success': function (data) {
        $el.empty(); // remove old options

        $.each(data['items'], function (key, value) {
          $el.append($("<option></option>")
            .attr("value", key).text(value));
        });


        $el.select2({
          sorter: function (data) {
            /* Сортировка по алфавиту */
            return data.sort(function (a, b) {
              a = a.text.toLowerCase();
              b = b.text.toLowerCase();
              if (a > b) {
                return 1;
              } else if (a < b) {
                return -1;
              }
              return 0;
            });
          }
        });

        officeNPForm.classList.remove('disable-input');
      },
      'error': function (response) {
      }
    });


  });

  let fastTotalPriceValue = 0;
  //открытие модального окна
  $(document).on('click', '.js-btn-fast-modal', function () {
    let present = 0;
    let price = $('.product-prices .js-product-new-price').text() || $(this).parents('.js-parent').find('.product-card__img-link ').data('product-price');
    const productId = $('.page--product').data('product_id') || $(this).parents('.js-parent').find('.product-card__img-link ').data('product-id');
    const presentId = $('#fastform-presentid').val();

    if (presentId)
      present = 1;


    $.ajax({
      type: "POST",
      url: '/' + currentLang() + '/checkout/total',
      data: {price: price, productId: productId, present: present},
      success: function (res) {
        if (res.success) {
          $('#fastform-productprice').val(res.price);
          $('.js-cost-fast').text(res.price);
          if (res.discount) {
            $('.js-discount-fast').show();
            $('.js-fast-discount-value').text(res.discount);
          }

          fastTotalPriceValue = res.price;
        }
      }
    });
  });


  $("#fastform-city").on('change', function () {
    let cityId = $(this).val();
    let branches = $("#fastform-branch");

    $.ajax({
      method: "post",
      data: {
        cityId: cityId
      },
      url: '/' + currentLang() + "/nova-poshta/branches",
      dataType: 'json',
      'success': function (data) {
        clearElement(branches);// clear old options

        $.each(data['items'], function (key, value) {
          branches.append($("<option></option>")
            .attr("value", key).text(value));
        });
        $('#js-checkout-form-fast').find('.select2').next('.text-danger').remove();
        $('#js-checkout-form-fast .select2-selection').removeClass('has-error');
      },
      'error': function (response) {
      }
    });

    let weight = 1;
    const productId = $('.page--product').data('product_id') || $(this).parents('.js-parent').find('.product-card__img-link ').data('product-id');

    $.ajax({
      method: "post",
      data: {
        cityId: cityId,
        weight: weight,
        cost: fastTotalPriceValue,
        product_id: productId
      },
      url: '/' + currentLang() + "/nova-poshta/cost",
      dataType: 'json',
      'success': function (data) {
        const $totalPrice = $('.js-cost-fast');
        let cost = +data['cost'];
        $('#fastform-deliverycost').val(cost);
        $('.js-fast-delivery').text(data['sign'] + cost);
        $totalPrice.text(fastTotalPriceValue + cost);
      },
      'error': function (response) {
      }
    });


  });

  $('.js-fast-order').on('click', function (e) {

    e.preventDefault();

    if ($(this).hasClass('wayforpay')) {
      $('#fastform-paymentid').val(2);
    }

    let sizeElements = $('.js-product-size');

    let colorElements = $('.product-colors__item');
    let optionId;
    let optionName;
    let productId;
    let productColorImage;
    let quantity = 1;
    let city = $("#fastform-city").val();
    let branch = $("#fastform-branch").val();


    sizeElements.each(function (index, value) {
      let currentElement = $(value);
      if (currentElement.hasClass('sizes-switch__item--active')) {
        optionId = currentElement.data('option_id');
        productId = currentElement.data('product_id');
        optionName = currentElement.text();
      }
    });

    colorElements.each(function (index, value) {
      let currentElement = $(value);
      if (currentElement.hasClass('_active')) {
        let currentImgActive = currentElement.find('img');
        productColorImage = currentImgActive.attr('src');
      }
    });


    $('#fastform-productid').val(productId);
    $('#fastform-optionid').val(optionId);
    $('#fastform-optionname').val(optionName);
    $('#fastform-productcolorimage').val(productColorImage);


    const form = $('#js-checkout-form-fast');
    const fields = form.find('input, select');
    const errorMessage = form.find('.modal-content-inner').data('error');
    let valid = true;

    form.find('.text-danger').remove();

    fields.each(function () {
      const $el = $(this);
      const value = $el.val();

      $el.removeClass('has-error');

      if ($el.is('input:not([type="hidden"])')) {
        if (!value) {
          $el
            .addClass('has-error')
            .after('<p class="text-danger">' + errorMessage + '</p>');
          valid = false;
        }
      }

      if ($el.is('select')) {
        if (!value || value === 'promt') {
          $el.next()
            .find('.select2-selection')
            .addClass('has-error');
          $el.next().after('<p class="text-danger">' + errorMessage + '</p>');
          valid = false;
        }
      }

    });

    if (!valid) return false;

    form.submit();

  });


  function clearElement(element) {
    element.empty();
  }

  //записываем способ доставки, для other
  $("#deliveryform-country").change(function () {
    let countryName = $(this).val();
    if (countryName !== '804') {
      $('#deliveryform-method').val(3);
    }
  }).trigger('change');

  //записываем способ доставки, для ua
  $(".js-delivery-method").change(function () {
    let id = $(this).data('id');
    $('#deliveryform-method').val(id);
  });


  $("#orderform-checkboxrecipient").on('change', function () {
    let element = $('.js-order-show-recipient');
    if ($(this).prop('checked')) {
      element.css({'display': 'block'});
    } else {
      element.css({'display': 'none'});
    }
  });

  /***promo file****/
  $(".js-customer-promo-token").change(function () {
    let promoId = $(this).val();

    $.ajax({
      method: "post",
      data: {
        promoId: promoId
      },
      url: '/' + currentLang() + "/checkout/promo",
      dataType: 'json',
      'success': function (data) {
        var $el = $(".js-wrapper-cart-customer");
        $el.empty(); // remove old options
        $el.append(data['view']);
      },
      'error': function (response) {
      }
    });
  });


  $(document).on('change', '.js-fuck-payment', function () {
    $('#paymentform-paymentmethod').val($(this).val());
  });


  /**
   * ===============================================================================
   * Код верстухи братухи
   *===============================================================================*/
  // Прослушиваем изменения в номере телефона, что бы подставить туда код страны
  listenerChangePhone();

  function listenerChangePhone() {
    // Номер телефона в первой форме - данные о покупателе
    var phone = document.querySelector('#orderform-phone');
    var phoneWrapper = document.querySelector('.checkout-payer');

    // Номер телефона получателя
    var phoneRecipient = document.querySelector('#recipientform-phone');
    var phoneRecipientWrapper = document.querySelector('.checkout-recipient');

    // подставляем в номер код страны
    listenerPhoneInput(phone, phoneWrapper);
    listenerPhoneInput(phoneRecipient, phoneRecipientWrapper);

    // функция для подставки номера страны
    function listenerPhoneInput(input, wrapper) {
      if (!input) {
        return false;
      }

      input.addEventListener('focus', function () {
        // Подставляем код страны в инпут телефона
        if (this.value.indexOf(findPhoneCode(wrapper)) === -1) {
          this.value = findPhoneCode(wrapper) + this.value;
        }

        mask_for_ua('#orderform-phone', '.field-orderform-phone');
        mask_for_ua('#recipientform-phone', '.field-recipientform-phone');
      });

    }

    // Вычислаем код телефона страны, он есть в разметке виджета
    function findPhoneCode(wrapper) {
      var selectedCountryLi = wrapper.querySelector('.iti__active[data-dial-code] .iti__dial-code');
      if (selectedCountryLi) {
        var phoneCode = selectedCountryLi.textContent;
        return phoneCode;
      }
    }

    setTimeout(function () {
      mask_for_ua('#orderform-phone', '.field-orderform-phone');
      mask_for_ua('#recipientform-phone', '.field-recipientform-phone');
      mask_for_ua('#customerform-phone', '.field-customerform-phone');
      mask_for_ua('#profileform-phone', '.field-profileform-phone');
    }, 200);

    function mask_for_ua(inputSelector, parent) {
      var flag = document.querySelector(parent + ' [aria-activedescendant="iti-item-ua"]');
      var input = document.querySelector(inputSelector);

      if (flag) {
        $(input).mask("+380 99 999 99 99");
      } else {
        $(input).unmask();
      }
    }
  }

  // Передаем в поле с номером телефона номер из data-phone
  // Проверяем или авторизирован пользователь
  checkAuthorized();

  function checkAuthorized() {
    // див с инфой: авторизирован юзел или нет? какой номер телефона?
    var info = document.querySelector('.js-order-user-auth');
    // выходим если блока нет
    if (!info) {
      return false;
    }

    // передаем в поле с номером телефона номер из data-phone
    if (+info.getAttribute('data-auth') === 1) {
      var phone = info.getAttribute('data-phone');
      var input = document.querySelector('#orderform-phone');
      // без таймаута не меняет значение
      setTimeout(function () {
        input.value = phone;
      }, 200);
    }
  }


  /**
   *   Показыавем блок с данными получателя
   *-----------------------------------------------------*/
  showRecipientData();

  function showRecipientData() {
    var btnToggle = document.querySelector('.js-show-recipient-data');
    var btnClose = document.querySelector('.js-hide-recipient');
    var recipientData = document.querySelector('.js-show-recipient');

    // поля для валидации
    var name = document.querySelector('#recipientform-firstname');
    var lastName = document.querySelector('#recipientform-lastname');
    var phone = document.querySelector('#recipientform-phone');
    var email = document.querySelector('#recipientform-email');

    if (btnToggle) {
      btnToggle.addEventListener('click', function () {
        // Отрытие и закрытие формы
        if (recipientData.classList.contains('is-open')) {
          close();
        } else {
          open();
        }
      });
    }

    if (btnClose) {
      btnClose.addEventListener('click', function () {
        close();
      });
    }

    function open() {
      recipientData.classList.add('is-open');
      btnToggle.classList.add('is-open');
      btnToggle.textContent = _tr('hide-receiver-fields');

      // запускаем слушатель для валидации
      name.addEventListener('input', validateRecipientData);
      lastName.addEventListener('input', validateRecipientData);
      phone.addEventListener('input', validateRecipientData);
    }

    function close() {
      recipientData.classList.remove('is-open');
      btnToggle.classList.remove('is-open');
      btnToggle.textContent = _tr('specify-receiver-fields');

      // удаляем слушатель для валидации
      name.removeEventListener('input', validateRecipientData);
      lastName.removeEventListener('input', validateRecipientData);
      phone.removeEventListener('input', validateRecipientData);
      name.value = '';
      lastName.value = '';
      phone.value = '';
      email.value = '';
    }


    function validateRecipientData() {
      var input = this;
      // Запрос для валидации
      var $yiiform = $('#js-checkout-form');
      $.ajax({
        method: $yiiform.attr('method'),
        url: $yiiform.attr('action'),
        data: $yiiform.serializeArray(),
        dataType: 'json',
        'success': function (data) {

          // проверяем или есть ошибка
          if (!data['success']) {
            console.log(data['form']);

            if (data['form']['recipient']) {

              // Проверяем какой инпут меняли и выводим ошибку инпуту
              if (input === name) {
                if (data['form']['recipient']['firstName']) {
                  addErrorMessage(name);
                } else {
                  removeErrorMessage(name);
                }
              } else if (input === lastName) {
                if (data['form']['recipient']['lastName']) {
                  addErrorMessage(lastName);
                } else {
                  removeErrorMessage(lastName);
                }
              } else if (input === phone) {
                if (data['form']['recipient']['phone']) {
                  addErrorMessage(phone);
                } else {
                  removeErrorMessage(phone);
                }
              }

              // Убираем вывод сообщения об ошибке под блоком
              if (!name.classList.contains('has-error') && !lastName.classList.contains('has-error')
                && !phone.classList.contains('has-error')) {
                recipientData.classList.remove('has-error-ru');
              }
            } else {
              // Убираем вывод сообщений об ошибках
              removeErrorMessage(name);
              removeErrorMessage(lastName);
              removeErrorMessage(phone);
              recipientData.classList.remove('has-error-ru');
            }
          }

          // Функции для вывода и удаления сообщений об ошибках
          function addErrorMessage(elem) {
            elem.classList.add('has-error');
            recipientData.classList.add('has-error-ru');
          }

          function removeErrorMessage(elem) {
            elem.classList.remove('has-error');
          }
        },
        'error': function (response) {

        }
      });
    }
  }


  /**
   *   Валидируем данныйе о покупателе и открываем следующую форму
   *   в зависимости от выбора страны
   *-----------------------------------------------------*/
  const $countries = $('#deliveryform-country, #profileform-country, #profileform-countryid');
  $countries.find('option').each(function () {
    const option_text = $(this).text().toLowerCase();
    $(this).text(option_text.charAt(0).toUpperCase() + option_text.slice(1));
  });
  // Инициализация Select2 на выборе стран
  $countries.select2({
    sorter: function (data) {
      /* Сортировка по алфавиту */
      return data.sort(function (a, b) {
        a = a.text.toLowerCase();
        b = b.text.toLowerCase();
        if (a > b) {
          return 1;
        } else if (a < b) {
          return -1;
        }
        return 0;
      });
    }
  });

  // Валидируем данныйе о покупателе и открываем следующую форму
  listenerChoicesCountry();

  function listenerChoicesCountry() {
    // Кнопка формы
    var payerDataBtn = document.querySelector('.js-payer-data-btn');
    if (!payerDataBtn) {
      return false;
    }

    // Формы включая эту и следующие
    var blockPayer = document.querySelector('.js-checkout-payer'); // данные о покупателе
    var abroad = document.querySelector('.js-show-abroad'); // если выбрана не Украина
    var delivery = document.querySelector('.js-show-delivery'); // доставка если выбрана Украина
    var payment = document.querySelector('.js-show-payment'); // оплата если выбрана Украина

    // Поля формы
    var nameUser = document.querySelector('#orderform-firstname');
    var lastnameUser = document.querySelector('#orderform-lastname');
    var phoneUser = document.querySelector('#orderform-phone');

    // Чекбокс - с пользовательским соглашеним ознакомлен.
    var acceptTerms = document.querySelector('#accept-terms');
    if (acceptTerms) {
      var wrapperAcceptTerms = acceptTerms.parentElement;
      var labelAcceptTerms = wrapperAcceptTerms.querySelector('[for="accept-terms"]');
    }

    // слушаем или принято соглашение
    acceptTerms.addEventListener('change', function () {
      if (!acceptTerms.checked) {
        blockPayer.classList.add('has-error-accept');
        labelAcceptTerms.classList.add('has-error');
        // Закрываем следующие формы формы
        closeNextForm();
      } else {
        labelAcceptTerms.classList.remove('has-error');
      }
    });

    // Поле выбора страны
    var userCountry = document.querySelector('#deliveryform-country');
    var userCountryChoice = "УКРАИНА";

    // Вешаем слушателя, что бы вырубать формы, при смене страны
    $(userCountry).on("select2:select", function (e) {
      if (userCountry.value !== userCountryChoice) {
        // Закрываем следующие формы формы
        closeNextForm();
      }
      userCountryChoice = userCountry.value;
    });


    // Слушаем или выбран чекбокс - Хочу зарегистрироваться,
    // если выбран, то закрываем поля следующие
    var registrationCheckbox = document.querySelector('#orderform-registration');
    var orderFormPassword = document.querySelector('#orderform-password');
    var orderFormRepeatPassword = document.querySelector('#orderform-repeatpassword');
    if (registrationCheckbox) {
      registrationCheckbox.addEventListener('change', function () {
        if (this.checked) {
          orderFormPassword.classList.remove('has-error');
          orderFormRepeatPassword.classList.remove('has-error');
          // Закрываем следующие формы формы
          closeNextForm();
        } else {
          blockPayer.classList.remove('has-error-password');
        }
      });
    }


    // Закрываем все формы, если начли менять один из полей для пароля
    orderFormPassword.addEventListener('input', function () {
      // Закрываем следующие формы формы
      closeNextForm();
    });
    orderFormRepeatPassword.addEventListener('input', function () {
      // Закрываем следующие формы формы
      closeNextForm();
    });

    // Инициализируем слушателя на изменения в инпутах
    listenValueInput(nameUser);
    listenValueInput(lastnameUser);

    function listenValueInput(elem) {
      if (elem) {
        // После ввода текста убираем рамку error
        elem.addEventListener('input', function () {
          if (this.value.length) {
            elem.classList.remove('has-error');
          } else {
            elem.classList.add('has-error');
            blockPayer.classList.add('has-error-ru');
            // Закрываем следующие формы формы
            closeNextForm();
          }
        });
      }
    }

    // Закрываем следующие формы формы
    function closeNextForm() {
      abroad.classList.remove('is-open');
      delivery.classList.remove('is-open');
      payment.classList.remove('is-open');
    }

    payerDataBtn.addEventListener('click', function () {
      // Запрос для валидации
      var $yiiform = $('#js-checkout-form');
      $.ajax({
        method: $yiiform.attr('method'),
        url: $yiiform.attr('action'),
        data: $yiiform.serializeArray(),
        dataType: 'json',
        'success': function (data) {
          // console.log(data['form']);

          // удаляем ошибки о валидации
          removeErrorMessage();

          // Есть ошибка - выводим текст сообщение об ошибке и оформляем
          if (!data['success'] || !acceptTerms.checked) {

            // console.log(data['form']);

            // Валидация пользовательского соглашения
            if (!acceptTerms.checked) {
              blockPayer.classList.add('has-error-accept');
              labelAcceptTerms.classList.add('has-error');
              // Закрываем следующие формы формы
              closeNextForm();
            }

            // Валидация данных
            if (data['form']) {
              if (data['form']['OrderForm']) {
                listenRespondField(nameUser, data['form']['OrderForm']['firstName']);
                listenRespondField(lastnameUser, data['form']['OrderForm']['lastName']);
                listenRespondField(phoneUser, data['form']['OrderForm']['phone']);

                // Пользователь включил регистрацию
                listenRespondField(orderFormPassword, data['form']['OrderForm']['password']);
                listenRespondField(orderFormRepeatPassword, data['form']['OrderForm']['repeatPassword']);
                if (data['form']['OrderForm']['repeatPassword'] || data['form']['OrderForm']['password']) {
                  blockPayer.classList.add('has-error-password');
                }
              }
            }

            // Добавляем блоку сообщение об ошибке валидации
            blockPayer.classList.add('has-error-ru');

            // Закрываем следующие формы формы
            closeNextForm();
          } else {
            // 1. Убираем сообщения об ошибках
            removeErrorMessage();

            // 2. Показываем слудующий блок с формой
            if (userCountry.value !== '804') {
              abroad.classList.add('is-open');
              scrollToForm(abroad, 1000);
            } else {
              delivery.classList.add('is-open');
              scrollToForm(delivery, 1000);
            }
          }


          // Проверяем или можно показать следующую форму,
          // data['form'] - выдает ошибку изначально с доставкой, хотя форма не открыта,
          // по этому проверяем, что бы уточнить или это связано с формой данных покупателя
          if (data['form'] && acceptTerms.checked) {

            // Проверяем сразу на оба варианта, что бы пропустить дальше заполнять форму
            if (!data['form']['OrderForm'] && acceptTerms.checked) {
              // 1. Убираем сообщения об ошибках
              removeErrorMessage();

              // 2. Показываем слудующий блок с формой
              if (userCountry.value !== '804') {
                abroad.classList.add('is-open');
                scrollToForm(abroad, 1000);
              } else {
                delivery.classList.add('is-open');
                scrollToForm(delivery, 1000);
              }
            }
          }

          // Воспомогательные функции для работы валидации
          function listenRespondField(elem, respond) {
            if (elem) {
              // добавляем рамку error
              if (respond) {
                elem.classList.add('has-error');
              }

              // После ввода текста убираем рамку error
              elem.addEventListener('input', function () {
                if (this.value.length) {
                  elem.classList.remove('has-error');
                } else {
                  elem.classList.add('has-error');
                  blockPayer.classList.add('has-error-ru');
                  // Закрываем следующие формы формы
                  closeNextForm();
                }
              });
            }
          }

          // Удаляем сообщения об ошибках
          function removeErrorMessage() {
            blockPayer.classList.remove('has-error-accept');
            blockPayer.classList.remove('has-error-ru');
            blockPayer.classList.remove('has-error-password');
            labelAcceptTerms.classList.remove('has-error');
            nameUser.classList.remove('has-error');
            lastnameUser.classList.remove('has-error');
            phoneUser.classList.remove('has-error');
            orderFormPassword.classList.remove('has-error');
            orderFormRepeatPassword.classList.remove('has-error');
          }
        },
        'error': function (response) {
        }
      });
    });
  }


  /**
   *   Форма выбора доставки
   *-----------------------------------------------------*/
  $('#couriernpform-city, #officenpform-city')
    .on('select2:open', function () {
      $('.select2-search__field').attr('placeholder', _tr('search'));
    })
    .select2({
      matcher: function (params, data) {
        // If there are no search terms, return all of the data
        if ($.trim(params.term) === '') {
          return data;
        }

        // `params.term` should be the term that is used for searching
        // `data.text` is the text that is displayed for the data object
        if (data.text.toLowerCase().startsWith(params.term.toLowerCase())) {
          return $.extend({}, data, true);
        }

        // Return `null` if the term should not be displayed
        return null;
      },
      sorter: function (data) {
        /* Сортировка по алфавиту */
        return data.sort(function (a, b) {
          a = a.text.toLowerCase();
          b = b.text.toLowerCase();
          if (a > b) {
            return 1;
          } else if (a < b) {
            return -1;
          }
          return 0;
        });
      }
    });


  // Открываем дополнительную форму в зависимости от
  openDeliveryForm();

  function openDeliveryForm() {
    var deliveryChoices = document.querySelectorAll('.js-delivery-choices');
    var deliveryInputs = document.querySelectorAll('.js-delivery-input');

    if (deliveryChoices.length) {
      for (var i = 0; i < deliveryChoices.length; i++) {
        deliveryChoices[i].addEventListener('click', openDeliveryForm);
      }
    }

    function openDeliveryForm() {
      // изменить total cost
      for (var i = 0; i < deliveryInputs.length; i++) {
        if (deliveryInputs[i].checked) {
          var parent = deliveryInputs[i].closest('.js-delivery-item');
          var form = parent.querySelector('.js-delivery-form');
          var formActive = document.querySelector('.js-delivery-form.is-open');

          if (formActive) {
            formActive.classList.remove('is-open');
          }

          form.classList.add('is-open');
        }
      }
    }
  }


  // Показываем номер отделения или магазин только
  showPostOffice();

  function showPostOffice() {
    var body = document.querySelector('body');
    body.addEventListener('click', function (e) {
      var thisElem = e.target;
      if (thisElem.classList.contains('option') && !thisElem.classList.contains('disabled')) {
        $(thisElem).closest('.js-delivery-form').find('.js-delivery-office').addClass('is-show');
      }
    });
  }


  //  Открываем форму выбора оплаты если после
  //  выбора варианта доставки
  openPaymentForm();

  function openPaymentForm() {
    // Форма доставки
    var deliveryForm = document.querySelector('.js-show-delivery');
    if (!deliveryForm) {
      return false;
    }

    // Форма Оплаты
    var paymentForm = document.querySelector('.js-show-payment');


    /**
     *  Валидируем или выбран способ доставки
     * */
      // флаг - меняем на true, если юзер выбрал хоть один вариант доставки
    var deliveryIsChoice = false;

    // переменная хранит вариант выбора доставки
    var deliveryMethod;

    // Вешаем на радиобатоны (выбор доставки) слушатель
    var inputDelivery = deliveryForm.querySelectorAll('.js-delivery-input');
    for (var i = 0; i < inputDelivery.length; i++) {
      // Слушаем первый выбор, что бы удалить ошибку об выборе
      inputDelivery[i].addEventListener('change', listenDeliveryChoiceOnce);
      // Слушаем какой вариант доставки выбрал юзер
      inputDelivery[i].addEventListener('change', listenDeliveryChoice);
    }

    // Для слушателя выбора варианта доставки, после выбора удаляем слушатель
    function listenDeliveryChoiceOnce() {
      // меняем флаг, выбор варианта доставки сделан
      deliveryIsChoice = true;
      // удаляем вывод ошибки
      deliveryForm.classList.remove('has-error-choice');
      // Удаляем слушатель больше не недо слушать или юзер сделал выбор
      for (var i = 0; i < inputDelivery.length; i++) {
        inputDelivery[i].removeEventListener('change', listenDeliveryChoiceOnce);
      }
    }


    // Слушаем какой вариант доставки выбрал юзер
    function listenDeliveryChoice() {
      deliveryMethod = this.dataset.id;
      //Закрываем форму оплаты
      paymentForm.classList.remove('is-open');
      deliveryForm.classList.remove('has-error-empty');

      // Вешаем слушатели, что бы валидировать на сторне клиента
      if (deliveryMethod === '1') {
        var cityCourierMethod = deliveryForm.querySelector('#couriernpform-city');
        var fakeCityCourierMethod = deliveryForm.querySelector('.field-couriernpform-city .select2-selection--single');
        $(cityCourierMethod).on("select2:select", function (e) {
          if (cityCourierMethod.value === 'promt') {
            fakeCityCourierMethod.classList.add('has-error');
            deliveryForm.classList.add('has-error-empty');
            paymentForm.classList.remove('is-open');
          } else {
            fakeCityCourierMethod.classList.remove('has-error');
          }
        });
      } else if (deliveryMethod === '2') {
        // Убираем возможность выбрать пункт по умолчанию
        var cityOfficeMethod = deliveryForm.querySelector('#officenpform-city');
        var fakeCityOfficeMethod = deliveryForm.querySelector('.field-officenpform-city .select2-selection--single');

        $(cityOfficeMethod).on("select2:select", function (e) {
          if (cityOfficeMethod.value === 'promt') {
            fakeCityOfficeMethod.classList.add('has-error');
            deliveryForm.classList.add('has-error-empty');
            officeNPForm.classList.add('disable-input');
            paymentForm.classList.remove('is-open');
          } else {
            fakeCityOfficeMethod.classList.remove('has-error');
          }
        });
      }

    }

    /**
     *  1. Проверяем или выбран один из вариантов доставки
     *  2. Запускаем слушатели для валидации на стороне клиента
     *  3. Отправляем запрос на бекенд для валидации
     **/
      // Кнопка перехода к форме выбору варианта оплаты
    var verifyDelivery = deliveryForm.querySelector('.js-verify-delivery');
    verifyDelivery.addEventListener('click', function () {

      // ============================================================================= //
      // 1. Проверяем или выбран один из вариантов доставки
      // ============================================================================= //
      if (!deliveryIsChoice) {
        deliveryForm.classList.add('has-error-choice');
        return false;
      }


      // ============================================================================= //
      // 2. Запускаем слушатели для валидации на стороне клиента
      // ============================================================================= //
      // Поля Курьерской доставки
      var cityCourierMethod = deliveryForm.querySelector('#couriernpform-city');
      var reserveAddress = $('#storereservationform-city');
      var fakeReserveAddress = reserveAddress.next();
      var fakeCityCourierMethod = deliveryForm.querySelector('.field-couriernpform-city .select2-selection--single');
      var streetCourierMethod = deliveryForm.querySelector('#couriernpform-street');
      var houseCourierMethod = deliveryForm.querySelector('#couriernpform-house');

      // Поле доставки в отделение
      var cityOfficeMethod = deliveryForm.querySelector('#officenpform-city');
      var fakeCityOfficeMethod = deliveryForm.querySelector('.field-officenpform-city .select2-selection--single');


      // Очищаем ошибки во всех полях
      streetCourierMethod.classList.remove('has-error');
      houseCourierMethod.classList.remove('has-error');
      deliveryForm.classList.remove('has-error-empty');
      fakeCityOfficeMethod.classList.remove('has-error');

      // Вешаем слушатели, что бы валидировать на сторне клиента
      if (deliveryMethod === '1') {
        if (cityCourierMethod.value !== 'promt') {
          fakeCityCourierMethod.classList.remove('has-error');
        } else {
          fakeCityCourierMethod.classList.add('has-error');
          deliveryForm.classList.add('has-error-empty');
          paymentForm.classList.remove('is-open');
        }

        streetCourierMethod.addEventListener('change', function () {
          if (this.value !== "") {
            this.classList.remove('has-error');
          } else {
            this.classList.add('has-error');
            deliveryForm.classList.add('has-error-empty');
            paymentForm.classList.remove('is-open');
          }
        });

        houseCourierMethod.addEventListener('change', function () {
          if (this.value !== "") {
            this.classList.remove('has-error');
          } else {
            this.classList.add('has-error');
            deliveryForm.classList.add('has-error-empty');
            paymentForm.classList.remove('is-open');
          }
        });
      } else if (deliveryMethod === '2') {

        fakeCityOfficeMethod.addEventListener('click', function () {
          setTimeout(function () {
            if (cityOfficeMethod.value !== 'promt') {
              fakeCityOfficeMethod.classList.remove('has-error');
            } else {
              fakeCityOfficeMethod.classList.add('has-error');
              deliveryForm.classList.add('has-error-empty');
              paymentForm.classList.remove('is-open');
            }
          }, 200);
        });
      } else {
        if (reserveAddress.val() !== 'promt') {
          fakeReserveAddress.removeClass('has-error');
        } else {
          fakeReserveAddress.addClass('has-error');
          deliveryForm.classList.add('has-error-empty');
          paymentForm.classList.remove('is-open');
          return;
        }
      }

      // ============================================================================= //
      // 3. Отправляем запрос на бекенд для валидации
      // ============================================================================= //
      var $yiiform = $('#js-checkout-form');
      $.ajax({
        method: $yiiform.attr('method'),
        url: $yiiform.attr('action'),
        data: $yiiform.serializeArray(),
        dataType: 'json',
        'success': function (data) {

          // когда открыли форму оплаты и изменили данные в первой форме,
          // при невалидности закроет все формы кроме первой,
          // но будет валидировать форму оплаты,
          // в этом случае пропускаем дальше
          if (!data['success'] && data['form']['paymentForm']) {
            paymentForm.classList.add('is-open');
            deliveryForm.classList.remove('has-error-empty');
            checkPaymentMethod();

            scrollToForm(paymentForm, 1000);
            return false;
          }

          // пропускать валидацию данных пользователя
          if (!data['success']) {

            if (data['form']['recipient'] && !data['form']['courierNp'] &&
              !data['form'][['officeNp']]) {

              paymentForm.classList.add('is-open');
              deliveryForm.classList.remove('has-error-empty');
              checkPaymentMethod();

              scrollToForm(paymentForm, 1000);
            }
          }

          // Если не прошло валидацию зайдет в этот блок
          if (!data['success']) {

            // Делаем проверку в зависимости от выбора способа доставки
            if (deliveryMethod === '1') {

              // Валидируем поле Город
              if (cityCourierMethod.value === 'promt') {
                fakeCityCourierMethod.classList.add('has-error');
                deliveryForm.classList.add('has-error-empty');
              }

              // Валидируем поле Улица
              if (data['form']) {
                if (data['form']['courierNp']) {
                  if (data['form']['courierNp']['street']) {
                    streetCourierMethod.classList.add('has-error');
                    deliveryForm.classList.add('has-error-empty');
                  }
                }
              }

              // Валидируем поле Дом(номер)
              if (data['form']) {
                if (data['form']['courierNp']) {
                  if (data['form']['courierNp']['house']) {
                    houseCourierMethod.classList.add('has-error');
                    deliveryForm.classList.add('has-error-empty');
                  }
                }
              }
            } else if (deliveryMethod === '2') {
              // не выбрано отделение
              if (data['form']) {
                if (data['form']['officeNp']) {
                  if (data['form']['officeNp']['branch']) {
                    if (cityOfficeMethod.value === 'promt') {
                      fakeCityOfficeMethod.classList.add('has-error');
                      deliveryForm.classList.add('has-error-empty');
                    }
                  }
                }
              }
            } else if (deliveryMethod === 'Бронирование товаров в магазине') {
              // console.log(data['form']);
            }
          } else {

            // С бекенда не валидирует эти поля,
            // по этому валидируем его и тут еще
            if (deliveryMethod === '1') {
              // Валидируем поле Город
              if (cityCourierMethod.value === 'promt') {
                fakeCityCourierMethod.classList.add('has-error');
                deliveryForm.classList.add('has-error-empty');
                paymentForm.classList.remove('is-open');
                return false;
              }
            } else if (deliveryMethod === '2') {
              console.log(cityOfficeMethod.value);
              // не выбрано отделение
              if (cityOfficeMethod.value === 'promt') {
                fakeCityOfficeMethod.classList.add('has-error');
                deliveryForm.classList.add('has-error-empty');
                paymentForm.classList.remove('is-open');
                return false;
              }
            }

            // Все прошло валидацию
            paymentForm.classList.add('is-open');
            deliveryForm.classList.remove('has-error-empty');
            checkPaymentMethod();
            scrollToForm(paymentForm, 1000);
            // select first payment option
            $('.js-payment-input').first().trigger('click');
            const totalPrice = document.querySelector('.js-cart-popup-cost-total').getAttribute('data-cost');
            visiblePortionPayment(totalPrice);
          }
        },
        'error': function (response) {
        }
      });
    })
  }


  /**
   *   Способы оплаты
   *----------------------------------------------------------------------------*/
  // Показываем дополнительныце данные
  // после выбора варианта оплаты
  openPaymentInformation();

  function openPaymentInformation() {
    var paymentChoices = document.querySelectorAll('.js-payment-choices');
    var paymentInputs = document.querySelectorAll('.js-payment-input');

    if (paymentChoices.length) {
      for (var i = 0; i < paymentChoices.length; i++) {
        paymentChoices[i].addEventListener('click', openPaymentInfo);
      }
    }

    function openPaymentInfo() {
      // var formActive = document.querySelector('.js-payment-form.is-open');
      // if (formActive) {
      // 	formActive.classList.remove('is-open');
      // }

      for (var i = 0; i < paymentInputs.length; i++) {
        if (paymentInputs[i].checked) {
          var parent = paymentInputs[i].closest('.js-payment-item');
          var form = parent.querySelector('.js-payment-form');
          form.classList.add('is-open');
        }
      }
    }
  }


  // Pенж срока оплаты частями в оформлении заказа
  function initPayPartRange() {
    var payPartRange = document.querySelector('.js-pay-part-range');

    if (payPartRange) {
      // Берем все настройки с data атрибутов, куда они попадают с админки
      var value = +payPartRange.getAttribute('data-value');
      var step = +payPartRange.getAttribute('data-step');
      var min = +payPartRange.getAttribute('data-min');
      var max = +payPartRange.getAttribute('data-max');

      noUiSlider.create(payPartRange, {
        start: [value],
        connect: [true, false],
        step: step,
        range: {
          'min': min,
          'max': max
        },
        tooltips: true,
        format: {
          to: function (value) {
            return parseInt(value);
          },
          from: function (value) {
            return parseInt(value);
          }
        }
      });

      payPartRange.noUiSlider.on('update', function (values, handle) {
        var $input = $('[name="PaymentForm[parts]"]');
        var valueRange = parseInt(values[handle]);
        $input.val(valueRange);
      });
    }
  }


  /**
   *  1. Проверяем или выбран способ оплаты
   *  2. Проверка или поля выше заполнены корректно (поля с данными получателя)
   *  3. Валидация выбора оплаты (каждого варианта)
   *  4. Валидация формы продажи за бугор
   *----------------------------------------------------------------------------*/
    // ============================================================================= //
    // 1. Проверяем или выбран способ оплаты
    // Вызов идет в функции openPaymentForm
    // ============================================================================= //
  var paymentMethod;

  function checkPaymentMethod() {
    // Форма - выбор варианта оплаты
    var paymentForm = document.querySelector('.js-show-payment');
    if (!paymentForm) {
      return false;
    }

    // Варианты оплаты
    var paymentMethodInput = paymentForm.querySelectorAll('.js-payment-input');
    for (var i = 0; i < paymentMethodInput.length; i++) {
      paymentMethodInput[i].addEventListener('change', function () {
        paymentMethod = this.value;
      });
    }
    // $('.js-payment-input').trigger('click');
  }

  initPaymentValidation();

  function initPaymentValidation() {
    var paymentForm = document.querySelector('.js-show-payment');
    if (!paymentForm) {
      return false;
    }

    $('.js-check-form-sub').on('click', function () {
      var $yiiform = $('#js-checkout-form');
      //var result = false;
      //$yiiform.attr('method'),
      //  url: $yiiform.attr('action'),
      //  data: $yiiform.serializeArray()


      // ============================================================================= //
      // 2. Проверка или поля выше заполнены корректно
      // ============================================================================= //
      // Валидируем если выбрана Украина
      var userCountryChoice = document.querySelector('#deliveryform-country');
      if (userCountryChoice.value === '804') {
        // Проверяем или выбран хоть один вариант метода оплаты
        if (!paymentMethod) {
          paymentForm.classList.add('has-error-choice');
          return false;
        }
      }


      // Поля формы данных получателя
      var recipientForm = document.querySelector('.js-show-recipient');
      var recipientFirstName = document.querySelector('#recipientform-firstname');
      var recipientLastName = document.querySelector('#recipientform-lastname');
      var recipientPhone = document.querySelector('#recipientform-phone');

      // Поля формы продажи за бугор
      var abroadForm = document.querySelector('.abroad-form');
      var foreignerState = document.querySelector('#foreignersupform-state');
      var foreignerCity = document.querySelector('#foreignersupform-city');
      var foreignerStreet = document.querySelector('#foreignersupform-street');
      var foreignerHouse = document.querySelector('#foreignersupform-house');
      var foreignerIndex = document.querySelector('#foreignersupform-index');


      // удаляем сообщения об ошибках
      abroadForm.classList.remove('has-error-empty');
      paymentForm.classList.remove('has-error-choice');
      recipientFirstName.classList.remove('has-error');
      recipientLastName.classList.remove('has-error');
      recipientPhone.classList.remove('has-error');
      recipientForm.classList.remove('has-error-ru');

      foreignerState.classList.remove('has-error-ru');
      foreignerCity.classList.remove('has-error-ru');
      foreignerStreet.classList.remove('has-error-ru');
      foreignerHouse.classList.remove('has-error-ru');
      foreignerIndex.classList.remove('has-error-ru');


      $('#foreignersupform-cost').val('200');
      // Отправляем запрос для валидации
      $.ajax({
        method: $yiiform.attr('method'),
        url: $yiiform.attr('action'),
        data: $yiiform.serializeArray(),
        dataType: 'json',
        'success': function (data) {
          // отправляем, если все ок
          if (data['success']) {
            $yiiform.submit();
          } else {
            console.log(data['form']);
            if (data['form']) {
              // ============================================================================= //
              // 3. Валидация выбора оплаты (каждого варианта)
              // ============================================================================= //
              // Оплата банковской картой - юзер не выбрал систему
              if (data['form']['paymentForm']) {
                if (data['form']['paymentForm']['typePayment']) {
                  paymentForm.classList.add('has-error-choice');
                }
              }

              // Проверяем форму - данные получателя
              if (data['form']['recipient']) {
                // сообщение об ошибке на блоке
                recipientForm.classList.add('has-error-ru');

                // сообщение об ошибке на инпуте
                if (data['form']['recipient']['firstName']) {
                  recipientFirstName.classList.add('has-error');
                  validateInput(recipientFirstName);
                }

                // сообщение об ошибке на инпуте
                if (data['form']['recipient']['lastName']) {
                  recipientLastName.classList.add('has-error');
                  validateInput(recipientLastName);
                }

                // сообщение об ошибке на инпуте
                if (data['form']['recipient']['phone']) {
                  recipientPhone.classList.add('has-error');
                  validateInput(recipientPhone);
                }
                // console.log(data['form']['recipient']);
                scrollToForm(recipientForm, 1000);
              }

              // ============================================================================= //
              // 4. Валидация формы продажи за бугор
              // ============================================================================= //
              if (data['form']['foreignersUp']) {
                abroadForm.classList.add('has-error-empty');

                if (data['form']['foreignersUp']['state']) {
                  foreignerState.classList.add('has-error');
                  validateInput(foreignerState);
                }

                if (data['form']['foreignersUp']['index']) {
                  foreignerIndex.classList.add('has-error');
                  validateInput(foreignerIndex);
                }

                if (data['form']['foreignersUp']['city']) {
                  foreignerCity.classList.add('has-error');
                  validateInput(foreignerCity);
                }

                if (data['form']['foreignersUp']['street']) {
                  foreignerStreet.classList.add('has-error');
                  validateInput(foreignerStreet);
                }

                if (data['form']['foreignersUp']['house']) {
                  foreignerHouse.classList.add('has-error');
                  validateInput(foreignerHouse);
                }
              }
            }
          }

          function validateInput(elem) {
            if (elem) {
              // После ввода текста убираем рамку error
              elem.addEventListener('input', function () {
                if (this.value.length) {
                  elem.classList.remove('has-error');
                } else {
                  elem.classList.add('has-error');
                  recipientForm.classList.add('has-error-ru');
                }
              });
            }
          }
        },
        'error': function (response) {

        }
      });


      // $.ajax({
      //         type: $yiiform.attr('method'),
      //         url: $yiiform.attr('action'),
      //         data: $yiiform.serializeArray(),
      //     }
      // )
      //     .done(function(data) {
      //         if(data.success) {
      //             alert('success');
      //
      //             $(this).submit();
      //             // data is saved
      //         } else if (data.validation) {
      //             return false;
      //             // server validation failed
      //             $yiiform.yiiActiveForm('updateMessages', data.validation, true); // renders validation messages at appropriate places
      //         } else {
      //             // incorrect server response
      //         }
      //     })
      //     .fail(function () {
      //         // request failed
      //     })

      //ff();
      //return false; // prevent default form submission
    });
  }

  /**
   * elem - строка-селектор или нод элемент
   * speed - скорость прокрутки
   * */
  function scrollToForm(elem, speed) {
    $("html, body").animate({
        scrollTop: elem.getBoundingClientRect().top + pageYOffset - 40
      }, speed
    );
  }

  $('.js-delivery-method').on('change', function () {
    const id = $(this).data('id');
    let cityId;

    switch (id) {
      case 1:
        const $couriernpform = $('#couriernpform-city');
        cityId = $couriernpform.val();
        if (cityId !== 'promt') {
          $couriernpform.trigger('change');
        }
        if (deliveryCostAddress) {
          addToTotalPrice(deliveryCostAddress);
          updateDeliveryCost(deliveryCostAddress);
        }
        break;
      case 2:
        const $officenpform = $('#officenpform-city');
        cityId = $officenpform.val();
        if (cityId !== 'promt') {
          $officenpform.trigger('change');
        }
        if (deliveryCostOffice) {
          addToTotalPrice(deliveryCostOffice);
          updateDeliveryCost(deliveryCostOffice);
        } else {
          updateDeliveryCost(0);
        }
        break;
      default:
        updateDeliveryCost(0);
        addToTotalPrice(0);
        $('#orderform-cost').val(0);
    }
  });

  // $('.abroad-form__about-payment')

});
