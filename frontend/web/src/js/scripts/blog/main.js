//показать еще
$('.js-blog-show-more').on('click',function(){
   let page = getPage($(this));
   let id = getId($(this));

   let language = currentLang();

    $.ajax({
        method: 'get',
        url: '/'+language+'/blogs/index?page='+page+'&id='+id,
        data: {

        },
        dataType: 'json',
        'success': function (data) {
            let element = $('.wrapper-blog-'+id).append(data['view']);
            showButton(data['button'],id);
            $('.js-wrapper-blog-page-'+id).data('page',page + 1)
        },
        'error': function (response) {

        }
    });
});

$('.js-account-order-show-more').on('click',function(){
    let language = currentLang();
    //получение параметра page(следующая страница)
    let page = getPage($(this));
    //запрос
    $.ajax({
        method: 'get',
        url: '/'+language+'/customer/account/order/?page='+page,
        data: {

        },
        dataType: 'json',
        'success': function (data) {
            //добавляем в общей блок новую выборку
            let element = $('.wrapper-account-order').append(data['view']);
            let button = data['button'];
            let page = data['page'];


            //показывать/скрывать кнопку
            if(!button)
                $('.js-account-order-show-more').css({'display' : 'none'});
            //изменяем параметр data-page
            $('.js-account-order-show-more').data('page',page);


        },
        'error': function (response) {

        }
    });


});




//показать еще pages => about
$('.js-about-blog-show-more').on('click',function(){


    let page = getPage($(this));
    let id = getId($(this));

    $.ajax({
        method: 'get',
        url: '/pages/about?page='+page+'&id='+id,
        data: {

        },
        dataType: 'json',
        'success': function (data) {

            let element = $('.wrapper-blog-'+id).find('.js-blog-container').append(data['view']);
            showButton(data['button'],id);
            $('.js-wrapper-blog-page-'+id).data('page',page + 1)
        },
        'error': function (response) {

        }
    });
});


//добавление like для блога
$(document).on('click', '.js-blog-add-like', function(){

    let id = $(this).data('id');
    let quantity = 1;

    $.ajax({
        method: 'post',
        url: '/blogs/like',
        data: {
            id : id,
            quantity : quantity
        },
        dataType: 'json',
        'success': function (data) {
            if(data['success']){
                $('.js-blog-like-'+id).text(data['like']);
            }else{
                alert(data['message']);
            }
        },
        'error': function (response) {

        }
    });
});


function getPage(element) {
      return element.data('page');
}

function getId(element) {
      return element.data('id');
}

function showButton(flagButton,id) {
    if(!flagButton)
        $('.js-wrapper-blog-page-'+id).css({'display' : 'none'})
}