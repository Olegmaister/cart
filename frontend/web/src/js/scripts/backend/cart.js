function generateSizes(data, giftId, container) {
  container.empty();
  $.each(data, function (k, v) {
    const $sizeButton = $('<div class="sizes-switch__item sizes-switch__item--stock"' +
      ' data-option-id="' + v.option_id + '">' + v.name + '</div>')
    $sizeButton.on('click', function () {
      $('#gift-sizes .sizes-switch__item').removeClass('sizes-switch__item--active');
      $(this).addClass('sizes-switch__item--active');
      $('.js-product-add-cart-main')
        .attr('data-option-id', v.option_id)
        .attr('data-gift-name', v.name)
        .attr('data-gift-id', giftId);
    });
    container.append($sizeButton);
    if (k === 0) {
      $sizeButton.trigger('click');
    }
  });
}

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

// Добавление товара в корзину со страницы сравнения
$('.js-compare-add-cart').on('click', function (e) {
  // Удаляем класс для пустой корзины
  $('.modal--cart').removeClass('cart-is-empty');

  e.preventDefault();

  let $productCard = $(this).parents('.p-compare-slider-col-inner');
  let $option = $productCard.find('.sizes-switch__item--active');
  let $selectedColor = $productCard.find('.product-colors__item._active');

  let data = {
    option: $option.data('option_id'),
    optionName: $option.text(),
    productColorImage: $selectedColor.find('img').attr('src'),
    productId: $selectedColor.find('img').data('product-id'),
    quantity: 1
  };
  $.ajax({
    url: '/' + currentLang() + '/cart/add',
    method: 'post',
    data: data,
    success: function (data) {
      if (data['success'] === true) {
        updateCart(data);
      }

      scrollLock();
    }
  });
});

// Добавление товара в корзину со страницы товара
$('.js-product-add-cart').on('click', function (e) {

  if (!isGiftSelected()) {
    return false;
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
  let presentOptionId = $(this).attr('data-gift-option-id');
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
    url: '/' + currentLang() +'/cart/add',
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

//Добавление товара в корзину не со страницы товара
function initOpenModalSize() {

  // Модалка с размерами
  let modalSize = document.querySelector('.modal--size');

  // Выходим, если нет модалки
  if (!modalSize) {
    return false;
  }

  // Клик по кнопке-иконке корзина на карточке товара
  // ловим событие на документе, что бы ловить и элементы добавлены динамически
  document.addEventListener('click', function (event) {
    let target = event.target.closest('.js-open-modal-size');
    if (!target) return false;

    // Удаляем класс для пустой корзины
    $('.modal--cart').removeClass('cart-is-empty');

    // карточка товара
    let productCard = target.closest('.product-card');

    // Находим ссылку на товар с данными о товаре - размер и id
    let productLink = productCard.querySelector('.js-product-card-img-slider .slick-current .product-card__img-link');

    // Ссылка на изображение товара
    let productImg = productCard.querySelector('.js-product-card-color-slider .slick-current img');
    let productUrlImg;
    if (productImg) {
      productUrlImg = productImg.getAttribute('src');
    } else {
      productUrlImg = '/images/colors/000000002.jpg'
    }

    // ID товара
    let productId = productLink.getAttribute('data-product-id');

    // тут лежит JSON
    let productSizeJson = productLink.getAttribute('data-sizes');

    // массив с option_id (id размера) и name (наименование размера)
    let productSizeArr = JSON.parse(productSizeJson);
    if (!productSizeArr) return;

    // Кнопка "Добавить в корзину"
    let btnAddToCard = modalSize.querySelector('.js-product-add-cart-main');

    // Контейнер где лежат кнопки выбора цвета в модалке
    let sizeContainer = modalSize.querySelector('.sizes-switch');
    sizeContainer.innerHTML = ''; // Очищаем

    // Рисуем кнопка с выбором размера
    for (let i = 0; i < productSizeArr.length; i++) {
      // Создаем кнопку размера
      let sizeButton = document.createElement('div');
      const disabled = parseInt(productSizeArr[i].quantity) === 0;

      // Задаем атрибут, что бы мжно было с клавиатуры переключать
      sizeButton.setAttribute('tabindex', '0');

      // Если кнопка первая, то задаем ей активный класс
      if (i === 0) {
        sizeButton.classList.add(
          "sizes-switch__item",
          "sizes-switch__item--stock",
          "sizes-switch__item--active"
        );
      } else {
        if (!disabled) {
          sizeButton.classList.add(
            "sizes-switch__item",
            "sizes-switch__item--stock"
          );
        } else {
          sizeButton.classList.add(
            "sizes-switch__item",
          );
        }
      }
      // Передаем название размера в кнопку
      sizeButton.textContent = productSizeArr[i].name;

      // Передаем данные для дальнейших манипуляций
      // 'option'
      sizeButton.setAttribute('data-option-id', productSizeArr[i].option_id);
      // 'optionName'
      sizeButton.setAttribute('data-option-name', productSizeArr[i].name);

      // Закидываем элемент в верстку
      sizeContainer.append(sizeButton);

      // Клик по кнопке выбора размера, что бы менять option и optionName
      sizeButton.addEventListener('click', function () {
        // 'option'
        let option = this.getAttribute('data-option-id');
        btnAddToCard.setAttribute('data-option-id', option);
        // 'optionName'
        let optionName = this.getAttribute('data-option-name');
        btnAddToCard.setAttribute('data-option-name', optionName);
      });
    }

    // Передаем в кнопку все параметры
    // 'productId'
    btnAddToCard.setAttribute('data-product-id', productId);
    // 'quantity'
    let quantity = 1;
    btnAddToCard.setAttribute('data-quantity', quantity);
    // 'option'
    btnAddToCard.setAttribute('data-option-id', productSizeArr[0].option_id);
    // 'optionName'
    btnAddToCard.setAttribute('data-option-name', productSizeArr[0].name);
    // 'productColorImage'
    btnAddToCard.setAttribute('data-color-image-url', productUrlImg);

    // делаем запрос на получение подароков товара и его размеров
    $.ajax({
      url: '/present/index',
      data: {
        id: productId
      },
      success: function (res) {
        if (res.success && res.presents.length) {
          $('#choose-gift').show();
          $('#modal-gifts-select')
            .on('change', function (e) {
              const sizes = $.grep(res.presents, function (el) {
                return el.id === +e.target.value
              })[0].sizes;
              generateSizes(sizes, e.target.value, $('#gift-sizes'));
            })
            .select2({
              minimumResultsForSearch: Infinity,
              dropdownParent: $('.modal--size'),
              data: res.presents,
              templateSelection: function (state) {
                if (!state.id) {
                  return state.text;
                }
                const $state = $(
                  '<span class="select2-product"><img/><span></span></span>'
                );
                $state.find('span').text(state.text);
                $state.find('img').attr('src', state.image);

                return $state;
              },
              templateResult: function (state) {
                if (!state.id) {
                  return state.text;
                }
                const $state = $(
                  '<span class="select2-product"><img src="' + state.image + '"/> ' + state.text + '</span>'
                );
                return $state;
              }
            })
            .trigger('change');
        } else {
          $('#choose-gift').hide();
        }
      }
    });


  }, true);


  // Кнопка "Добавить в корзину"
  let btnAddToCard = modalSize.querySelector('.js-product-add-cart-main');
  if (btnAddToCard) {
    btnAddToCard.addEventListener('click', function () {

      let productId = this.getAttribute('data-product-id');
      let quantity = 1;
      let optionId = this.getAttribute('data-option-id');
      let optionName = this.getAttribute('data-option-name');
      let productColorImage = this.getAttribute('data-color-image-url');
      let giftOptionId = this.getAttribute('data-option-id');
      let giftId = this.getAttribute('data-gift-id');
      let presentOptionName = this.getAttribute('data-gift-name');

      $.ajax({
        url: '/' + currentLang() + '/cart/add',
        method: 'post',
        data: {
          'productId': productId,
          'quantity': quantity,
          'option': optionId,
          'optionName': optionName,
          'productColorImage': productColorImage,
          'presentProductId': giftId,
          'presentOptionId': giftOptionId,
          'presentOptionName': presentOptionName,
          'languageId': currentLang()
        },
        success: function (data) {
          if (data['success'] === true) {
            $('.modal--size').attr('style', '');
            updateCart(data);
          }

          scrollLock();
        }
      });
    })
  }
}

initOpenModalSize();
/* Конец
**==================== Добавление товара в корзину ====================*/


/* НАЧАЛО
**================== Удаление товара из корзины ====================*/
// Удаление из корзины в хедере
$(document).on('click', '.js-header-remove-product-cart', function () {
  // Параметры для ajax запросы
  let productId = $(this).data('product-id');
  let optionId = $(this).data('option');

  // Вычисляем обвертку корзины в хедере, а то их там сейчас 4 шт....
  let $wrapperCards = $(this).closest('.js-wrapper-header-cart');

  // Удаляем блок с товаром по клику
  $(this).closest('.js-header-product-cart').remove();
  $wrapperCards.find('[data-id="' + productId + '"][data-option="' + optionId + '"]').remove();

  // Зайдет в блок если не осталось товаров в корзине - меняем html что бы показать, что корзина пуста
  if (!$wrapperCards.find('.js-header-product-cart').length) {
    let $cartPopup = $wrapperCards.find('.cart-m-popup');
    let innerEmptyCart = '<div class="cart-m-popup-inner"></div><span class="cart__empty">Корзина пустая</span>';
    $cartPopup.html(innerEmptyCart);
  }


  // Удаляем товар из корзины в открытой корзины на странице оформления
  let $openCart = $('.js-product-cart');

  // Удаляем блок с товаром по клику
  $('.js-remove-product-cart[data-product-id="' + productId + '"]').closest('.js-cart-card').remove();

  // Зайдет в блок если не осталось товаров в корзине - меняем html что бы показать, что корзина пуста
  if (!$openCart.find('.js-remove-product-cart').length) {
    // Добавляем в корзину надпись, если она пуста
    let innerEmptyCart = '<div class="title-h2 title--red text-center mt-4">Ваша корзина пуста</div>';
    $openCart.html(innerEmptyCart);
    $openCart.css({
      'display': 'flex',
      'justify-content': 'center',
      'align-items': 'center',
      'overflow-y': 'hidden',
      'padding-right': '0'
    });
  }

  $.ajax({
    url: '/cart/remove',
    method: 'post',
    data: {
      'productId': productId,
      'optionId': optionId
    },
    success: function (data) {
      if (data['success'] === true) {
        deleteProductCard(data);
      }
    }
  });
});

// Удаление из попап корзины
$(document).on('click', '.js-remove-product-cart', function () {
  // Параметры для ajax запросы
  let productId = $(this).data('product-id');
  let optionId = $(this).data('option');

  // Вычисляем обвертку корзины
  let $wrapperCards = $(this).closest('.js-product-cart');
  // удаляем все подарки товара
  $(this).closest('.js-cart-card').nextAll('.product-cart-presents').remove();

  // Удаляем блок с товаром по клику
  $(this).closest('.js-cart-card').remove();
  $wrapperCards.find('[data-id="' + productId + '"][data-option="' + optionId + '"]').remove();

  // Зайдет в блок если не осталось товаров в корзине - меняем html что бы показать, что корзина пуста
  if (!$wrapperCards.find('.js-cart-card').length) {

    if (window.location.pathname === '/checkout/simplecheckout') {
      window.location.replace('/');
    }
    // Добавляем в корзину надпись, если она пуста
    let innerEmptyCart = '<div class="title-h2 title--red text-center mt-4">Ваша корзина пуста</div>';
    $wrapperCards.html(innerEmptyCart);
    $wrapperCards.css({
      'display': 'flex',
      'justify-content': 'center',
      'align-items': 'center',
      'overflow-y': 'hidden',
      'padding-right': '0'
    });

    // Скрываем элементы
    $('.modal--cart').addClass('cart-is-empty');
  }


  // Удаляем товар из корзины в хедере
  $('.js-header-remove-product-cart[data-product-id="' + productId + '"]').closest('.js-header-product-cart').remove();
  if (!$('.js-header-remove-product-cart').length) {
    let $cartPopup = $('.js-wrapper-header-cart .cart-m-popup');
    let innerEmptyCart = '<div class="cart-m-popup-inner"></div><span class="cart__empty">Корзина пустая</span>';
    $cartPopup.html(innerEmptyCart);
  }

  $.ajax({
    url: '/cart/remove',
    method: 'post',
    data: {
      'productId': productId,
      'optionId': optionId
    },
    success: function (data) {
      if (data['success'] === true) {
        deleteProductCard(data);
      }
    }
  });
});

function deleteProductCard(data) {
  // Меняем стоимость товаров в попап корзинке
  $('.js-cart-popup-cost-total').text(data['total']);

  // Если товаров 0, то не отображать 0 в хедере под иконкой корзины
  if (+data['quantity'] === 0) {
    $('.js-cart-quantity-items').text('');
  } else {
    $('.js-cart-quantity-items').text(data['quantity']);
  }

  // Меняем стоимость товаров - функционал не реализован на обычных страницах
  $('.js-discount-money').text(data['discountMoney']);
  // if ( data['discountPercent'] ) {
  //     $('.js-discount-percent').text(data['discountPercent']);
  // }
}

/* КОНЕЦ
**================== Удаление товара из корзины ====================*/


$('.js-delivery-method').on('change', function () {
  let idPayment = $(this).data('id');
});

$('.js-promo-discount').on('click', function () {
  let promo = $('.promo-form__input').val();

  $.ajax({
    url: '/' + currentLang() + '/checkout/promo',
    method: 'post',
    data: {
      'promo': promo
    },
    success: function (data) {

    }
  });

});


/* НАЧАЛО
* *=========== Функционал счетчика - каунтер товара ==========*/
// 1. Запускаем плагин счетчика товара
// 2. Вешаем доплнительно клик на кнопки для перерасчета товара
initProductCounter();

function initProductCounter() {

  // 1. Запускаем плагин счетчика товара
  var $handleCounter = $('[data-handle-counter]');
  for (var i = 0; i < $handleCounter.length; i++) {
    $handleCounter.eq(i).handleCounter({
      minimum: 1,
      maximize: 9999
    });
  }

  // 2. Вешаем доплнительно клик на кнопки для перерасчета товара
  var counters = document.querySelectorAll('.handle-counter');
  if (!counters.length) {
    return false;
  }

  for (let i = 0; i < counters.length; i++) {
    let plusBtn = counters[i].querySelector('.counter-plus');
    let minusBtn = counters[i].querySelector('.counter-minus');
    let input = counters[i].querySelector('.js-change-quantity-product-cart');

    if (plusBtn) {
      plusBtn.addEventListener('click', function () {
        const firstPresentCount = $(input).parents('.js-cart-card').next('.product-cart-presents').find('.item-count');
        const stringQty = firstPresentCount.text();
        let firstCount = extractNumberQty(stringQty);
        firstCount++
        firstPresentCount.text(updateStringQty(stringQty, firstCount));
        changeQuantityProduct(input);
      });
    }

    if (minusBtn) {
      minusBtn.addEventListener('click', function () {
        changeQuantityProduct(input);
        const allNextPresents = $(input).parents('.js-cart-card').nextAll('.product-cart-presents');
        const lastItem = allNextPresents.last();
        const lastQty = lastItem.find('.item-count');
        let lastCount = extractNumberQty(lastQty.text());
        if (lastCount > 1) {
          const text = lastQty.text();
          lastCount--;
          lastQty.text(updateStringQty(text, lastCount));
        } else {
          lastItem.remove();
        }
      });
    }
  }
}

// Изменения кол-ва товара при вводе в поле
$(document).on('change', '.js-change-quantity-product-cart', function () {
  changeQuantityProduct(this);
});

// Функция отправляет запрос для перерасчета стоимости и смены вьюхи
// input - может бысть строка-селектор или Nod-элемент (нативная выборка)
function changeQuantityProduct(input) {
  let productId = $(input).data('product-id');
  let optionId = $(input).data('option');
  let quantity = $(input).val();


  $.ajax({
    url: '/cart/quantity',
    method: 'post',
    data: {
      'productId': productId,
      'quantity': quantity,
      'optionId': optionId
    },
    success: function (data) {
      if (data['success'] === true) {
        const $costTotal = $('.js-cart-popup-cost-total');
        const $delivery = $('.js-order-cart-delivery-cost');
        visiblePortionPayment(data['total']);

        if ($delivery.text() !== '') {
          $costTotal.attr('data-cost', data['total']);
          $costTotal.text(data['total'] + parseInt($delivery.text()));
        } else {
          $costTotal.attr('data-cost', data['total']);
          $costTotal.text(data['total']);
        }

        $('.js-discount-money').text(data['discountMoney']);

        // if ( data['discountPercent'] ) {
        //     $('.js-discount-percent').text(data['discountPercent']);
        // }
      }
    }
  });
}

/* КОНЕЦ
* *=========== Функционал счетчика - каунтер товара ==========*/