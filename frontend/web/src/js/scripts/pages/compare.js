$('.p-compare-slider')
  .on('init', function () {
      $('.sizes-switch').each(initSizeSwitch);
      $('.product-card__body').each(function () {
          initProductCardSlider($(this), 6);
      });
  })
  .slick({
    centerMode: false,
    arrows: true,
    dots: false,
    slidesToShow: 4,
    slidesToScroll: 1,
    autoplay: false,
    autoplaySpeed: 5000,
    prevArrow:'.p-compare-slider__arrow.p-compare-slider__arrow--prev',
    nextArrow:'.p-compare-slider__arrow.p-compare-slider__arrow--next',
    responsive:
        [
            {
                breakpoint: 1365,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1
                }
            }
        ]


});

//Функционал скролла стрелок
$(window).on('scroll',function() {

    var arrow = $('.p-compare-slider__arrow');

    //Вычисляем расстояние от верха экрана до стрелок слайдера+ динамично измеряем положение стрелок
    if (arrow.length ) {
        var offsetTop = arrow.offset().top + $(window).scrollTop();
    }

    //Вычисляем расстояние от верха экрана, до блока - ЯКОРЯ
    var ancor = $('.js-ancor');

    if (ancor.length ) {
        var offsetAncor = ancor.offset().top;
    }

    //console.log(arrow,'Стрелка');
    //console.log(x,'Якорь'); 

    var cssValuesChange = {
        "position":"absolute",
        "top": offsetAncor - 480
    }

    var cssValuesDefault = {
        "position":"fixed",
        "top": "initial"
    }

    //Если высота стрелок равно или больше блока ancor и (минус высота хедера), то выполняем условие...
    if(offsetTop >= offsetAncor) {

        console.log('РАВНО');

        $('.js-arrow-compare').css(cssValuesChange);

    } else {

        $('.js-arrow-compare').css(cssValuesDefault);

    }

});

scroll()




//Открываем часть скрытого текста, если его больше чем 5 строк
$(document).ready(function () {

    var num = $('.p-compare-slider-col');

    for (var i = 0; i < num.length; i++) {

        //Блоки размеров
        $('.js-compare-height-sizes').eq(i).attr('id', 'js-compare-height-sizes-'+i);

        //Блоки цветов
        $('.js-compare-height-colors').eq(i).attr('id', 'js-compare-height-colors-'+i);

        //Текст ОПИСАНИЕ
        $('.js-compare-height-desc').eq(i).attr('id', 'js-compare-height-desc-'+i);

        //Текст ДОП. ИНФОРМАЦИЯ
        $('.js-compare-height-extra').eq(i).attr('id', 'js-compare-height-extra-'+i);

        //Текст ХАРАКТЕРИСТИК
        $('.js-compare-height-character').eq(i).attr('id', 'js-compare-height-character-'+i);


        //Высота содержимого в - РАЗМЕРАХ
        var heightCompareSizes = document.getElementById('js-compare-height-sizes-'+i);

        //Высота содержимого в - ЦВЕТАХ
        var heightCompareColors = document.getElementById('js-compare-height-colors-'+i);

        //Высота содержимого в - ОПИСАНИЕ
        var heightCompareDescriptions = document.getElementById('js-compare-height-desc-'+i);

        //Высота содержимого в - ХАРАКТЕРИСТИКАХ
        var heightCompareCharacteristic = document.getElementById('js-compare-height-character-'+i);

        //Высота содержимого в - ДОП. ИНФОРМАЦИЯ
        var heightCompareExtra = document.getElementById('js-compare-height-extra-'+i);

        //Высота ЦВЕТОВ
        if (heightCompareSizes) {

            //ОПИСАНИЕ
            var heightBlockCompareSize = heightCompareSizes.clientHeight;

            if( heightBlockCompareSize < 51 ) {

                $(heightCompareSizes).closest('.p-compare-param-inner--sizes').next().css('opacity','0');

            } else {

                $(heightCompareSizes).closest('.p-compare-param-inner--sizes').next().css('opacity','1');

            }

            if( heightBlockCompareSize < 2 ) {

                $(heightCompareSizes).closest('.p-compare-param-inner--sizes').next().css('opacity','0');

            }

        }

        //Высота РАЗМЕРОВ
        if (heightCompareColors) {

            //ОПИСАНИЕ
            var heightBlockCompareColor = heightCompareColors.clientHeight;

            if( heightBlockCompareColor < 39 ) {

                $(heightCompareColors).closest('.p-compare-param-inner--colors').next().css('opacity','0');

            } else {

                $(heightCompareColors).closest('.p-compare-param-inner--colors').next().css('opacity','1');

            }

            if( heightBlockCompareColor < 2 ) {

                $(heightCompareColors).closest('.p-compare-param-inner--colors').next().css('opacity','0');

            }

        }

        //Высота описания
        if (heightCompareDescriptions) {

            //ОПИСАНИЕ
            var heightBlockCompareDesc = heightCompareDescriptions.clientHeight;

            if( heightBlockCompareDesc < 114 ) {

                $(heightCompareDescriptions).next().css('display','none');

            } else {

                $(heightCompareDescriptions).next().css('display','flex');

            }

            if( heightBlockCompareDesc < 2 ) {

                $(heightCompareDescriptions).next().css('display','none');

            }

        }

        if (heightCompareCharacteristic) {

            //ХАРАКТЕРИСТИКИ
            var heightBlockCompareChar = heightCompareCharacteristic.clientHeight;

            if( heightBlockCompareChar < 164 ) { 

                $(heightCompareCharacteristic).parent().removeClass('_shadow');

                $(heightCompareCharacteristic).next().css('display','none');

            } else {

                $(heightCompareCharacteristic).parent().addClass('_shadow');

                $(heightCompareCharacteristic).next().css('display','flex');

            }

            if( heightBlockCompareChar < 2 ) {

                $(heightCompareCharacteristic).next().css('display','none');

            }

        }

        if (heightCompareExtra) {

            //ДОП. ИНФОРМАЦИЯ
            var heightBlockCompareExtra = heightCompareExtra.clientHeight;

            $('.js-compare-view-char-but').click(function () {

            });

            if( heightBlockCompareExtra < 114 ) {

                $(heightCompareExtra).next().css('display','none');

            } else {

                $(heightCompareExtra).next().css('display','flex');

            }
            if( heightBlockCompareExtra < 2 ) {

                $(heightCompareExtra).next().css('display','none');

            }
        }

    }//for

    //Открыть дополнительные размеры
    $(document).on('click', '.js-compare-view-size-but', function () {

        $('.js-compare-view-size-but').prev().toggleClass('p-compare-options--show');


        //Подсчет самого длинного блока - ОПИСАНИЯ
        var maxHeight = Math.max.apply(null, $('.p-compare-slider-col .p-compare-param--sizes').map(function () {
            return this.clientHeight;
        }));

        //Добавляем высоту всем блокам ОПИСАНИЯ, как в самом длинном блоке
        if( $('.js-compare-view-size-but').prev().hasClass('p-compare-options--show') ) {

            $('.js-compare-view-size-but').text('Скрыть');

            $('.p-compare-slider-col .p-compare-param--sizes').css('height',maxHeight);

        } else {

            $('.js-compare-view-size-but').text('Показать все размеры');

            $('.p-compare-slider-col .p-compare-param--sizes').css('height', 'auto');

        }

    });

    //Открыть дополнительные размеры
    $(document).on('click', '.js-compare-view-color-but', function () {

        $('.js-compare-view-color-but').prev().toggleClass('p-compare-options--show');


        //Подсчет самого длинного блока - ОПИСАНИЯ
        var maxHeight = Math.max.apply(null, $('.p-compare-slider-col .p-compare-param--colors').map(function () {
            return this.clientHeight;
        }));

        //Добавляем высоту всем блокам ОПИСАНИЯ, как в самом длинном блоке
        if( $('.js-compare-view-color-but').prev().hasClass('p-compare-options--show') ) {

            $('.js-compare-view-color-but').text('Скрыть');

            $('.p-compare-slider-col .p-compare-param--colors').css('height',maxHeight);

        } else {

            $('.js-compare-view-color-but').text('Показать все цвета');

            $('.p-compare-slider-col .p-compare-param--colors').css('height', 'auto');

        }

    });

    //Открыть дополнительный текст в ОПИСАНИИ
    $(document).on('click', '.js-compare-view-desc-but', function () {

        $('.js-compare-view-desc-but').toggleClass('_transform');
        $('.js-compare-view-desc-but').closest('.p-compare-options-bot').parent().toggleClass('p-compare-options--show');


        //Подсчет самого длинного блока - ОПИСАНИЯ
        var maxHeight = Math.max.apply(null, $('.p-compare-slider-col #js-compare-option-desc-height').map(function () {
            return this.clientHeight;
        }));

        //Добавляем высоту всем блокам ОПИСАНИЯ, как в самом длинном блоке
        if( $('.js-compare-view-desc-but').closest('.p-compare-options-bot').parent().hasClass('p-compare-options--show') ) {

            $('.p-compare-slider-col #js-compare-option-desc-height').css('height',maxHeight);

        } else {

            $('.p-compare-slider-col #js-compare-option-desc-height').css('height', 'auto');

        }

    });

    //Открыть дополнительный блок ХАРАКТЕРИСТИК
    $(document).on('click', '.js-compare-view-char-but', function () {

        //var compareForShadowShow = $(this).closest('.p-compare-options-bot').prev().height();

        $('.js-compare-view-char-but').toggleClass('_transform');

        $('.js-compare-view-char-but').closest('.p-compare-options-bot').parent().toggleClass('p-compare-options-inner--show');


        //Подсчет самого длинного блока - ХАРАКТЕРИСТИК
        var maxHeightChar = Math.max.apply(null, $('.p-compare-slider-col .p-compare-options--character').map(function () {
            return this.clientHeight;
        }));

        //Добавляем высоту всем блокам ХАРАКТЕРИСТИКИ, как в самом длинном блоке
        if( $('.js-compare-view-char-but').closest('.p-compare-options-bot').parent().hasClass('p-compare-options-inner--show') ) {

            $('.p-compare-slider-col .p-compare-options--character').css('height',maxHeightChar);

            $('.js-compare-view-char-but').closest('.p-compare-options-bot').parent().removeClass('_shadow');

        } else {

            // if( compareForShadowShow > 164 ) {
            //
            //     $('.js-compare-view-char-but').closest('.p-compare-options-bot').parent().addClass('_shadow');
            //
            // }

            $('.js-compare-view-char-but').closest('.p-compare-options-bot').parent().addClass('_shadow');

            $('.p-compare-slider-col .p-compare-options--character').css('height', 'auto');

        }

    });

    //Открыть дополнительный текст в ДОП. ИНФОРМАЦИИ
    $(document).on('click', '.js-compare-view-extra-but', function () {

        $('.js-compare-view-extra-but').toggleClass('_transform');
        $('.js-compare-view-extra-but').closest('.p-compare-options-bot').parent().toggleClass('p-compare-options--show');

        //Подсчет самого длинного блока - ОПИСАНИЯ
        var maxHeightExtra = Math.max.apply(null, $('.p-compare-slider-col .p-compare-options--last').map(function () {
            return this.clientHeight;

        }));
        //console.log(maxHeightExtra);
        //Добавляем высоту всем блокам ОПИСАНИЯ, как в самом длинном блоке
        if( $('.js-compare-view-extra-but').closest('.p-compare-options-bot').parent().hasClass('p-compare-options--show') ) {

            $('.p-compare-slider-col .p-compare-options--last').css('height',maxHeightExtra);
            //console.log(maxHeightExtra);
        } else {

            $('.p-compare-slider-col .p-compare-options--last').css('height', 'auto');
            //console.log('noClass',maxHeightExtra);

        }

    });

});





