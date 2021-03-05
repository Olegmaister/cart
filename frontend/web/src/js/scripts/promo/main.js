//показать еще
$(document).on('click', '.js-promo-apply', function(e){

    e.preventDefault();

    //получение токена
    let token = getPromo();
    let deliveryCost = $('.js-order-cart-delivery-cost').text();

    $.ajax({
        url: '/' + currentLang() + '/checkout/promo',
        method: 'post',
        data: {
            'token' : token,
            'deliveryCost' : deliveryCost
        },
        success: function (data) {
            if(data['success']){
                $('.js-cart-popup-cost-total').text(data['total']);
                $('.js-discount-money').text(data['discountMoney']);


                let wrapperElement = $('.js-wrapper-order-cart');
                wrapperElement.empty();
                wrapperElement.append(data['view']);


            }else{

                $('.js-promo-error').text(data['message']);
            }

        }
    });
});