/* НАЧАЛО
*=========================Поиск по кнопке=======================*/
$('.js-search').on('click', function () {
  search();
});
/* КОНЕЦ
*=========================Поиск по кнопке=======================*/


/* НАЧАЛО
*=========================Поиск по enter=======================*/
// Вешаем класс когда инпут в фокусе,
// что бы по ентеру делать поиск
let $searchInput = $('.js-main-search');

$searchInput.on('focus', function () {
  $(this).addClass('search-on-focus');
});

$searchInput.on('blur', function () {
  $(this).removeClass('search-on-focus');
});

// Поиск по ентеру
document.addEventListener('keydown', function (evt) {
  evt = evt || window.event;
  var isEnter = false;
  var elemTrigger = document.querySelector('.search-on-focus');

  if ("key" in evt) {
    isEnter = (evt.key === "Enter");
  } else {
    isEnter = (evt.keyCode === 13);
  }

  if (isEnter && elemTrigger) {
    search();
  }
});

// вешаем событие закрытия меню на ESC
document.addEventListener('keydown', function (evt) {
  evt = evt || window.evt;
  let isEscape = false;

  if ("key" in evt) {
    isEscape = (evt.key === "Escape" || evt.key === "Esc");
  } else {
    isEscape = (evt.keyCode === 27);
  }

  if (isEscape) {
    $('.main-search').removeClass('is-visible');
  }
});
/* КОНЕЦ
*=========================Поиск по enter=======================*/


/* НАЧАЛО
*============Подгрузка карточек на странице поиска=============*/
// кол-во карточек, которые загружаем изначально
var offsetSearch = 12;

$('.js-more-search-btn').on('click', function () {
  let _this = $(this);

  // контейнер куда вставим карточки
  var searchText = $(this).attr('data-search-text');

  // контейнер куда вставим карточки
  var containerCard = $('.js-more-search-container');

  // подгрузка карточек
  $.ajax({
    url: '/' + currentLang() + '/search-more/get-more-product',
    method: 'post',
    data: {
      'limit': 12,
      'offset': offsetSearch,
      'text': searchText
    },
    success: function (data) {
      // Увеличивае офсет, что бы не загружать те, что уже загружены
      offsetSearch += 12;

      // вставляем новые карточки
      containerCard.append(data);

      // Инициализируем слайдер для карточек
      initProductCardSlider(7);

      // кол-во уже загруженых карточек
      let countCard = $('.product-card-col').length;

      // тут лежит общее кол-во карточек в избранном
      let totalCountCard = $('[data-cards-count]').attr('data-cards-count');

      // удаляем кнопку, если нечего загружать
      if (countCard >= totalCountCard) {
        _this.remove();
      }
    }
  });
});
/* КОНЕЦ
*============Подгрузка карточек на странице поиска=============*/


/* НАЧАЛО
*=========================ВОСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ=======================*/

// Поиск
function search() {
  let inputData = $('.js-search-input').val();
  if (inputData.trim() === '' || inputData.length < 3) {
    return;
  }
  location.href = '/search/' + inputData;
}

/* КОНЕЦ
*=========================ВОСПОМОГАТЕЛЬНЫЕ ФУНКЦИИ=======================*/