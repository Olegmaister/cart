/* НАЧАЛО
* *===========Добавить товар в избранное по клику в карточке товара==========*/
$(document).on('click', '.js-favorite', function () {

  // Выходим если не залогинен, иначе кинет на 404
  let isLogged = document.body.getAttribute('data-login');
  isLogged = +isLogged;
  if (!isLogged) {
    // вызываем событие клика, что бы открыть модалку для регистрации
    document.querySelector('.js-open-modal-login').click();
    return false;
  }

  let $productImg = $(this).closest('.product-card').find('.js-product-card-img-slider .slick-current .product-card__img-link');
  let id = $productImg.attr('data-product-id');

  // Находим фото торавав карточке и меняем класс ему и сердечку
  $productImg.toggleClass('is-favorite-selected');

  // Товар не добавлен - добавляем
  if ($productImg.hasClass('is-favorite-selected')) {
    this.classList.add('is-favorite');

    $.ajax({
      url: '/wishlist/add/' + id,
      method: 'get',
      success: function (data) {
        // Счетчик в хедере
        counterFavorite();
      }
    });
  }
  // Товар уже добавлен - удаляем
  else {
    this.classList.remove('is-favorite');

    $.ajax({
      url: '/wishlist/delete',
      method: 'post',
      data: {
        productsList: [id]
      },
      success: function (data) {
        // Счетчик в хедере
        counterFavorite();

        // очистить на странице wishlist
        let $container = $('.js-load-favorite-container');
        $($container).find('[data-product-id="' + id + '"]').remove();
        const itemsCount = $container.find('.product-card-col').length;
        if (itemsCount === 0) {
          showEmptyMessage();
        }
      }
    });
  }


});
/* КОНЕЦ
* *===========Добавить товар в избранное по клику в карточке товара==========*/


/* НАЧАЛО
* *===========Смена цвета товара==========*/
// Смена цвета товара
// Всем добавленным в избранное товарам добавлен класс для фотографии товара 'is-favorite-selected'
// После смены цвета смотрим на наличие этого класса и красим сердечко
$(document).on('click', '.js-product-card-color', function () {
  var $productImg = $(this).closest('.product-card').find('.js-product-card-img-slider .slick-current .product-card__img-link');
  var $favoriteIcon = $(this).closest('.product-card').find('.js-favorite');

  if ($productImg.hasClass('is-favorite-selected')) {
    $favoriteIcon.addClass('is-favorite');
  } else {
    $favoriteIcon.removeClass('is-favorite');
  }
});
/* КОНЕЦ
* *===========Смена цвета товара==========*/


/* НАЧАЛО
* *===========Добавить товар в избранное по клику на странице товара==========*/
$(document).on('click', '.js-product-favorite', function () {
  // Выходим если не залогинен, иначе кинет на 404
  let isLogged = document.body.getAttribute('data-login');
  isLogged = +isLogged;
  if (!isLogged) {
    // вызываем событие клика, что бы открыть модалку для регистрации
    document.querySelector('.js-open-modal-login').click();
    return false;
  }

  let id = this.getAttribute('data-product-id');
  let textFavoriteBtn;
  let addedFavoriteAll = this.querySelector('.js-favorite-added-all');
  let numberAddedFavoriteAll = addedFavoriteAll.textContent;

  // Делаем проверку по классу, если его нет, то товар не добавлен в избранное
  // Товар не добавлен еще - добавляем в избранное
  if (!this.classList.contains('is-favorite')) {
    this.classList.add('is-favorite');
    textFavoriteBtn = this.querySelector('.product-watches__txt--big');
    textFavoriteBtn.textContent = _tr('fav-added');
    addedFavoriteAll.textContent = +numberAddedFavoriteAll + 1;

    $.ajax({
      url: '/wishlist/add/' + id,
      method: 'get',
      success: function (data) {
        // console.log(data);
        // Счетчик в хедере
        counterFavorite();
      }
    });
  }
  // Товар уже добавлен - удаляем в избранное
  else {
    this.classList.remove('is-favorite');
    textFavoriteBtn = this.querySelector('.product-watches__txt--big');
    textFavoriteBtn.textContent = _tr('fav-add');
    addedFavoriteAll.textContent = +numberAddedFavoriteAll - 1;

    $.ajax({
      url: '/wishlist/delete',
      method: 'post',
      data: {
        productsList: [id]
      },
      success: function (data) {
        // console.log(data);
        // Счетчик в хедере
        counterFavorite();
      }
    });
  }

});
/* КОНЕЦ
* *===========Добавить товар в избранное по клику на странице товара==========*/

function showEmptyMessage() {
  let $block = $('.account-col--right');

  let layout = '<div class="favorite-empty">' +
    '<p class="favorite-empty__title title-h2">Ваш список избранного пуст!</p>' +
    '<p class="favorite-empty__subtitle title-h2">Выбрать товар можно в каталоге товаров:</p>' +
    '<div class="favorite-empty__btn">' +
    '<button class="btn btn--primary btn--primary-red btn--primary-medium">' +
    '<a href="/categories" class="btn__inner title-h4 title--white">Каталог товаров</a>' +
    '</button>' +
    '</div>' +
    '</div>';

  $block.html(layout);
}

/* НАЧАЛО
*=======================Очистить все избранное====================*/
$('#clear-all-favorite').on('click', function () {
  $.ajax({
    url: '/wishlist/delete-all',
    method: 'post',
    success: function (data) {
      // console.log(data);
      showEmptyMessage();

      // Счетчик в хедере
      counterFavorite();
    }
  });
});
/* КОНЕЦ
*=======================Очистить все избранное====================*/


/* НАЧАЛО
*==========Подгрузка карточек в кабинете по кнопке "ЕЩЕ"=========*/
// кол-во карточек, которые загружаем изначально
var offsetFavorite = 6;

$('.js-load-favorite-btn').on('click', function () {
  let _this = $(this);

  // контейнер куда вставим карточки
  var containerCard = $('.js-load-favorite-container');

  // подгрузка карточек
  $.ajax({
    url: '/account/wishlist',
    method: 'post',
    data: {
      'limit': 6,
      'offset': offsetFavorite
    },
    success: function (data) {
      // Увеличивае офсет, что бы не загружать те, что уже загружены
      offsetFavorite += 6;

      // вставляем новые карточки
      containerCard.append(data);

      // Инициализируем слайдер для карточек
      // initProductCardSlider(7);

      // кол-во уже загруженых карточек
      let countCard = $('.product-card-col').length;

      // тут лежит общее кол-во карточек в избранном
      let totalCountCard = $('[data-total-count]').attr('data-total-count');

      // удаляем кнопку, если нечего загружать
      if (countCard >= totalCountCard) {
        _this.remove();
      }
    }
  });
});
/* КОНЕЦ
*==========Подгрузка карточек в кабинете по кнопке "ЕЩЕ"=========*/


/* НАЧАЛО
*=======================Очистить выборочно избранное====================*/
let deleteCheckedFavorites = document.querySelector('.js-delete-check-favorites');

if (deleteCheckedFavorites) {
  deleteCheckedFavorites.addEventListener('click', function () {
    let checkInput = document.querySelectorAll('.js-check-favorite:checked');
    // Количество карточке, которые подгружены на данный момент
    let cards = document.querySelectorAll('.product-card-col');
    console.log(cards.length);
    // Для хранения массива с id товаров
    let id = [];

    // Количество удаленных карточек за раз
    let countDeletedCards = 0;

    for (let i = 0; i < checkInput.length; i++) {
      let card = checkInput[i].closest('.product-card-col');
      // Находим все выбранные товары
      let fav = card.querySelectorAll('.is-favorite-selected');

      // Если в карточке добавлено в избранное несколько товаров,
      // то надо обойти все
      if (fav.length) {
        for (let i = 0; i < fav.length; i++) {
          id.push(fav[i].getAttribute('data-product-id'));
        }
      }

      countDeletedCards += 1;
    }

    // Удаление карточек из БД
    $.ajax({
      url: '/wishlist/delete',
      method: 'post',
      data: {
        productsList: id
      },
      success: function (data) {
        // console.log(data);

        // тут лежит общее кол-во карточек в избранном
        let $elemWithCounter = $('[data-total-count]');
        let totalCountCard = $elemWithCounter.attr('data-total-count');

        // Изменяем общее количество, что бы была синхронизация с загрузкой
        $elemWithCounter.attr('data-total-count', +totalCountCard - countDeletedCards);

        // Кнопка Подгрузить еще
        let loadFavoriteBtn = $('.js-load-favorite-btn');

        // контейнер куда вставим карточки
        var containerCard = $('.js-load-favorite-container');

        // подгрузка карточек
        $.ajax({
          url: '/account/wishlist',
          method: 'post',
          data: {
            'limit': cards.length,
            'offset': 0
          },
          success: function (data) {
            // удаляем карточку из html
            let length = cards.length;


            // вставляем новые карточки
            containerCard.prepend(data);

            for (let i = 0; i < cards.length; i++) {
              cards[i].remove();
            }

            // Инициализируем слайдер для карточек
            initProductCardSlider(7);

            // кол-во уже загруженых карточек
            let countCard = $('.product-card-col').length;

            // тут лежит общее кол-во карточек в избранном
            let totalCountCard = $('[data-total-count]').attr('data-total-count');

            // удаляем кнопку, если нечего загружать
            if (countCard >= totalCountCard) {
              loadFavoriteBtn.remove();
            }

            if (!countCard) {
              let $block = $('.account-col--right');

              let layout = '<div class="favorite-empty">' +
                '<p class="favorite-empty__title title-h2">Ваш список избранного пуст!</p>' +
                '<p class="favorite-empty__subtitle title-h2">Выбрать товар можно:</p>' +
                '<div class="favorite-empty__btn">' +
                '<button class="btn btn--primary btn--primary-red btn--primary-medium">' +
                '<a href="/categories" class="btn__inner title-h4 title--white">Каталог товаров</a>' +
                '</button>' +
                '</div>' +
                '</div>';

              $block.html(layout);
            }

            // Изменяем данные счетчика в хедере
            counterFavorite();
          }
        });
      }
    });
  })
}
/* КОНЕЦ
*=======================Очистить выборочно избранное====================*/


/* НАЧАЛО
*=========================ВОСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ=======================*/

// Изменять счетчик в хедере
function counterFavorite() {
  $.ajax({
    url: '/wishlist/count',
    method: 'get',
    success: function (data) {
      // console.log(data);

      // кол-во добавленных товаров в избранное
      let counter = data['result'];

      // пока хедеров аж 3 шт, то пишу All
      let headerIcon = document.querySelectorAll('.js-favorite-counter');


      // 0 не надо писать в рахметке счетчика, по этому выходим из функции
      if (counter === 0) {
        for (let i = 0; i < headerIcon.length; i++) {
          headerIcon[i].textContent = '';
        }
        return false;
      }
      // Вставляем значение счетчика
      else {
        for (let i = 0; i < headerIcon.length; i++) {
          headerIcon[i].textContent = counter;
        }
      }
    }
  });
}

/* КОНЕЦ
*=========================ВОСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ=======================*/