//TABS
function tabs_initialization() {
  $('ul.s_tabs_list').each(function () {
    $(this).find('li').each(function (i) {

      $(this).on("click ", function () {
        var that = $(this);
        tabsInit(that);
        addMoreBtnToComments();
      });

      $(this).on("keydown", function (e) {
        if (e.keyCode === 13) {
          var that = $(this);
          tabsInit(that);
        }
      });

      function tabsInit(thisElem) {
        thisElem.addClass('active').siblings().removeClass('active')
          .closest('.s_tabs').find('.s_tabs_content').removeClass('active').eq(i).addClass('active');

        // Выходим, если не надо перерасчет слайдера.
        if (thisElem.hasClass('js-init-product-media-slider')) {
          return false;
        }

        const $currentTab = thisElem.closest('.s_tabs').find('.s_tabs_content.active');
        const carousel = $currentTab.find('.carousel-1c');
        const products = carousel.find('.slick-initialized');

        if (products.length) {
          products.slick('unslick');
          initCarousel(carousel);
          $currentTab.find('.product-card__body').each(function () {
            initProductCardSlider($(this), 7);
          });
        } else {
          $currentTab.find('.slick-initialized').slick('setPosition');
        }
      }
    });
  });
}
tabs_initialization();

//Вариант с слайдером slick
$('ul.s_tabs_list.s_tabs_list--slick').each(function () {
  $(this).find('.slick-slide').each(function (i) {
    $(this).on("click", function () {
      $('.slick-slide').removeClass('slick-current');
      $(this).addClass('active').siblings().removeClass('active')
        .closest('.s_tabs.s_tabs--slick').find('.s_tabs_content').removeClass('active').eq(i).addClass('active');

    });
  });
});

// Табы на нативном js
// стили в frontend/web/src/scss/template/tabs/_pg-tab.scss
var settingsTab = {
  wrapper: '.js-tab',
  navigation: '.js-tab-nav',
  content: '.js-tab-content'
};

initTabs(settingsTab);

function initTabs(settings) {
  // обвертка таба
  var wrapper = document.querySelector(settings.wrapper);

  // если нет родительского элемента, то выходим из инициализации таба
  if (!wrapper) {
    return false;
  }

  // находим элементы внутри родительского элемента, что бы избежать конфликта с другим табом
  var navigation = wrapper.querySelectorAll(settings.navigation);
  var content = wrapper.querySelectorAll(settings.content);

  // вешаем клики на меню табов
  for (var i = 0; i < navigation.length; i++) {
    navigation[i].addEventListener('click', function () {
      // Находим и удаляем активный предыдущий таб
      var activeNav = wrapper.querySelector(settings.navigation + '.active');
      var activeTab = wrapper.querySelector(settings.content + '.active');
      activeNav.classList.remove('active');
      activeTab.classList.remove('active');

      // вычисляем порядковый номер на котором был клик
      for (var l = 0; l < navigation.length; l++) {
        if (navigation[l] === this) {
          // Активируем нужный таб по клику
          this.classList.add('active');
          content[l].classList.add('active');

          // дополнительный вызов не касающийся таба
          // setPositionProductCard();
        }
      }
    });
  }
}

// Перерисовка слайдера в карточке товара
function setPositionProductCard() {
  var sliderImg = $('.js-product-card-img-slider');
  var sliderColor = $('.js-product-card-img-slider');
  if (sliderImg && sliderColor) {
    $('.js-product-card-img-slider').slick('setPosition');
    $('.js-product-card-color-slider').slick('setPosition');
  }
}