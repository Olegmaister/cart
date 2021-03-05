$(document).width();

$(document).ready(function () {

    if (heightDescProduct) {

        var heightBlock = heightDescProduct.clientHeight;

        if( heightBlock < 512 ) {
            $('.product-desc-but--show').css('display','none');
        } else {
            $('#js-height').addClass('_open');
            $('.product-desc-but--show').css('display','block');
            $('.product-desc-but--show').click(function () {

                if($(this).css('display') == 'block') {
                    $('#js-height').removeClass('_open');
                    $(this).prev().css("max-height",'100%');
                    $(this).css('display','none');
                    $(this).next().css('display','block');
                }
            });
        }
    }

    $('.product-desc-but--hidden').click(function () {
        if($(this).css('display') == 'block') {
            $('#js-height').addClass('_open');
            $(this).prev().prev().css("max-height",'512px');
            $(this).css('display','none');
            $(this).prev().css('display','block');
        }
    });

    //page product size
    if (heightSizeProduct) {

        let heightBlock = heightSizeProduct.clientHeight;

        if( heightBlock < 120 ) {
            $('.js-sizes-link-show').css('display','none');
        } else {
            $('.js-sizes-link-show').css('display','block');
            $('.js-sizes-link-show').click(function () {
                if($(this).css('display') == 'block') {
                    $(this).prev().css("max-height",'100%');
                    $(this).prev().css("overflow",'visible');
                    $(this).css('display','none');
                    $(this).next().css('display','block');
                }
            });
        }

    }



    $(document).on('click', '.js-open-modal-shop', function() {

        function pauseForPopapSizesHeight(){

            var heightPopupShopSize = document.getElementById('js-popup-shop-size-height');

            //Popup shop size
            if (heightPopupShopSize) {

                var heightPopupShopSizes = heightPopupShopSize.clientHeight;

                if( heightPopupShopSizes < 34 ) {
                    $('.js-popup-shop-size-but').css('display','none');

                } else {
                    $('.js-popup-shop-size-but').css('display','block');
                }
            }
        }
        setTimeout(pauseForPopapSizesHeight, 1000);
    });

    $(document).on('click', '.js-popup-shop-size-but', function () {

        $(this).toggleClass('_show');

        $(this).closest('.popup-shop-table-row--bot').prev().children('.popup-shop-table-size').css('height','auto');

        if( $(this).hasClass('_show') ) {
            $(this).text($(this).data('hide'));

        } else {
            $(this).text($(this).data('show'));
            $(this).closest('.popup-shop-table-row--bot').prev().children('.popup-shop-table-size').css('height','33');
        }
    });



    let productPageWight = $(window).outerWidth();
    if(productPageWight < 601) {

        $('.js-sizes-hidden').click(function () {
            if($(this).css('display') == 'block') {
                $(this).prev().prev().css("max-height",'140px');
                $(this).prev().prev().css("overflow",'hidden');
                $(this).css('display','none');
                $(this).prev().css('display','block');
            }
        });

    } else {

        $('.js-sizes-hidden').click(function () {

            if($(this).css('display') == 'block') {

                $(this).prev().prev().css("max-height",'118px');
                $(this).prev().prev().css("overflow",'hidden');
                $(this).css('display','none');
                $(this).prev().css('display','block');
            }
        });
    }

    //view other comments
    $(document).on('click', '.js-answers', function () {

        if($(this).closest('.product-reviews-bot').next().css('display') == 'none') {
            $(this).closest('.product-reviews-bot').next().slideDown( "fast", function() {});
        } else {
            $(this).closest('.product-reviews-bot').next().slideUp( "fast", function() {});
        }
    });
});
