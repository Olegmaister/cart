$( document ).ready(function() {

    //установка нового колва товара
    $('.js-cart-quantity-set-minus').on('click',function(e)
    {
        e.preventDefault();
        //получение id
        let productId = getProductId($(this),'product-id');
        //alert(productId);
        //получение текущего колва
        let quantity = $(this).next().val();


        //ajax
        $.ajax({
            url: '/cart/quantity-js',
            method: 'post',
            data: {
                'productId' : productId,
                'quantity' : quantity
            },
            success: function (data) {

            }
        });

    });


    $('.test-click-fuck').on('click',function(){
        $.ajax({
            url: '/cart/quantity',
            method: 'post',
            data: {
            },
            success: function (data) {

            }
        });
    })


    //если заполняются данные получателя
    //делать отвеченный
    $('.js-recipient-data-check').on('click',function(){

        $('#orderform-checkboxrecipient').val(0);

        if(!checkHiddenElement($('.checkout-recipient__data'))){
            $('#orderform-checkboxrecipient').val(1);
        }
    });


    /*functions file helpers*/

    //получение данных по переданному элементу и атр
    function getProductId(element,attributeName)
    {
        return $(element).data(attributeName);
    }

    //проверить что элемент скрыт
    //return true если элемент hidden
    function checkHiddenElement(element) {
        return element.is(':hidden');
    }



});