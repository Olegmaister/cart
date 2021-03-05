const isComparePage = $body.find('.p-compare').length;

if (isComparePage === 0) {
// lazy on document loaded
  slickLazyLoad();
// lazy on scroll
  $(window).on('scroll', slickLazyLoad);
}

function slickLazyLoad() {
  const scrollTop = $(this).scrollTop();
  const scrollBottom = scrollTop + $(this).height();

  $('.product-card__body').each(function () {
    const itemTop = $(this).offset().top;
    const colors = $(this).find('.product-card__color');
    if (!colors.length) {
      $(this).parents('.product-card').addClass('no-colors');
    }

    if (!$(this).hasClass('loaded') && scrollBottom >= itemTop) {
      initProductCardSlider($(this), 6);
      $(this).addClass('loaded');
    }
  });
}

function initProductCardSlider(element, colorCountSlider) {
  var sliderImg = element.find('.js-product-card-img-slider');
  var sliderColor = element.find('.js-product-card-color-slider');

  sliderImg.not('.slick-initialized').slick({
    arrows: false,
    fade: true,
    dots: false,
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 200,
    lazyLoad: 'ondemand',
    touchMove: false,
    swipe: false,
    draggable: false,
    asNavFor: sliderColor
  });

  sliderColor.not('.slick-initialized').slick({
    fade: false,
    prevArrow: '<span class="product-card__arrow product-card__arrow--left"><svg version="1.1" fill="#BBBBBB" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\n' +
      '\t viewBox="0 0 256 256" style="enable-background:new 0 0 256 256;" xml:space="preserve">\n' +
      '\t\t<polygon points="207.093,30.187 176.907,0 48.907,128 176.907,256 207.093,225.813 109.28,128"/>\t\n' +
      '</svg></span>',
    nextArrow: '<span class="product-card__arrow product-card__arrow--right"><svg fill="#BBBBBB" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\n' +
      '\t viewBox="0 0 256 256" style="enable-background:new 0 0 256 256;" xml:space="preserve">\n' +
      '\t\t<polygon points="79.093,0 48.907,30.187 146.72,128 48.907,225.813 79.093,256 207.093,128"/>\t\n' +
      '</svg></span>',
    dots: false,
    slidesToShow: colorCountSlider,
    slidesToScroll: 1,
    speed: 200,
    infinite: true,
    focusOnSelect: true,
    rows: 0,
    asNavFor: sliderImg,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 4
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 5
        }
      },
      {
        breakpoint: 450,
        settings: {
          slidesToShow: 3
        }
      },
    ]
  });

}

$(document).on('click', '.js-product-card-color', function () {
  /**
   *  Меняем картинку товара по клику на цвет товара
   * */
  var slider = $(this).closest('.js-product-card-color-slider').prev('.js-product-card-img-slider');
  slider.slick('slickGoTo', $(this).data('slickIndex'));

  let $productCard = $(this).closest('.product-card');

  /**
   *  Меняем ссылку у названия товара по клику на цвет товара
   * */
  var link = slider.find('.slick-active a').attr('href');
  var $titleLink = $productCard.find('.product-card__name-link');
  $titleLink.attr('href', link);

  /**
   *  меняем id товара в наименовании товара для добавления в избранное
   * */
  var $title = $productCard.find('.product-card__name');
  var id = $(this).find('img').attr('data-product-id');


  $title.attr('data-product-id', id);

  /**
   *  Смена название товара
   * */
  let currentProduct = $productCard.find('.slick-slide.slick-current .product-card__img-link');
  let nameProduct = currentProduct.attr('data-product-name');
  $title.find('.product-card__name-link').text(nameProduct);


  /**
   *  Смена стоимости
   */
  // меняем цену товара
  //let priceProduct = currentProduct.attr('data-product-price');
  //let oldPriceProduct = currentProduct.attr('data-product-old-price');
  //var priceProduct = 0;
  // var oldPriceProduct = 0;


  $.ajax({
    url: '/stock/price/current-price',
    method: 'post',
    data: {
      id: id
    },
    success: function (data) {
      let priceProduct = data['price'];
      let oldPriceProduct = data['oldPrice'];


      //Смена окончательной стоимости
      $productCard.find('.js-product-new-price').text(priceProduct);

      //Сменя стоимости до скидки
      if (oldPriceProduct === 0) {
        $productCard.find('.product-card__price--old').fadeOut(0);
        $productCard.find('.js-product-old-price').text(oldPriceProduct);
      } else {
        $productCard.find('.product-card__price--old').fadeIn(0);
        $productCard.find('.js-product-old-price').text(oldPriceProduct);
      }

    }
  });


  // //Смена окончательной стоимости
  // $productCard.find('.js-product-new-price').text(priceProduct);
  //
  // //Сменя стоимости до скидки
  // if (oldPriceProduct === "0") {
  //   $productCard.find('.product-card__price--old').fadeOut(0);
  //   $productCard.find('.js-product-old-price').text(oldPriceProduct);
  // } else {
  //   $productCard.find('.product-card__price--old').fadeIn(0);
  //   $productCard.find('.js-product-old-price').text(oldPriceProduct);
  // }

  /**
   *  Смена лейб
   * */
  setLabel();

  function setLabel() {
    // тут лежит JSON
    let productLabelJson = currentProduct.attr('data-product-label');

    const isSubscribed = currentProduct.attr('data-stock-subscribe');
    const $cartButton = $productCard.find('.js-open-modal-size')
    const $subscribeButton = $productCard.find('.js-open-stock-subscribe')
    let wrapLabel = $productCard.find('.js-product-card-labels');
    wrapLabel.empty();
    $cartButton.show();
    $subscribeButton
      .attr('data-product_id', id)
      .removeClass('active')
      .hide();

    if (+isSubscribed) {
      $subscribeButton.addClass('active');
    }

    if (!productLabelJson) return false;

    let productLabelArr = JSON.parse(productLabelJson);

    wrapLabel.empty();

    for (let i = 0; i < productLabelArr.length; i++) {
      let html;

      if (productLabelArr[i].label === "sale") {
        html = `<span class="product-card__label background_sale">${productLabelArr[i].name}</span>`;
      } else if (productLabelArr[i].label === "new") {
        html = `<span class="product-card__label background_new">${productLabelArr[i].name}</span>`;
      } else if (productLabelArr[i].label === "stock_shares") {
        html = `<span class="product-card__label background_stock_shares">${productLabelArr[i].name}</span>`;
      } else if (productLabelArr[i].label === "hit") {
        html = `<span class="product-card__label background_hit">${productLabelArr[i].name}</span>`;
      } else if (productLabelArr[i].label === "recommend") {
        html = `<span class="product-card__label background_recommend">${productLabelArr[i].name}</span>`;
      } else if (productLabelArr[i].label === "not_available") {
        $cartButton.hide();
        $subscribeButton.show();
        html = `<span class="product-card__label background_not_available">${productLabelArr[i].name}</span>`;
      }

      wrapLabel.prepend(html);
    }
  }
});

function compProductCardSlider() {
  var $productItem = $(document).find('.p-compare-slider-col');
  $productItem.each(function () {
    var _self = $(this);
    var $colorsParent = _self.find('.js-compare-height-colors');
    var slider = _self.find('.js-product-card-img-slider');

    $('.p-compare-slider').on('setPosition', function () {
      $colorsParent.on('click', '.product-colors__item', function (e) {
        _self.find('.product-colors__item').removeClass('_active');
        $(this).addClass('_active');
        // Меняем картинку товара по клику на цвет товара
        slider.slick('slickGoTo', $(this).index());

        // Меняем ссылку у названия товара по клику на цвет товара
        var link = slider.find('.slick-active a').attr('href');
        var $titleLink = _self.find('.product-card__name-link');
        $titleLink.attr('href', link);

        // меняем название товара
        let currentProduct = _self.find('.slick-slide.slick-current .product-card__img-link');
        let nameProduct = currentProduct.attr('data-product-name');
        _self.find('.product-card__name-link').text(nameProduct);

        // меняем цену товара
        let priceProduct = currentProduct.attr('data-product-price');
        let oldPriceProduct = currentProduct.attr('data-product-old-price');

        //Смена окончательной стоимости
        _self.find('.js-product-new-price').text(priceProduct);

        //Смена стоимости до скидки
        if (oldPriceProduct === "0") {
          _self.find('.product-card__price--old').fadeOut(0);
          _self.find('.js-product-old-price').text(oldPriceProduct);
        } else {
          _self.find('.product-card__price--old').fadeIn(0);
          _self.find('.js-product-old-price').text(oldPriceProduct);
        }
      });
    })
  });
}

compProductCardSlider()