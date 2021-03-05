var csrfToken = $('meta[name="csrf-token"]').attr("content");
var lang = $('html').attr('lang').substring(0, 2);

// Только для главное страницы
$('.list_by-params').on('click', '.content-nav__item', function (e) {
    $('#all-hits-btn').attr('href', $(this).data('link'));
    $('#all-hits-btn').text($(this).data('title'));
});

$('.main__items').on('click', '.view-more_by-field', function (e) {
    e.preventDefault();
    //alert(lang);

    let $this = $(this);
    let field = $this.data('field');
    let page = $this.data('page');

    getMoreDataByField(field, page);
});

function getMoreDataByField(field, page) {

    $.ajax({
        url: '/' + lang + "/site/get-more-data-by-field",
        data: {"_csrf-frontend": csrfToken, field: field, page: page}
    }).done(function (response) {
        $('.block_product-list__' + field).append(response.content);
        let btnList = $('.btn-list__' + field);
        btnList.data('page', response.page);
        let className = field + btnList.data('page');

        if (response.existNextPage == false) {
            $('.btn-list__' + field).addClass('hide');
        }

        initSlider($('.' + className), $('.' + className + '_c'));
    });
}

$('.currency_list li').on('click', function (e) {
    e.preventDefault();

    let currency = $(this).text();

    $.ajax({
        url: "/site/set-currency",
        data: {"_csrf-frontend": csrfToken, currency: currency}
    }).done(function (response) {
        history.pushState(null, '', location.pathname);
        location.reload();
    });
});


// Section Brands
$('.brand-country_selected').on('change', function (e) {
    e.preventDefault();

    $this = $(this);

    getBrandCategories($this.val(), 'country_id');
});

$('.brands-content-but').on('click', function (e) {
    e.preventDefault();

    $this = $(this);
    let page = $this.data('page');

    $.ajax({
        url: '/' + lang + "/brands/index",
        data: {page: page}
    }).done(function (response) {
        $('.brand-content_section').append(response.brands);

        if (response.existNextPage == false) {
            $('.brands-content-but').addClass('hide');
        } else {
            $this.data('page', page + 1);
        }
    });
});

$('.brands__categories-but').on('click', function (e) {
    e.preventDefault();

    var $this = $(this);
    let page = $this.data('page');
    let item = $this.data('item');

    $.ajax({
        url: location.pathname,
        data: {page: page, item: item}
    }).done(function (response) {

        $('.brand-section_categories').append(response.items);

        if (response.existNextPage == false) {
            if (item == 'categories') {
                $('.brands__categories-but').parent().addClass('hide');
            } else {
                $this.closest('.categories-buttons').addClass('hide');
            }
        } else {
            $this.data('page', page + 1);
        }
        //$this.data('page', page + 1);
    });
});

function initSlider(sliderImg, sliderColor) {
    for (let i = 0; i < sliderImg.length; i++) {

        sliderImg.eq(i).slick({
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
            asNavFor: sliderColor.eq(i)
        });

        sliderColor.eq(i).slick({
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
            slidesToShow: 7,
            slidesToScroll: 1,
            speed: 200,
            infinite: true,
            focusOnSelect: true,
            lazyLoad: 'ondemand',
            asNavFor: sliderImg.eq(i),
            responsive: [{
                breakpoint: 1279,
                settings: {
                    slidesToShow: 5,
                    infinite: true
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3
                }
            }]
        });
    }
}


$('.brands__items-but').on('click', function (e) {
    e.preventDefault();

    var $this = $(this);
    let page = $this.data('page');
    let item = $this.data('item');

    $.ajax({
        url: location.pathname,
        data: {page: page, item: item}
    }).done(function (response) {

        $(".brand-section_" + item).append(response.items);

        if (response.existNextPage == false) {
            $this.closest('.categories-buttons').addClass('hide');
        } else {
            $this.data('page', page + 1);
        }

        let className = item + page;

        initSlider($('.' + className), $('.' + className + '_c'));
    });
});

function getBrandCategories(val, search = 'search') {

    var data = {};
    data[search] = val;

    $.ajax({
        url: location.pathname,
        data: data
    }).done(function (response) {
        $('.brand-content_section').html(response.brands);

        if (response.existNextPage == false) {
            $('.brands-content-but').addClass('hide');
        } else {
            //$this.data('page', page + 1);
        }
    });
}

$('.search-pages__field').on('keyup', function () {
    let val = $(this).val();

    if (val.length > 2) {
        getBrandCategories(val);
    } else {
        if (val == '') {
            getBrandCategories('');
        }
    }
});


// Product detail comment - for COMMIT
var reviewId = '';

function reviewRatingChange() {
    $('.js-product-review-form').append('<input type="hidden" name="re" value="true">');
}


$('body').on('click', '.answer_review', function () {
    reviewId = $(this).data('review_id');
    setTimeout(reviewRatingChange, 500);
});

$('body').on('click', '.send__review', function () {
    reviewId = '';
});

$('body').on('click', '.send_product-review', function (e) {
    e.preventDefault();

    var $this = $(this).closest('.popup-review');
    let name = $this.find('input[name="name"]').val()
    let phone = $this.find('input[name="phone"]').val();
    let productId = $('.page--product').data('product_id');

    if (name == '' || phone == '') {
        alert('Не заполнены поля *');
        return;
    }

    var data = {
        "_csrf-frontend": csrfToken,
        product_id: productId,
        author: name,
        phone: phone,
        text: $this.find('textarea[name="comment"]').val(),
        vote: $('.js-rating-input').val()
    };

    if (reviewId != '') {
        data.answer_review_id = reviewId;
    }

    $.ajax({
        type: 'POST',
        url: "/products/set-review",
        data: data
    }).done(function (response) {
        var close = $('.modal__close, #overlay, .modal--review');

        //$('.modal--review')
        close.animate({opacity: 0}, 200,
            function () {
                $(this).css('display', 'none');
                overlay.fadeOut(400);
            }
        );

        scrollUnlock();
    });
});

/* НАЧАЛО
* *===========Смена цвета товара==========*/
// Смена цвета товара
// Всем добавленным в сравнение товарам добавлен класс для фотографии товара 'is-compare-selected'
// После смены цвета смотрим на наличие этого класса и красим весы
$(document).on('click', '.js-product-card-color', function () {
    var $productImg = $(this).closest('.product-card').find('.js-product-card-img-slider .slick-current .product-card__img-link');
    var $compareIcon = $(this).closest('.product-card').find('.js-compare');

    if ($productImg.hasClass('is-compare-selected')) {
        $compareIcon.addClass('is-compare');
    } else {
        $compareIcon.removeClass('is-compare');
    }
});
/* КОНЕЦ
* *===========Смена цвета товара==========*/

/**
 *  Метод для добавления из форм данных в БД "Обратный звонок" и т.д.
 */
$('form.auxiliary_form').submit(function (e) {
    e.preventDefault();
    let form = $(this);
    const successMessage = $(this).data('success');
    const errorMessage = $(this).data('error')
    const fields = form.find('input, textarea');
    let valid = true;
    let modal = false;
    if (form.hasClass('popup-call')) {
        modal = true;
    }

    fields.each(function () {
        const $el = $(this);
        const value = $el.val();

        $el.removeClass('has-error');
        $el.next('p').remove();
        if (!value) {
            $el
                .addClass('has-error')
                .after('<p class="text-danger">' + errorMessage + '</p>');
            valid = false;
        }
    });

    if (!valid) return false;

    $.ajax({
        type: "POST",
        url: '/forms/create-message',
        data: form.serialize(),
        beforeSend: function () {
          form.find('button[type="submit"]').attr('disabled', true);
        },
        success: function (data) {
            form.find('button[type="submit"]').attr('disabled', false);
            if (modal) {
                form.after('<h2 class="reserve-success-text">' + successMessage + '</h2>');
                form.hide();
            } else {
                form[0].reset();
                notify(successMessage);
            }
            var pagePosition = document.body.dataset.position;
            document.body.style.top = '';
            document.body.style.paddingRight = '';
            document.body.classList.remove('scroll-lock');
            window.scroll({top: pagePosition, left: 0});
            document.body.removeAttribute('data-position');
        }
    });
});


/**
 *  Метод для сравненя COMMPARE
 */
// Добавляет или удаляет в сравнение. Только для карточи товара
$(document).on('click', '.product-slider__compare', function () {
    var _this = $(this);
    let id = $('.page--product').data('product_id');

    toggleCompare(id, _this);
    //setTimeout(counterCompare, 2);
});

// Добавдяеь или удаляет в сравнение. Только из каталогов
$(document).on('click', '.js-compare', function () {
    var _this = $(this);
    let productImg = _this.closest('.product-card').find('.js-product-card-img-slider .slick-current .product-card__img-link');
    toggleCompare(productImg.data('product-id'), _this, productImg);
    // Счетчик для сравниваемых товаров в хедере
    //setTimeout(counterCompare, 2);
});

// Функция для добавления товара в сравнение
function toggleCompare(id, _this, productImg = null) {
    $.ajax({
        url: '/compare/toggle',
        method: 'post',
        data: {"_csrf-frontend": csrfToken, id: id},
        success: function (data) {
            if (productImg) {
                if (data) {
                    // Добавляем иконку в каталоге
                    if (!productImg.hasClass('is-compare-selected')) {
                        productImg.addClass('is-compare-selected');
                    }
                    // Находим фото торавав карточке и меняем класс ему и весам
                    if (!_this.hasClass('is-compare')) {
                        _this.addClass('is-compare');
                    }
                } else {
                    //Удаляем иконку из каталога');
                    if (productImg.hasClass('is-compare-selected')) {
                        productImg.removeClass('is-compare-selected');
                    }
                    if (_this.hasClass('is-compare')) {
                        _this.removeClass('is-compare');
                    }
                }
            } else {
                if (data) {
                    // Добавляем иконку  в ПРОДУКТЕ
                    if (!_this.hasClass('is-compare_img')) {
                        _this.addClass('is-compare_img');
                    }
                } else {
                    // Удаляем иконку  в ПРОДУКТЕ
                    if (_this.hasClass('is-compare_img')) {
                        _this.removeClass('is-compare_img');
                    }
                }
            }
            // Пересчитать количество сравнений
            //setTimeout(counterCompare, 2);
            counterCompare();
        }
    });
}

// Количество сравнения. Пересчитывает и обновляет счетчик сверху
function counterCompare(only = false) {
    $.ajax({
        url: '/compare/count',
        method: 'get',
        success: function (data) {
            // кол-во добавленных товаров в избранное
            let counter = data['result'];
            // пока хедеров аж 3 шт, то пишу All
            let headerIcon = document.querySelectorAll('.js-compare-counter');

            // 0 не надо писать в разметке счетчика, по этому выходим из функции
            if (counter === 0) {
                for (let i = 0; i < headerIcon.length; i++) {
                    headerIcon[i].textContent = '';
                    $('.header-comp-list').removeClass('_show').empty();
                }
                return false;
            }
            // Вставляем значение счетчика
            else {
                for (let i = 0; i < headerIcon.length; i++) {
                    headerIcon[i].textContent = counter;
                }

                if (only === false) {
                    $('.header-comp-list').html(data.menu);
                }
            }
        }
    });
}

// Удаляем одну группу из списка сравнения
$(document).on('click', '.remove_compare_string', function () {
    let $this = $(this);

    removeAllCompare({category: $this.data('link')});

    if ($('div.header-comp-list-item').length === 1) {
        $('.header-comp-list').empty();
    } else {
        $this.closest('.header-comp-list-item').remove();
    }
    // Счетчик для сравниваемых товаров в хедере
    counterCompare(true);
});

// Удаляем все сравнения
$(document).on('click', '.clear-all-compares', function (e) {
    e.preventDefault();
    removeAllCompare({remove_all: true});
    $('.js-compare-counter').html('');
    $('.header-comp-list').text('');
});

// Сама функция удаленя в контроллере
function removeAllCompare(data) {
    $.ajax({
        url: '/compare/delete-all',
        method: 'post',
        data: data,
        success: function (data) {
            counterCompare(true);

            // список id товаров которые удалил
            const arrayProductId = data['product_ids'];

            // если он пуст, то удалять
            if (!arrayProductId) {
                return false;
            }

            for (let i = 0; i < arrayProductId.length; i++) {
                // удаление в картчках товаров в каталоге
                let target = $('a.product-card__img-link[data-product-id="' + arrayProductId[i] + '"]');
                target.removeClass('is-compare-selected');
                target.closest('.product-card').find(".js-compare").removeClass('is-compare');

                // удаление на странице товара
                let productPage = $('.page[data-product_id="' + arrayProductId[i] + '"]');
                if (productPage.length) {
                    $('.product-slider__compare').removeClass('is-compare_img');
                }

                // Удаляем на странице стравнения
                let wrapperCardsCompare = $('.p-compare');
                if (wrapperCardsCompare.length) {
                    let productCard = $('.p-compare-slider-head__close[data-product_id="' + arrayProductId[i] + '"]');
                    productCard.closest('.p-compare-slider-col').remove();

                    let layout = '<div class="compare-empty">' +
                        '<p class="compare-empty__title title-h2">Ваш список сравнения товаров пуст!</p>' +
                        '<p class="compare-empty__subtitle title-h3">Выбрать в сравнение товар можно:</p>' +
                        '<div class="compare-empty__btn">' +
                        '<button class="btn btn--primary btn--primary-red btn--primary-medium">' +
                        '<a href="/categories" class="btn__inner title-h4 title--white">Каталог товаров</a>' +
                        '</button>' +
                        '</div>' +
                        '</div>';

                    wrapperCardsCompare.html(layout);
                }
            }
        }
    });
}

// Удаляем один товар на странице стравнения и вернувшееся вставляем обратно
$(document).on('click', '.p-compare-slider-head__close', function (e) {
    e.preventDefault();
    const $slider = $('.p-compare-slider');
    let id = $(this).data('product_id');
    let wrapperCardsCompare = $('.p-compare');
    const index = $(this).parents('.slick-slide').data('slick-index');

    $.ajax({
        url: '/compare/get-products',
        method: 'post',
        data: {
            id: id,
            category: $('.title--page').data('category')
        },
        success: function (data) {
            // Счетчик для сравниваемых товаров в хедере
            counterCompare();
            // remove slide
            $slider.slick('slickRemove', index);
        },
        error: function () {
            let layout = '<div class="compare-empty">' +
              '<p class="compare-empty__title title-h2">Ваш список сравнения товаров пуст!</p>' +
              '<p class="compare-empty__subtitle title-h3">Выбрать в сравнение товар можно:</p>' +
              '<div class="compare-empty__btn">' +
              '<button class="btn btn--primary btn--primary-red btn--primary-medium">' +
              '<a href="/categories" class="btn__inner title-h4 title--white">Каталог товаров</a>' +
              '</button>' +
              '</div>' +
              '</div>';

            wrapperCardsCompare.html(layout);

            $('.header-comp-list').empty().removeClass('_show');
            $('.js-compare-counter').empty();
        }
    });
});

$(function () {
    let formData = '<input name="' + $('html').attr('data-form') + '" type="hidden" value="' + $('html').attr('data-form') + '">';
    $('#back-call-form').append(formData);
    $('.popup-call.auxiliary_form').append(formData);
    $('#js-form-registration').append(formData);
    $('#js-form-auth').append(formData);
    $('#js-checkout-form-fast').append(formData);
    $('.auxiliary_form').append(formData);
})

