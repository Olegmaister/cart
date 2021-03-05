$( document ).ready(function() {
    //показать еще
    $(document).on('click', '.js-view-cost', function(){
        let limit = getLimit();
        let sort = getSortDate();
        let type = getSortType();

        $.ajax({
            url: '/stocks/view',
            method: 'post',
            data: {
                'limit' : limit,
                'sort': sort,
                'type' : type
            },
            success: function (data) {
                let element = $('.wrapper-stocks-list');
                element.empty();
                element.append(data['view']);
            }
        });
    });


    //сортировка по дате
    var stockSort = $('.js-stock-sort');
    stockSort.on('click',function(){
        let limit = getLimit();
        let sort = getSortDate();
        let type = getSortType();

        if(sort === 'desc'){
            $(this).data('sort', 'asc');
            sort = 'asc';
        }
        else{
            $(this).data('sort', 'desc');
            sort = 'desc';
        }

        // Меняем класс для стилизации
        this.classList.toggle('is-active');

        $.ajax({
            url: '/stocks/sort',
            method: 'post',
            data: {
                'limit' : limit,
                'sort' :sort,
                'type' : type
            },
            success: function (data) {
                let element = $('.wrapper-stocks-list');
                element.empty();
                element.append(data['view']);
            }
        });
    });

    //сортировка по типу
    $('#typeform-sort').on('change',function(){
        let limit = getLimit();
        let sort = getSortDate();
        let type = getSortType();

        $.ajax({
            url: '/stocks/sort-type',
            method: 'post',
            data: {
                'limit' : limit,
                'sort' :sort,
                'type' : type
            },
            success: function (data) {
                let element = $('.wrapper-stocks-list');
                element.empty();
                element.append(data['view']);

            }
        });

    });

    //показать по конкретной акции
    $(document).on('click', '.js-view-cost-products', function(){
        let limit = $(this).data('limit');
        let id = $(this).data('id');

        $.ajax({
            url: '/stocks/one-js',
            method: 'post',
            data: {
                'limit' : limit,
                'id' : id
            },
            success: function (data) {
                let element = $('.wrapper-stock-products');
                element.empty();
                element.append(data['view']);

                // Инициализация слайдера
                $('.product-card__body').each(function () {
                    initProductCardSlider($(this), 7);
                });
            }
        });
    });





    /*вынести в helper*/
    //получение лимита
    function getLimit()
    {
        return $('.js-stocks-info').data('limit');
    }

    //получение сортировки по дате
    function getSortDate() {
        return $('.js-stock-sort').data('sort');
    }

    //сортировка по типу
    function getSortType() {
        return $('#typeform-sort').val();
    }




    // Инициализация слайдера, вызваем когда надо добавить новые слайды
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
});