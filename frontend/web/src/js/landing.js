//= ../../node_modules/jquery/dist/jquery.js
//= ../../node_modules/svg4everybody/dist/svg4everybody.js
//= ../../node_modules/slick-carousel/slick/slick.js
//= ../../node_modules/magnific-popup/dist/jquery.magnific-popup.js
//= ../../node_modules/jquery-nice-select/js/jquery.nice-select.js

//= landing/functions.js

const mfpSettings = {
  removalDelay: 300,
  mainClass: 'mfp-zoom-in',
};

$(document).ready(function () {
  // svg sprite cross-browser support
  svg4everybody();

  $('.hamburger').on('click', function () {
    $(this).toggleClass('is-active');
    const $header = $('#header');
    const $menu = $('<div class="mobile-menu"><div class="row"></div></div>');

    if ($header.find('.mobile-menu').length === 0) {
      $('.nav-item').each(function () {
        $menu.find('.row').append($(this).clone());
      });
      $menu.hide().appendTo($header);
    }

    if ($header.find('.mobile-numbers').length === 0) {
      $menu.append($('.dropdown-1__list > .row').clone().addClass('mobile-numbers'));
    }

    $('.mobile-menu').slideToggle();
  });

  // dropdown
  $('.dropdown-1__current').on('click', function () {
    $(this).parent().toggleClass('open');
  });

  $('body').on('click', function (e) {
    if ($(e.target).closest('.dropdown-1').length === 0) {
      $('.dropdown-1').removeClass('open');
    }
  });

  // slider 1
  $('.slider-1').on('init reInit afterChange', function (event, slick, currentSlide) {
    const current = (currentSlide ? currentSlide : 0) + 1;
    if ($(this).find('.slider-1__counter').length === 0) {
      $(this).prepend('<div class="slider-1__counter"></div>');
    }
    $('.slider-1__counter').html('<div>' + twoDigits(current) + '</div><div>' + twoDigits(slick.slideCount) + '</div>');
  }).slick({
    prevArrow: prevArrow('arrow-next'),
    nextArrow: nextArrow('arrow-next'),
    autoplay: 4000,
    sliderToShow: 1,
    rows: 0,
    fade: true
  });

  $('.slider-2').slick({
    prevArrow: prevArrow('arrow-next'),
    nextArrow: nextArrow('arrow-next'),
    sliderToShow: 1,
    rows: 0,
    fade: true
  });

  // carousel 1
  $('.carousel-1').slick({
    prevArrow: prevArrow('arrow-next'),
    nextArrow: nextArrow('arrow-next'),
    rows: 0,
    slidesToShow: 4,
    centerMode: true,
    variableWidth: true,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          variableWidth: false,
        }
      }
    ]
  });

  // carousel 2
  $('.carousel-2').slick({
    prevArrow: prevArrow('arrow-next'),
    nextArrow: nextArrow('arrow-next'),
    rows: 0,
    slidesToShow: 2,
  });

  // product slider
  $('.product-slider').slick({
    prevArrow: prevArrow('arrow-next'),
    nextArrow: nextArrow('arrow-next'),
    rows: 0,
    sliderToShow: 1,
    fade: true,
    dots: true,
  });

  // init youtube players
  $('.youtube-player').on('click', function () {
    // createYoutubeVideo('.youtube-player');
    const videoId = $(this).data('id');
    const height = $(this).outerHeight();

    new YT.Player($(this)[0], {
      width: '100%',
      height: height,
      videoId: videoId,
      events: {
        'onReady': function (event) {
          event.target.playVideo();
        }
      }
    });
  });

  // init nice-select
  $('select').niceSelect();

  // color nice select
  $('.nice-select.select-color').each(function () {
    const $current = $(this).find('.current');

    $current.css({
      'display': 'block',
      'height': '100%',
      'margin-left': '-18px',
      'margin-right': '9px',
    });

    $(this).find('.list li').each(function () {
      const color = $(this).data('value');
      $(this).css('background', color);

      if ($(this).hasClass('selected')) {
        $current.css('background', color);
      }
      $(this).on('click', function () {
        $current.css('background', color);
      });
    });

  });

  // init magnific gallery
  $('.js-gallery').each(function () {
    $(this).find('a').magnificPopup(Object.assign({
      type: 'image',
      gallery: {
        enabled: true,
        tCounter: ''
      }
    }, mfpSettings));
  });

  let modalHistory = [];

  // modal
  $('.js-modal').magnificPopup(Object.assign({
    type: 'inline',
    callbacks: {
      open: function () {
        this.content.find('.slick-initialized').slick('setPosition');

        // вешаем событие
        this.content.find('.mfp-close').on('click', function (e) {
          if (modalHistory.length > 1) {
            // удаляем текущий попап
            modalHistory.splice(-1);
            e.stopPropagation();
            $.magnificPopup.open({
              items: {
                src: '#' + modalHistory[modalHistory.length - 1], // открываем последний попап из массива
                type: 'inline'
              }
            });
          } else {
            modalHistory = [];
          }
        });
      },
      change: function () {
        if (!modalHistory.includes(this.content[0].id)) {
          modalHistory.push(this.content[0].id);
        }
      },
      close: function () {
        modalHistory = [];
      }
    }
  }, mfpSettings));

});
