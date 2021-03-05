var overlay = $('#overlay');
var overlay_search = $('#overlay-search');

$('.header-cat__but').click(function () {
  if ($(this).next().css('display') == 'block') {
    $(this).next().slideUp("fast", function () {
    });
    $(this).removeClass('b_arrow_up');
    $(this).parent().parent().nextAll().find('.header-cat__nav').prev().removeClass('b_arrow_up');
  } else {
    $(this).next().slideDown("fast", function () {
    });
    $(this).addClass('b_arrow_up');

    $(this).parent().parent().prevAll().find('.header-cat__nav').slideUp("fast", function () {
    }).prev().removeClass('b_arrow_up');
    $(this).parent().parent().nextAll().find('.header-cat__nav').slideUp("fast", function () {
    }).prev().removeClass('b_arrow_up');
  }
});

//ACCORDION
$('.js-toggle-slide').click(function () {
  if ($(this).next().css('display') == 'block') {
    $(this).next().slideUp("fast", function () {
    });
    $(this).removeClass('b_arrow_up');
  } else {
    $(this).next().slideDown("fast", function () {
    });
    $(this).parent().prevAll().find('.js-toggle-cont').slideUp("fast", function () {
    });
    $(this).parent().nextAll().find('.js-toggle-cont').slideUp("fast", function () {
    });
    $(this).addClass('b_arrow_up');
    $(this).parent().nextAll().find('.js-toggle-slide').removeClass('b_arrow_up');
    $(this).parent().prevAll().find('.js-toggle-slide').removeClass('b_arrow_up');
  }
});

//OTHER TOGGLE
$('.js-toggle-other-slide').click(function () {
  if ($(this).next().css('display') == 'block') {
    $(this).next().slideUp("fast", function () {
    });
    $(this).removeClass('toggle');
  } else {
    $(this).next().slideDown("fast", function () {
    });
    $(this).addClass('toggle');
  }
});
$('.cart-promo__close').click(function () {
  if ($(this).parent().next().css('display') == 'block') {
    $(this).parent().next().slideDown("fast", function () {
    });
    $(this).parent().addClass('toggle');
  } else {
    $(this).parent().next().slideUp("fast", function () {
    });
    $(this).parent().removeClass('toggle');
  }
});

// изменять высоту корзины на мобильных устройствах с выдвигающимся url bar
$(window).on('resize', function () {
  $('.modal--cart').outerHeight(window.innerHeight);
});

//menu catalog - show, hidden
$('.header-cat__show').click(function () {
  $(this).css('display', 'none');
  $('.header-cat__show._hidden').css('display', 'block');
  $(this).prev().toggleClass('_show');
  $(this).parent().parent().parent().toggleClass('_show');
});
$('.header-cat__show._hidden').click(function () {
  $('.header-cat__show').css('display', 'block');
  $(this).parent().parent().toggleClass('_show');
  $(this).parent().parent().parent().parent().parent().toggleClass('_show');
});

//BURGERS BUTTON MOBILE
$('.js-toggle-show.js-toggle-show_cat').click(function () {
  $(this).closest('.header-burgers').parent().next().toggleClass('hidden-content_show');
  $(this).toggleClass('b_arrow_up');

  $('.header-burgers').find('.search-form_mob').removeClass('hidden-content_show');
  overlay_search.fadeOut(400);
  $('.header-burger-content').removeClass('hidden-content_show');
  $('.cart-m-popup').removeClass('_show');
  $('.js-toggle-show.js-toggle-show_menu').removeClass('close');
});

//menu
$('.js-toggle-show.js-toggle-show_menu').click(function () {
  $(this).next().toggleClass('hidden-content_show');
  $(this).toggleClass('close');
  $('body').toggleClass('no-scroll')

  $('.header-burgers').find('.search-form_mob').removeClass('hidden-content_show');
  overlay_search.fadeOut(400);
  $('.header-cat-mobile').removeClass('hidden-content_show');
  $('.cart-m-popup').removeClass('_show');
  $('.header-burger-content').outerHeight(window.innerHeight - 106);
});

// header dropdowns
$('.dd-1__current').on('click', function () {
  if (!$(this).parent().hasClass('active')) {
    $('.dd-1').removeClass('active');
    $(this).parent().addClass('active');
  } else {
    $('.dd-1').removeClass('active');
  }
});

$('body').click(function (e) {

  if ($(e.target).closest('.dd-1').length === 0) {
    $('.dd-1').removeClass('active');
  }
  if ($(e.target).closest('.header-burgers-col.header-burgers-col--right').length === 0) {
    $(this).removeClass('no-scroll');
  }
})
/****** Selects */
$('.s_select_box_value').click(function () {
  $('.cart-m-popup').removeClass('_show');
  $(this).parent().toggleClass('_show b_arrow_up');
  $(this).parent().parent().toggleClass('_overflow_hidden');

  $(this).parent().parent().nextAll().removeClass('_overflow_hidden').find('.switch ').removeClass('_show b_arrow_up');
  $(this).parent().parent().prevAll().removeClass('_overflow_hidden').find('.switch ').removeClass('_show b_arrow_up');

  $('.header-row_bot').removeClass('search-form_show');
});
$('li').click(function () {
  $(this).nextAll().removeClass('selected');
  $(this).prevAll().removeClass('selected');
  $(this).addClass('selected');
  $(this).closest(".s_select_box").find('.s_select_box_value span').text($(this).text()).parent().parent().removeClass('_show b_arrow_up');
  $(this).parent().parent().parent().parent().removeClass('_overflow_hidden');
});

//SEARCH - HIDDEN/SHOW
$('.header-ordering-col_search').click(function () {
  $('.header-row_bot').addClass('search-form_show');

  $('.header-ordering-col_call').css('display', 'none');

  $('.cart-m-popup').removeClass('_show');
  $('.switch').removeClass('_show b_arrow_up')
});

$('.search-form__close').click(function () {
  $('.header-row_bot').removeClass('search-form_show');
  $('.header-ordering-col_call').css('display', 'block');
});

//COLOR CHECK
$('.product-card-slider-wrap__item').click(function () {
  $(this).addClass('_active');
  $(this).prevAll().removeClass('_active');
  $(this).nextAll().removeClass('_active');
});
$('.product-colors__item').click(function () {
  $(this).addClass('_active');
  $(this).prevAll().removeClass('_active');
  $(this).nextAll().removeClass('_active');
});


//SIZES CHECK
// $(document).on('click', '.sizes-switch__item', function () {
//   if (!$(this).hasClass('sizes-switch__item--stock')) {
//     return;
//   }
//
//   $('.sizes-switch__item').removeClass('sizes-switch__item--active');
//   $(this).addClass('sizes-switch__item--active');
// });

$('.sizes-switch').each(initSizeSwitch);


//SIZES COLORS
$('.switch-color__item').click(function () {
  $(this).addClass('switch-color__item--active');
  $(this).prevAll().removeClass('switch-color__item--active');
  $(this).nextAll().removeClass('switch-color__item--active');
});

//toggle view products card
$(document).on('click', '.js-toggle-view', function () {
  $(this).nextAll().removeClass('views-buttons-but--active');
  $(this).prevAll().removeClass('views-buttons-but--active');
  $(this).toggleClass('views-buttons-but--active');
});

$(document).on('click', '.views-buttons-but--view-1', function () {
  $('.js-toggle-views').removeClass('product-card-wrap--view-2');
  $('.js-toggle-views').removeClass('product-card-wrap--view-3');
  var sliderImg2 = $('.js-product-card-img-slider.slick-initialized');
  var sliderColor2 = $('.js-product-card-color-slider.slick-initialized');
  sliderImg2.slick('unslick');
  sliderColor2.slick('unslick');

  $('.page-content-inner').find('.product-card__body').each(function () {
    initProductCardSlider($(this), 7);
  });

  $(document).on('click', '.js-product-card-color', function () {
    var actIndex = +($(this).attr('data-slick-index'));
    var slider = $(this).closest('.js-product-card-color-slider').prev('.js-product-card-img-slider');
    slider[0].slick.slickGoTo(parseInt(actIndex));
  });
});

$(document).on('click', '.views-buttons-but--view-2', function () {
  $('.js-toggle-views').addClass('product-card-wrap--view-2');
  $('.js-toggle-views').removeClass('product-card-wrap--view-3');
  var sliderImg2 = $('.js-product-card-img-slider.slick-initialized');
  var sliderColor2 = $('.js-product-card-color-slider.slick-initialized');
  sliderImg2.slick('unslick');
  sliderColor2.slick('unslick');

  $('.js-toggle-views').addClass('product-card-wrap--view-2');
  $('.js-toggle-views').removeClass

  $('.page-content-inner').find('.product-card__body').each(function () {
    initProductCardSlider($(this), 4);
  });

  $(document).on('click', '.js-product-card-color', function () {
    var actIndex = +($(this).attr('data-slick-index'));
    var slider = $(this).closest('.js-product-card-color-slider').prev('.js-product-card-img-slider');
    slider[0].slick.slickGoTo(parseInt(actIndex));
  });
});

$(document).on('click', '.views-buttons-but--view-3', function () {

  $('.js-toggle-views').addClass('product-card-wrap--view-3');
  $('.js-toggle-views').removeClass('product-card-wrap--view-2');
  var sliderImg2 = $('.js-product-card-img-slider.slick-initialized');
  var sliderColor2 = $('.js-product-card-color-slider.slick-initialized');
  sliderImg2.slick('unslick');
  sliderColor2.slick('unslick');
  $('.js-toggle-views').addClass('product-card-wrap--view-3');
  $('.js-toggle-views').removeClass

  $('.page-content-inner').find('.product-card__body').each(function () {
    initProductCardSlider($(this), 7);
  });

  $(document).on('click', '.js-product-card-color', function () {
    var actIndex = +($(this).attr('data-slick-index'));
    var slider = $(this).closest('.js-product-card-color-slider').prev('.js-product-card-img-slider');
    slider[0].slick.slickGoTo(parseInt(actIndex));
  });

  //Добавляем класс если в карточке товара больше двух ЛЕЙБЛОВ
  if ($('.product-card-labels').hasClass('product-card-labels--3')) {
    $('.product-card').addClass('product-card-more-labels--3');
  }

});

//header cart popup - show, hidden
$(document).on('click', '.header-ordering__icon.header-ordering__icon_cart', function () {
  if ($(window).width() < 992) {
    $('#overlay').fadeIn(200,
      function () {
        $('.modal--cart')
          .outerHeight(window.innerHeight)
          .css('display', 'flex')
          .animate({opacity: 1}, 200);
        scrollLock();
      }
    );
  } else {
    $(this).next().toggleClass('_show');
  }
  $(this).toggleClass('active');
  $('.header-options-col').removeClass('_overflow_hidden');
  $('.switch ').removeClass('_show b_arrow_up');
  $('.header-row_bot').removeClass('search-form_show');
  $('.header-comp-list').removeClass('_show');
  $('.js-open-comp-list').removeClass('active');
});

//popup compare in header
$(document).on('click', '.js-open-comp-list', function () {

  $(this).next().toggleClass('_show');
  $(this).toggleClass('active');
  $('.header-ordering__icon_cart').removeClass('active');
  $('.cart-m-popup').removeClass('_show');
});

//DEFAULT TOGGLE - HEIGHT
$(document).on('click', '.js-toggle-h-prev', function () {
  $(this).toggleClass('sidebar-item__arrow--arrow-up');
  $(this).prev().toggleClass('toggle-prev-h-show');
});
//DEFAULT TOGGLE - VISIBLE
$(document).on('click', '.js-toggle-v-next', function (e) {
  if ($(e.target).closest(".check-color__label,.check-color__input").length == 0) {
    $(this).next().toggleClass('toggle-prev-v-show');
  }
});

/****** Изминение количества в инпуте */
jQuery('.js-minus').click(function () {
  var jQueryinput = jQuery(this).parent().find('input');
  var count = parseInt(jQueryinput.val()) - 1;
  count = count < 1 ? 1 : count;
  jQueryinput.val(count);
  jQueryinput.change();
  return false;
});
jQuery('.js-plus').click(function () {
  var jQueryinput = jQuery(this).parent().find('input');
  jQueryinput.val(parseInt(jQueryinput.val()) + 1);
  jQueryinput.change();
  return false;
});

//CLICK body
$('body').click(function (e) {
  if ($(e.target).closest(".h-icon-button,.check-color-popup,.js-toggle-v-next,.s_select_box_value,.header-ordering__icon_cart,.cart-m-popup,.header-ordering__icon_search,.search-form,.js-toggle-show,.hidden-content_show,.js-toggle-sidebar,.sidebar-mob-content,.check-txt").length == 0) {
    $('.header-ordering__icon_cart, .h-icon-button__icon').removeClass('active');
    $('.switch').removeClass('_show b_arrow_up');
    $('.cart-m-popup').removeClass('_show');
    $('.header-options-col').removeClass('_overflow_hidden');
    $('.header-row_bot').removeClass('search-form_show');
    $('.hidden-content_hidden').removeClass('hidden-content_show');
    $('.toggle-prev-v-show').removeClass('toggle-prev-v-show');
    $('.js-toggle-show.js-toggle-show_menu').removeClass('close');
    $('.header-ordering-col_call').css('display', 'block');
    $('.header-comp-list').removeClass('_show');
  }
});

//Скрывает и открывет кнопке показать больше, если контента больше
//страница продукта, высота описания товара
var heightSizeProduct = document.getElementById('js-product-size');
var heightDescProduct = document.getElementById('js-height');

//Высота содержимого блоков в сайтбаре на стр категорий
var heightSidebarColors = document.getElementById('js-height-colors');
var heightSidebarManufactured = document.getElementById('js-height-manufactured');
var heightSidebarAtributes = document.getElementById('js-height-atributes');

$(document).ready(function () {

  /******* Блоки в сайтбаре на стр категорий */

  //Фильтр цветов
  if (heightSidebarColors) {
    var heightBlockColor = heightSidebarColors.clientHeight;

    if (heightBlockColor < 195) {
      $('.sidebar-item__arrow--colors').css('display', 'none');
    } else {
      $('.sidebar-item__arrow--colors').css('display', 'block');
    }
    if (heightBlockColor < 2) {
      $('.sidebar-item--colors').css('display', 'none');
    }
  }

  //Фильтр производителей
  if (heightSidebarManufactured) {
    var heightBlockManufactured = heightSidebarManufactured.clientHeight;

    if (heightBlockManufactured < 184) {
      $('.filter-brands_checkbox').removeClass('sidebar-item-content--scroll');
    }
    if (heightBlockManufactured < 2) {
      $('.sidebar-item--manufactured').css('display', 'none');
    }
  }

  //Фильтр атрибутов
  if (heightSidebarAtributes) {
    var heightBlockAtributes = heightSidebarAtributes.clientHeight;

    if (heightBlockAtributes < 184) {
      $('.sidebar-item__arrow--atributes').css('display', 'none');
    } else {
      $('.sidebar-item__arrow--atributes').css('display', 'block');
    }
    if (heightBlockAtributes < 2) {
      $('.sidebar-item--atributes').css('display', 'none');
    }
  }

});


// show main search in header
function showMainSearch() {
  var $mainSearch = $('.main-search');
  var $input = $mainSearch.find('.main-search__input');
  var $window = $(window);

  $('.js-open-main-search').on('click', function () {
    $('.main-search').addClass('is-visible');
    $input.focus();
    if ($window.width() <= 992) {
      $('#overlay').fadeIn(150);
      scrollLock();
    }
  });

  $('.js-close-main-search').on('click', function () {
    hide()
  });

  $('body').click(function (e) {
    if ($(e.target).closest('.nav-with-search, .header-burgers-col--middle, .main-search').length === 0) {
      hide()
    }
  });

  function hide() {
    if ($mainSearch.hasClass('is-visible')) {
      $mainSearch.removeClass('is-visible');
      $input.val('');
      if ($window.width() <= 992) {
        $('#overlay').fadeOut(150);
        scrollUnlock();
      }
    }
  }

  function checkSize() {
    if ($window.width() <= 992) {
      $mainSearch.prependTo('body');
    } else {
      $mainSearch.prependTo('.nav-with-search');
    }
  }

  checkSize();
}

showMainSearch();

// фильтр городов и отображение на карте на странице магазины
function showMap() {
  let markers = [];
  let $cityItems = $('.desc-accord-item');

  function expandStoreInfo(id) {
    collapseAllStores();
    const parent = $cityItems.filter('[data-id="' + id + '"]');
    parent.find('.js-toggle-slide').addClass('b_arrow_up');
    parent.find('.js-toggle-cont').slideDown();
  }

  function collapseAllStores() {
    $cityItems.find('.js-toggle-slide').removeClass('b_arrow_up');
    $cityItems.find('.js-toggle-cont').slideUp();
  }

  function clearMarkers() {
    if (markers.length > 0) {
      for (let i = 0; i < markers.length; i++) {
        markers[i].marker.setMap(null);
      }
      markers = [];
    }
  }

  function addMarker(location, showInfo) {
    const lat = parseFloat(location.coords.lat);
    const lng = parseFloat(location.coords.lng);
    const marker = new google.maps.Marker({
      position: {lat: lat, lng: lng},
      markerId: location.id,
      map: shopsMap
    });
    const info = new google.maps.InfoWindow({
      content: '<div class="p-2"><h1 class="text-danger mb-2">' + location.name + '</h1><h3>' + location.address + '</h3></div>'
    });
    if (showInfo) {
      info.open(shopsMap, marker);
    }
    marker.addListener('click', function () {
      for (let i = 0; i < markers.length; i++) {
        markers[i].info.close(shopsMap, markers[i].marker);
      }

      expandStoreInfo(this.markerId);
      info.open(shopsMap, this);
    });
    markers.push({
      marker: marker,
      info: info,
      id: location.id
    });
  }

  function zoomBounds() {
    const bounds = new google.maps.LatLngBounds();
    for (let i = 0; i < markers.length; i++) {
      bounds.extend(markers[i].marker.position);
    }
    shopsMap.fitBounds(bounds);
  }

  function zoomMarker(center, zoom = 16) {
    shopsMap.setCenter(center);
    shopsMap.setZoom(zoom);
  }

  // отобразить магазин по нажатию на карте
  $cityItems.on('click', function () {
    const id = $(this).data('id');
    const center = {
      lat: parseFloat($(this).data('lat')),
      lng: parseFloat($(this).data('lng'))
    }

    for (let i = 0; i < markers.length; i++) {
      markers[i].info.close(shopsMap, markers[i].marker);
    }

    const marker = markers.find(function (item) {
      return item.id === id;
    });
    marker.info.open(shopsMap, marker.marker);
    zoomMarker(center);
  });

// центер карты берем из первого елемента
  let center = {
    lat: parseFloat($cityItems.first().data('lat')),
    lng: parseFloat($cityItems.first().data('lng')),
  }

// создаем карту
  let shopsMap = new google.maps.Map(document.getElementById('p-shops-map'), {
    center: center,
    zoom: 6
  });

  shopsMap.addListener('click', function () {
    for (let i = 0; i < markers.length; i++) {
      markers[i].info.close(shopsMap, markers[i].marker);
    }
    collapseAllStores();
  });

// отобразить все маркеры
  function showAllMarkers() {
    $cityItems.each(function (i, el) {
      addMarker({
        coords: {lat: $(el).data('lat'), lng: $(el).data('lng')},
        address: $(el).data('address'),
        name: $(el).data('name'),
        id: $(el).data('id'),
      });
    });
  }

  showAllMarkers();

// отобразить города по фильтру
  $(document).on('click', '.js-city-select .option', function () {
    let value = $(this).data('value');
    const $visibleItems = $cityItems.filter('[title="' + value + '"]');

    clearMarkers();
    // отобразить все магазины
    if (value === 'all') {
      showAllMarkers();
      zoomBounds();

      $cityItems.show();
      return;
    }

    // отобразить групу магазинов
    $visibleItems.each(function (i, el) {
      const pos = {
        lat: parseFloat($(el).data('lat')),
        lng: parseFloat($(el).data('lng'))
      };
      addMarker({
        coords: pos,
        address: $(el).data('address'),
        name: $(el).data('name'),
        id: $(el).data('id')
      });
      if ($visibleItems.length > 1) {
        zoomBounds();
      } else {
        zoomMarker(pos);
      }
    });

    $cityItems.hide();
    $visibleItems.show();
  });

// раскрыть магазин если в url есть параметр
  let storeId = location.hash.substr(1);
  if (storeId) {
    let $store = $('.desc-accord-item[data-id="' + storeId + '"]');
    let id = $store.data('id');
    $store.find('header').addClass('b_arrow_up');
    $store.find('article').slideDown();
    const pos = {
      lat: parseFloat($store.data('lat')),
      lng: parseFloat($store.data('lng'))
    };
    const marker = markers.find(function (item) {
      return item.id === id;
    });
    marker.info.open(shopsMap, marker.marker);
    zoomMarker(pos);
  }
}

// если на странице есть карта то вызываем функцию
if ($('#p-shops-map').length !== 0) {
  showMap();
}

// blog nav slider
$('.js-blog-nav').on('afterChange', function (e, slick) {
}).slick({
  rows: 0,
  slidesToShow: 8,
  draggable: false,
  variableWidth: true,
  infinite: false,
  responsive: [
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 6,
      }
    },
  ]
});

// скопировать геолокацию
$('.js-copy-location').on('click', function (e) {
  const copyLocation = $(this).closest('.desc-accord-cont').find('.p-shop-location input');
  copyLocation[0].select();
  document.execCommand("copy");
  copyLocation.blur();
  notify(_tr('copy-loc'));
});


$('.select-1').select2({
  minimumResultsForSearch: Infinity
});

$('.select-popup').select2({
  minimumResultsForSearch: Infinity,
  dropdownParent: $('.popup-shop'),
});

// select2 для полей "ЛИЧНЫЙ КАБИНЕТ: ОБЩИЕ ДАННЫЕ"
$('.field-profileform-country select, .field-profileform-city select').select2();
$('.modal-select.simple-filter')
  .on('select2:open', function () {
    $('.select2-search__field').attr('placeholder', _tr('search'));
  })
  .select2({
    dropdownParent: $('.modal--quik-buy'),
    language: {
      noResults: function () {
        return 'Результатов не найдено';
      },
    },
    escapeMarkup: function (markup) {
      return markup;
    },
  });
// select2
$('.modal-select:not(.simple-filter)')
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
    dropdownParent: $('.modal--quik-buy'),
    language: {
      noResults: function () {
        return 'Результатов не найдено';
      },
    },
    escapeMarkup: function (markup) {
      return markup;
    },
  });

// обрезать весь блок отзывов и показать по нажатию
$('.js-show-more-reviews').on('click', function () {
  $('.container-reviews').removeClass('reviews-short');
  $(this).remove();
});

// бегущая строка по ховеру
$('.journal-card__label').hover(
  function () {
    const boxWidth = $(this).width();
    const $text = $(this).find('span');
    const textWidth = $text.width();
    const diff = textWidth - boxWidth;

    if (diff > 5) {
      $text.css('transform', 'translateX(-' + diff + 'px)');
    }
  },
  function () {
    const $text = $(this).find('span');
    $text.css('transform', 'translateX(0)');
  }
);

// slick карусель: тип 1. Можно использовать где угодно на всю ширину контейнера сайта
$('.carousel-1').slick({
  slidesToShow: 4,
  sliderToScroll: 1,
  // autoplay: 4000,
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

$('.carousel-1b').slick({
  slidesToShow: 3,
  sliderToScroll: 1,
  autoplay: 4000,
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

$('.carousel-1c:not(.unslick)').slick({
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


// отображение промо баннера
function startPromoBanners() {

  $('.js-popup-banner').each(function () {
    const minutes = parseInt($(this).data('repeat-minutes')) || 5;
    const cookieExpires = new Date(new Date().getTime() + minutes * 60 * 1000);
    const $close = $(this).find('.js-close-banner');
    const $popup = $(this);
    const $banners = $(this).find('.promo-banner');
    const bannersLength = $banners.length - 1;
    let index = 0;
    const duration = parseInt($(this).data('duration')) * 1000;
    const timeout = parseInt($(this).data('timeout')) * 1000 || 3000;
    let interval;

    if (duration && $banners.length > 1) {
      $banners.append('<div class="banner-indicator" style="animation-duration: ' + duration + 'ms"></div>');
    }

    setTimeout(function () {
      $popup.show();
      $banners.eq(0).css('display', 'flex');
      if (duration && $banners.length > 1) {
        interval = setInterval(function () {
          index < bannersLength ? index++ : index = 0;
          $banners.hide();
          $banners.eq(index).css('display', 'flex').hide().fadeIn();
        }, duration);
      }
    }, timeout);

    // закрыть промо баннер

    $close.on('click', function () {
      $popup.remove();
      clearInterval(interval);
      $.cookie('promo-banner', 'hidden', {expires: cookieExpires});
    });

  });
}

if (!$.cookie('promo-banner')) {
  startPromoBanners();
}


// фильтр магазинов в попапе резервирования
$('.js-reserve-filter').on('change', function () {
  const city = $(this).val();
  console.log(city)
  const $stores = $('.popup-shop-table').find('.reserve-store');
  $stores.hide();
  $stores.filter('[data-city="' + city + '"]').show();
});

// открыть корзину для редактирования на странице заказов
$(document).on('click', '.js-edit-cart', function (e) {
  e.preventDefault();

  $('#overlay').fadeIn(200,
    function () {
      const $proceedShopping = $('.js-proceed-shopping');
      $('.modal--cart')
        .outerHeight(window.innerHeight)
        .css('display', 'flex')
        .animate({opacity: 1}, 200);
      scrollLock();
      // скрыть кнопку оформить заказ
      $('.proceed-order').hide();
      // изменить текст кнопки
      $proceedShopping.text($proceedShopping.data('alt'));
      // повесить класс для проверки
      $('body').addClass('active-edit-cart');
    }
  );

});


// загружать по ховеру картинку в главном меню
$('.header-cat-menu__item_sub').on('mouseenter', function () {
  const img = $(this).find('.js-cat-menu-img-src');
  const src = img.data('lazy');
  if (img.attr('src')) {
    return;
  }
  img.attr('src', src);
  img.removeAttr('data-lazy');
});


$('.slider-2').slick({
  dots: false,
  prevArrow: '<button type="button" class="slick_prev"></button>',
  nextArrow: '<button type="button" class="slick_next"></button>',
  rows: 0,
});

$('.slider-3').slick({
  dots: false,
  autoplay: 4000,
  prevArrow: '<button type="button" class="slick_prev"></button>',
  nextArrow: '<button type="button" class="slick_next"></button>',
  rows: 0,
});

// init magnific gallery
$('.js-gallery').each(function () {
  $(this).find('a').magnificPopup({
    type: 'image',
    removalDelay: 300,
    mainClass: 'mfp-zoom-in',
    gallery: {
      enabled: true,
      tCounter: ''
    }
  });
});


// show more reserved items on page /account/reserve
$('.js-show-more-reserve').on('click', function () {
  $('.account-reserve-items').toggleClass('short');
  const altText = $(this).data('alt');
  const text = $(this).text();
  $(this).text(altText);
  $(this).data('alt', text);
});

// show city input on page /account/account
$('#profileform-countryid').on('change', function () {
  if ($(this).val() !== '804') {
    $('.js-account-city-ukraine').hide();
    $('.js-account-city-others').show();
  } else {
    $('.js-account-city-ukraine').show();
    $('.js-account-city-others').hide();
  }
}).trigger('change');

// выбор подарка и его размера в карточке товара
$(document).on('click', '.product-gifts__item', function (e) {
  e.preventDefault();
  const sizes = $(this).data('sizes');
  const product_id = $(this).data('id');
  const $oldButton = $('.js-product-add-cart-main');
  const $sizesSwitch = modalSize.find('.sizes-switch');

  // change button
  $oldButton.after('<button class="btn btn--trans btn--lx js-confirm-gift-size"><span class="btn__inner">Выбрать</span></button>');
  $oldButton.remove();

  // show sizes
  $sizesSwitch.empty();
  $.each(sizes, function (k, v) {
    let classString = 'sizes-switch__item sizes-switch__item--stock';
    if (k === 0) {
      classString += ' sizes-switch__item--active';
    }
    const $item = $('<div data-product-id="' + product_id + '" data-option-id="' + v.option_id + '" class="' + classString + '">' + v.name + '</div>');
    $sizesSwitch.append($item);
  });
  $sizesSwitch.each(initSizeSwitch);

  overlay.fadeIn(400,
    function () {
      $(modalSize)
        .css('display', 'flex')
        .animate({opacity: 1}, 200);
    });
  scrollLock();
});

$(document).on('click', '.js-confirm-gift-size', function () {

  const $selected = modalSize.find('.sizes-switch__item--active');

  if ($selected.length > 0) {
    const $addToCartButton = $('.js-product-add-cart');
    const product_id = $selected.data('product-id');
    $addToCartButton.attr('data-gift-id', product_id);
    $addToCartButton.attr('data-gift-option-id', $selected.data('option-id'));
    $addToCartButton.attr('data-gift-option-name', $selected.text());

    // fill input values for fast buy
    $('#fastform-presentid').val(product_id);
    $('#fastform-presentoptionid').val($selected.data('option-id'));
    $('#fastform-presentoptionname').val($selected.text());

    // highlight selected gift
    $('.product-gifts__item').removeClass('active');
    $('[data-id="' + product_id + '"]').addClass('active');

    // remove validation error
    $('.gift-error').remove();

    // and close popup
    modalSize
      .animate({opacity: 0}, 200,
        function () {
          $(this).css('display', 'none');
          overlay.fadeOut(400);
        }
      );
    scrollUnlock()
  }
});

// autocomplete form main search
function searchAutocomplete() {
  let debounce = null;
  const $input = $('.main-search__input');
  const $container = $('.search-autocomplete');

  $input.on('input focus', function () {
    const text = $(this).val().toLowerCase();
    if (text.length > 2) {
      clearTimeout(debounce);
      debounce = setTimeout(function () {
        $.get('/' + currentLang() + '/search-ajax', {text: text}, function (data) {
          let html = '';
          if (data.length > 0) {
            $.each(data, function (k, v) {
              const old_price = v.price_old !== '0' ? '<span class="price-2 line-through"><small>' + currencySign() + '</small> ' + v.price_old + '</span>' : '';
              const title = v.name.toLowerCase().replace(text, '<span class="text-red">' + text + '</span>');
              html += '<div class="row no-gutters"><a class="stretched-link" href="' + v.url + '"></a><div class="col-auto">' +
                '<img src="' + v.image + '" alt="' + v.name + '"></div>' +
                '<div class="col"><div>' + title + '</div><div>' +
                '<span class="price-1 mr-2"><small>' + v.sign + '</small> ' + v.price + '</span>' +
                old_price + '</div></div></div>';
            });
            $container.show();
          }
          $container.html(html);
        });
      }, 200);
    } else {
      $container.hide();
    }
  });
}

searchAutocomplete();

// подписать пользователя на уведомления о наличии товара
$(document).on('click', '.js-open-stock-subscribe', function () {
  const email = $(this).data('email');
  const $button = $(this);
  const $currentItem = $(this).closest('.product-card').find('.slick-slide.slick-current .product-card__img-link');
  const product_id = $currentItem.data('product-id') || $(this).data('product_id');

  const onSuccess = function (res) {
    const btnInner = $button.find('span.btn__inner');
    if (res.subscription) {
      $button.addClass('active');
      $currentItem.attr('data-stock-subscribe', 1);
      if (btnInner.length) {
        btnInner.text(_tr('cancel-stock-sub'));
      }
    } else {
      $button.removeClass('active');
      $currentItem.attr('data-stock-subscribe', 0);
      if (btnInner.length) {
        btnInner.text(_tr('stock-sub'));
      }
    }
  };

  if (IS_LOGGED && email) {
    subscribeStockWatch(product_id, email, onSuccess);
    return;
  }

  openModal('.modal--subscribe');

  $('#form-stock-watch').on('submit', function (e) {
    e.preventDefault();
    const email = $(this).find('input[name="email"]').val();
    subscribeStockWatch(product_id, email, onSuccess);
  });
});