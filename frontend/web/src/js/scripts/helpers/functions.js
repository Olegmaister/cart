const $body = $('body');
const IS_LOGGED = $body.data('login');

function notify(text, timeout = 4000) {
  const $close = $('<button></button>');
  const $message = $('<div class="pig-notify">' + text + '</div>');
  $message.append($close);

  $body.append($message);

  setTimeout(function () {
    $message.fadeOut(function () {
      $(this).remove();
    });
  }, timeout)

  $close.on('click', function () {
    $message.fadeOut(function () {
      $(this).remove();
    });
  });
}

function visiblePortionPayment(totalPrice) {
  const $option = $('input[value="3"]').closest('.js-payment-item');
  if (totalPrice <= 500 || totalPrice >= 50000) {
    $option.hide();
  } else {
    $option.show();
  }
}

const LANGUAGES = {
  'ru-RU': {
    'required': 'Необходимо заполнить',
    'wrong-confirm-code': 'Код указан не верно',
    'sms': 'СМС',
    'fav-added': 'Добавлено в список желаний',
    'fav-add': 'Добавить в список желаний',
    'reserve-thanks': 'Спасибо за резервирование заказа',
    'your-order': 'Ваш заказ',
    'awaits-you': 'будет дожидаться вас в магазине',
    'schedule': 'Режим работы',
    'hide-receiver-fields': 'Скрыть данные получателя',
    'specify-receiver-fields': 'Указать данные получателя',
    'choose-size': 'Выберите размер',
    'stock-watch-success': 'Вы успешно подписались на уведомления о наличии товара',
    'cancel-stock-sub': 'Отменить уведомление',
    'stock-sub': 'Сообщить о наличии',
    'search': 'Поиск',
    'up-to-5': 'До 5 мес',
    'copy-loc': 'Координаты скопированы',
  },
  'ua-UA': {
    'required': 'Нобхідно заповнити',
    'wrong-confirm-code': 'Код вказаний не вірно',
    'sms': 'СМС',
    'fav-added': 'Добавлено в список бажань',
    'fav-add': 'Добавити в список бажань',
    'reserve-thanks': 'Дякуємо за резервування замовлення',
    'your-order': 'Ваше замовлення',
    'awaits-you': 'буде чекати вас в магазині',
    'schedule': 'Режим роботи',
    'hide-receiver-fields': 'Сховати дані одержувача',
    'specify-receiver-fields': 'Вказати дані одержувача',
    'choose-size': 'Виберіть розмір',
    'stock-watch-success': 'Ви успішно підписались на сповіщення про наявність товару',
    'cancel-stock-sub': 'Відмінити повідомлення',
    'stock-sub': 'Повідомити про наявність',
    'search': 'Пошук',
    'up-to-5': 'До 5 міс',
    'copy-loc': 'Координати скопійовані',
  },
  'en-EN': {
    'required': 'This field is required',
    'wrong-confirm-code': 'Entered code is wrong',
    'sms': 'SMS',
    'fav-added': 'Added to wishlist',
    'fav-add': 'Add to wishlist',
    'reserve-thanks': 'Thank you for your reservation',
    'your-order': 'Your order',
    'awaits-you': 'awaits you at store',
    'schedule': 'Schedule',
    'hide-receiver-fields': 'Hide receiver details',
    'specify-receiver-fields': 'Specify receiver fields',
    'choose-size': 'Choose size',
    'stock-watch-success': 'You have successfully subscribed to the product stock notifications',
    'cancel-stock-sub': 'Cancel subscribe',
    'stock-sub': 'Inform about availability',
    'search': 'Search',
    'up-to-5': 'Up to 5 months',
    'copy-loc': 'Coordinates is copied',
  },
}

function _tr($tr_code) {
  return LANGUAGES[$('html').attr('lang')][$tr_code];
}

function currentLang() {
  return $('html').attr('lang').substring(0, 2);
}

function currencySign() {
  return $('html').attr('data-currency');
}

function windowOpen(url, width, height) {
  var leftPosition, topPosition;
  //Allow for borders.
  leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
  //Allow for title and status bars.
  topPosition = (window.screen.height / 2) - ((height / 2) + 50);
  //Open the window.
  window.open(url, "Window2",
    "status=no,height=" + height + ",width=" + width + ",resizable=yes,left="
    + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY="
    + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
}

function initSizeSwitch() {
  const $items = $(this).find('.sizes-switch__item');
  $items.on('click', function () {
    if (!$(this).hasClass('sizes-switch__item--stock')) {
      return;
    }

    $items.removeClass('sizes-switch__item--active');
    $(this).addClass('sizes-switch__item--active');
  });
}


function openModal(target) {
  $('#overlay').fadeIn(200, function () {
    $(target).css('display', 'block').animate({opacity: 1}, 200);
  });
  scrollLock();
}

function closeModal(target) {
  $(target).animate({opacity: 0}, 200, function () {
      $(this).css('display', 'none');
      $('#overlay').fadeOut(400);
    }
  );
  scrollUnlock();
}

function initCarousel(elem) {
  $(elem).not('.slick-initialized').slick({
    slidesToShow: 4,
    sliderToScroll: 1,
    dots: false,
    prevArrow: '<button type="button" class="slick_prev"></button>',
    nextArrow: '<button type="button" class="slick_next"></button>',
    rows: 0,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
        }
      }
    ]
  });
}

function isGiftSelected() {
  const $gifts = $('.product-gifts');

  if ($gifts.length) {
    if ($('.product-gifts__item.active').length === 0) {
      console.log('error');
      const $title = $gifts.find('.product-sizes__title');
      $('.gift-error').remove();
      $title.after('<div class="gift-error">' + $title.data('error') + '</div>');
      $('html, body').animate({scrollTop: $gifts.offset().top}, 300);
      return false;
    }
  }
  return true;
}

function formatPriceWithSpace(price) {
  return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}

function showSpinnerOverlay(target) {
  $(target).append('<div class="spinner-overlay"><div class="spinner"></divc></div>');
}

function hideSpinnerOverlay(target) {
  $(target).find('.spinner-overlay').remove();
}

function extractNumberQty(string) {
  return string.split(' ')[0];
}

function updateStringQty(string, number) {
  return string.replace(/\d+/g, number);
}

function subscribeStockWatch(product_id, email, cb) {
  const lang = $('html').data('lang');
  const prefix = lang ? '/' + lang : '';
  const url = prefix + '/products/set-stock-watch';
  const data = {
    product_id: product_id,
    email: email
  }
  $.post(url, data, function (res) {
    closeModal('.modal--subscribe');
    notify(res.message);
    cb(res);
  }).fail(function (err) {
    console.log(err);
  });
}


// обрезать текст отзыва
function addMoreBtnToComments() {
  const block = $('.product-reviews');

  if (block.hasClass('short-comments')) {
    return;
  }
  block.addClass('short-comments');

  $('.product-reviews__comments').each(function () {
    const comment = $(this);
    const moreButton = $('<button class="js-comment-more"></button>');
    if (comment.outerHeight() > 60) {
      comment.after(moreButton)
    }

    moreButton.click(function () {
      comment.toggleClass('height-auto');
    });
  });
}