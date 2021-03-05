
// $( document ).ready(function() {
//     //показать еще
//     $(document).on('click', '.js-promo-apply', function(e){
//
//
//         e.preventDefault();
//
//         let token = getPromo();
//
//         $.ajax({
//             url: '/checkout/promo',
//             method: 'post',
//             data: {
//                 'token' : token
//             },
//             success: function (data) {
//                 if(data['success']){
//                     $('.js-cart-popup-cost-total').text(data['total']);
//                     $('.js-discount-percent').text(data['discountPercent']);
//                     $('.js-discount-money').text(data['discountMoney']);
//                 }else{
//
//                     $('.js-promo-error').text(data['message']);
//                 }
//
//             }
//         });
//     });
//
// });