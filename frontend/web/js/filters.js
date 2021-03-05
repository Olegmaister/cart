var category_id = $('.title--page').data('category_id');

$('.clear_filters').on('click', function () {
    $('.filter-colors_checkbox input[type="checkbox"]').prop('checked', false);
    $('.filter-brands_checkbox input[type="checkbox"]').prop('checked', false);
    $('.sidebar-item--atributes input[type="checkbox"]').prop('checked', false);

    history.pushState(null, '', location.pathname);
    getProductsByFilters();

    clearClassSorting();
    $('.sort_all').parent().addClass('active');
    removeClearPanel();
});

function addClearPanel() {
    if ($('.clear_filters').parent().hasClass('hide')) {
        $('.clear_filters').parent().removeClass('hide');
    }
}

function removeClearPanel() {
    if (!$('.clear_filters').parent().hasClass('hide')) {
        $('.clear_filters').parent().addClass('hide');
    }
}

function clearClassSorting() {
    $('.sorting_section').removeClass('active');
    $('.sorting_section').removeClass('_down');
    $('.sorting_section').removeClass('_up');
}

$('.js-select-filter').on('change', function () {
    const value = $(this).val();
    checkAndChangeUrl('sort', value);
    getProductsByFilters();
});

$('.sorting_section').on('click', function (e) {
    e.preventDefault();

    var $this = $(this);

    if ($this.data('sort') == 'all') {
        clearClassSorting();
        checkAndChangeUrl('sort', 'all');
        getProductsByFilters();
    } else if($this.data('sort') == 'price') {

        if($this.hasClass('_up')) {
            clearClassSorting();
            $this.addClass('_down');
            checkAndChangeUrl('sort', '-price');
            getProductsByFilters();
        } else if($(this).hasClass('_down')) {
            clearClassSorting();
            $this.addClass('_up');
            checkAndChangeUrl('sort', 'price');
            getProductsByFilters();
        } else {
            clearClassSorting();
            $this.addClass('_up');
            checkAndChangeUrl('sort', 'price');
            getProductsByFilters();
        }

    } else {
        clearClassSorting();
        $this.data('sort', $this.data('sort'));
        checkAndChangeUrl('sort', $this.data('sort'));
        getProductsByFilters();
    }

    $this.addClass('active');
});

function changeColorGroup(_this) {
    let colorId = _this.attr('id').replace('color-', '');

    if (_this.is(':checked')) {
        checkAndChangeUrl('color_group', colorId);
    } else {
        checkAndChangeUrl('color_group', colorId, 'remove');
        //_this.closest('.check-color').find('input').attr('checkbox', false);
    }
}


$('.filter-colors_checkbox').on('change', '.check-color__parent input[type="checkbox"]', function (e) {
    e.preventDefault();
    let _this = $(this);

    changeColorGroup(_this);
    getProductsByFilters();
});

$('.filter-colors_checkbox').on('change', '.check-color__children input[type="checkbox"]', function (e) {
    let colorId = ($(this).attr('id').replace('parent-', ''));
    var parent = $(this).closest('.check-color').find('input.main');

    /*if(!parent.prop('checked')) {
        parent.prop('checked', true);
        changeColorGroup(parent);
    }*/

    if ($(this).is(':checked')) {
        checkAndChangeUrl('colors', colorId);
    } else {
        checkAndChangeUrl('colors', colorId, 'remove');
    }

    getProductsByFilters();
});

$('.filter-brands_checkbox').on('change', 'input[type="checkbox"]', function (e) {
    e.preventDefault();
    let brandId = ($(this).attr('id').replace('brand-', ''));

    if ($(this).is(':checked')) {
        checkAndChangeUrl('brands', brandId);
    } else {
        checkAndChangeUrl('brands', brandId, 'remove');
    }

    getProductsByFilters();
});

$('.sidebar-item--atributes').on('change', 'input[type="checkbox"]', function (e) {
    e.preventDefault();
    let attributeId = ($(this).attr('id').replace('attribute-', ''));

    if ($(this).is(':checked')) {
        checkAndChangeUrl('attributes', attributeId);
    } else {
        checkAndChangeUrl('attributes', attributeId, 'remove');
    }

    getProductsByFilters();
});


let louder = '<div class="loader-catalog js-loader-catalog">\n' +
                '<div class="dot"></div>\n' +
                '<div class="dot"></div>\n' +
                '<div class="dot"></div>\n' +
                '<div class="dot"></div>\n' +
                '<div class="dot"></div>\n' +
                '<div class="dot"></div>\n' +
                '<div class="dot"></div>\n' +
                '<div class="dot"></div>\n' +
                '<div class="dot"></div>\n' +
            '</div>';

function getProductsByFilters() {
    let $wrapperCatalogCards = $('.js-catalog-cards');
    let $wrapperCatalogFilter = $('.js-catalog-filter');

    $.ajax({
        url: location.pathname + location.search,
        beforeSend: function(){
            // запускаем лоудер
            $wrapperCatalogCards.addClass('is-load-card');
            $wrapperCatalogCards.prepend(louder);
            $wrapperCatalogFilter.addClass('is-change-load');
        }
    }).done(function (response) {
        // останавливаем лоуде
        $wrapperCatalogCards.removeClass('is-load-card');
        $wrapperCatalogFilter.removeClass('is-change-load');
        $('.js-loader-catalog').remove();

        $('.product-card-wrap--view-1').html(response.products);

        if(response.pagination) {
            $('.page-content-inner-row').html(response.pagination);
        } else {
            $('.page-content-inner-row').html('');
        }

        $('.product-card__body').each(function () {
            if ($('.product-card-wrap').hasClass('product-card-wrap--view-2')) {
                initProductCardSlider($(this), 4);
            } else {
                initProductCardSlider($(this), 7);
            }
        });

        if(response.filters && response.filters.price !== undefined ) {
            $('.section_filter-price').html(response.filters.price);
            if($('.sidebar-item--price').hasClass('hide')) {
                $('.sidebar-item--price').removeClass('hide');
            }
            initPriceRange();
        } else {
            $('.sidebar-item--price').addClass('hide');
            //alert('EMPTY');
        }

        if(response.filters && response.filters.color_group !== undefined ) {
            $('#js-height-colors').html(response.filters.color_group);

            var heightBlock = $('#js-height-colors').height();

            if( heightBlock < 195 ) {
                $('.sidebar-item__arrow--colors').css('display','none');
            } else {
                $('.sidebar-item__arrow--colors').css('display','block');
            }
            if( heightBlock < 2 ) {
                $('.sidebar-item--colors').css('display','none');
            }
        }

        if(response.filters && response.filters.brands !== undefined ) {
            $('#js-height-manufactured').html(response.filters.brands);

            var heightBlock = $('#js-height-manufactured').height();

            if (heightBlock) {

                if( heightBlock < 184 ) {
                    $('.filter-brands_checkbox').removeClass('sidebar-item-content--scroll');
                } else {
                    $('.filter-brands_checkbox').addClass('sidebar-item-content--scroll');
                }
                if( heightBlock < 2 ) {
                    $('.sidebar-item--manufactured').css('display','none');
                }
            }

        }

        /* Вставляем фильтры по атрибутам */
        if(response.filters && response.filters.attributes != '' ) {
            $('.sidebar-item--atributes').html(response.filters.attributes);
              /*           setTimeout(function(){
                            var heightBlock = $('#js-height-atributes').height();
                            if( heightBlock < 184 ) {
                                $('.sidebar-item__arrow--atributes').css('display','none');
                            } else {
                                $('.sidebar-item__arrow--atributes').css('display','block');
                            }

                            //console.log(heightBlock,'full');
                            }, 1000);
            */
            //              $('.sidebar-item--atributes').css('display','block');
        } else {
            //console.log(heightBlock,'empty');
            //$('.sidebar-item--atributes').css('display','none');
            //$('#js-height-atributes').html(' ');
        }
    });
}

initPriceRange();
function initPriceRange() {
    var rangePrice = document.querySelector('.js-filter-price');
    if (!rangePrice) {
        return false;
    }
    var valueMin = +rangePrice.getAttribute('data-value-min');
    var valueMax = +rangePrice.getAttribute('data-value-max');
    var step = +rangePrice.getAttribute('data-step');
    var min = +rangePrice.getAttribute('data-min');
    var max = +rangePrice.getAttribute('data-max');
    //alert(max);
    noUiSlider.create(rangePrice, {
        start: [valueMin, valueMax],
        connect: true,
        range: {
            'min': min,
            'max': max
        },
        step: step
    });

    rangePrice.noUiSlider.on('change', function () {
        checkAndChangeUrl('price_min', $('.js-filter-price-min').text().toString());
        checkAndChangeUrl('price_max', $('.js-filter-price-max').text());

        //alert( $('.js-filter-price').data('min') );

        checkAndChangeUrl('price_min_val', $('.js-filter-price').data('min').toString());
        //checkAndChangeUrl('price_max_val', $('.js-filter-price').data('max'));
        checkAndChangeUrl('price_max_val', max);
        getProductsByFilters();
    });

    var priceValues = [
        document.querySelector('.js-filter-price-min'),
        document.querySelector('.js-filter-price-max')
    ];

    rangePrice.noUiSlider.on('update', function (values, handle) {
        priceValues[handle].innerHTML = parseInt(values[handle]);
    });
}

function initSlickSlider(sliderImg, sliderColor) {
    if (!sliderImg && !sliderColor) {
        return false;
    }

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



// Показать еще 21 шт для каталогов
$(document).on('click', '.show__more_catalog', function (e) {
    e.preventDefault();

    let $this = $(this);
    let currentPage = $this.data('current_page');
    let pagination = $('li.pagination__item'); //.addClass('active');
    //console.log(pagination);


    if(currentPage != 1) {
        checkAndChangeUrl('page', currentPage, 'remove');
    }
    checkAndChangeUrl('page', currentPage + 1);

    $.ajax({
        url: location.pathname + location.search
    }).done(function (response) {
        $('.product-card-wrap--view-1').append(response.products);
        $this.data('current_page', currentPage + 1);

        if(!response.existNextPage) {
            //Больше страниц нет - удаляем кнопку "показать еще"
            $('.button_show-more').remove();
        }

        pagination.each(function() {
            if($( this ).find('a').data('page') == currentPage) {
                $( this ).addClass('active')
            }
        });
    });
});