if ($('.product-slider-thumbs-media--autonom').length < 2) {
  for (let i = $('.product-slider-thumbs-media--autonom').length; i < 2; i++)

    $('.product-slider-thumbs').addClass('_amount')
}

if ($('.product-slider-thumbs-media--autonom').length < 1) {
  for (let i = $('.product-slider-thumbs-media--autonom').length; i < 1; i++)

    $('.product-slider-thumbs').addClass('_full');
}

if ($('.product-slider-thumbs-media--item').length < 4) {
  for (let i = $('.product-slider-thumbs-media--item').length; i < 4; i++)
    $(".product-slider-thumbs-items").append("<div class='product-slider-thumbs-media product-slider-thumbs-media--item _disabled'><div class='product-slider-thumbs-inner'></div></div>");

  function sayHi() {
    $('.product-slider-thumbs-media--item._disabled').closest('.slick-slide').css('pointer-events', 'none');
  }

  setTimeout(sayHi, 2000);

}

if ($('.product-slider-thumbs-media--item').length <= 4) {
  $(".product-slider-arrows-wrap").css("display", "none");
}


$('.js-switch-product-images').on('click', function () {

  $(this).toggleClass('active');

  const mainImages = $('.product-slider-images:not(.product-alt-image), .product-slider-thumbs-items:not(.product-alt-thumbs)')
  const additionalImages = $('.product-alt-image, .product-alt-thumbs');

  if ($(this).hasClass('active')) {
    mainImages.hide().removeClass('active');
    additionalImages.show().addClass('active').slick('setPosition');
  } else {
    additionalImages.hide().removeClass('active');
    mainImages.show().addClass('active').slick('setPosition');
  }
  buildProductModalSlider($('.product-slider-images.active').find('.product-slider-images-media__img'));
});

function buildProductModalSlider($images) {
  $('.slider-popup').remove();
  const $close = $('<button type="button" class="close"aria-label="Close"><span aria-hidden="true">×</span></button>');
  const $arrowLeft = $('<button type="button" class="slick_prev"></button>');
  const $arrowRight = $('<button type="button" class="slick_next"></button>');
  const $modal = $('<div class="slider-popup"></div>');
  const title = $('.product__name.mob-hide-x1279').text();
  const $sliderContainer = $('<div class="product-modal-container"></div>')
  const $slider = $('<div class="product-modal-slider"></div>')
  const $thumbs = $('<div class="product-modal-thumbs"></div>')
  $images.clone().removeClass().appendTo($slider);
  $images.clone().removeClass().appendTo($thumbs);
  $modal.append($close);
  $modal.append('<div class="slider-popup__title">' + title + '</div>');
  $sliderContainer.append($slider);
  $sliderContainer.append($thumbs);
  $sliderContainer.appendTo($modal);
  $arrowLeft.appendTo($modal);
  $arrowRight.appendTo($modal);
  $modal.appendTo('body');

  // open modal
  $(document).on('click', '.product-slider-images-media', function () {
    const slideIndex = $(this).closest('.slick-slide').data('slick-index');
    overlay.fadeIn(300);
    $modal.css('display', 'flex');
    slickInit(slideIndex);
    scrollLock();
  });

  // close modal
  overlay.on('click', function () {
    $modal.hide();
    overlay.fadeOut(300);
    scrollUnlock();
  });

  $close.on('click', function () {
    $modal.hide();
    overlay.fadeOut(300);
    scrollUnlock();
  });


  function slickInit(slideIndex = 0) {
    $slider.not('.slick-initialized').slick({
      rows: 0,
      slidesToShow: 1,
      slidesToScroll: 1,
      asNavFor: $thumbs,
      dots: false,
      prevArrow: $arrowLeft,
      nextArrow: $arrowRight,
    });
    $thumbs.not('.slick-initialized').slick({
      rows: 0,
      asNavFor: $slider,
      arrows: false,
      dots: false,
      focusOnSelect: true,
      infinite: true,
      slidesToShow: 5,
      slidesToScroll: 1,
      responsive:
        [
          {
            breakpoint: 479,
            settings: {
              slidesToShow: 3
            }
          }
        ]
    });
    setTimeout(function () {
      $slider.slick('slickGoTo', slideIndex, true);
    }, 50);
  }
}

buildProductModalSlider($('.product-slider-images.active').find('.product-slider-images-media__img'));

$('.product-slider-images').not('.slick-initialized').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  fade: true,
  asNavFor: '.product-slider-thumbs-items',
  infinite: true,
  arrows: true,
  autoplay: 7000,
  dots: false,
  swipe: false,
  //appendArrows:'.product-slider-arrows',
  prevArrow: '<button type="button" class="slick_prev"></button>',
  nextArrow: '<button type="button" class="slick_next"></button>',
  responsive:
    [
      {
        breakpoint: 766,
        settings: {
          swipe: true
        }
      }
    ]
});

$('.product-slider-thumbs-items').not('.slick-initialized').slick({
  asNavFor: '.product-slider-images',
  arrows: false,
  dots: false,
  centerMode: false,
  focusOnSelect: true,
  infinite: true,
  slidesToShow: 4,
  slidesToScroll: 1,
  //variableWidth: true,
  responsive:
    [
      {
        breakpoint: 479,
        settings: {
          slidesToShow: 3
        }
      }
    ]
});

$('.js-video').click(function () {
  $('.product-slider-modal--video').show();
  $('.product-slider-modal--video-3d').hide();
});

$('.js-video-3d').click(function () {
  $('.product-slider-modal--video-3d').show();
  $('.product-slider-modal--video').hide();
});

$('body').on('click', '.product-slider-thumbs-media--item', function () {
  $('.product-slider-modal--video-3d, .product-slider-modal--video').hide();
});

$('.product-slider-thumbs-media--autonom').click(function () {
  $(this).addClass('slick-current');

  $(this).prev().removeClass('slick-current');
  $(this).next().removeClass('slick-current');

  $(this).parent().prev().find('.slick-current').removeClass('slick-current');
});

$('.product-slider-thumbs-items .slick-slide').click(function () {
  $(this).closest('.product-slider-thumbs-col--left').next().find('.slick-current').removeClass('slick-current');
});
