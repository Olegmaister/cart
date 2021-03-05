var openModalLogin = $('.js-open-modal-login');
var openModalSignin = $('.js-open-modal-signin');
var closeModalLogin = $('.modal__close--login, #overlay');
var modalLogin = $('.modal--login');

openModalLogin.on('click', function(event){
    event.preventDefault();

    // Топорно, нужно будет потом отрефакторить
    // Сдесь мы вызываем клик на первый таб для показа формы авторизации
    // Нужно из-за наличия двух кнопок - вход и регистрации
    // $('ul.s_tabs_list li:nth-child(1)').trigger('click');

    overlay.fadeIn(200,
        function(){
            $(modalLogin)
                .css('display', 'block')
                .animate({opacity: 1}, 200);
        });
    scrollLock();
});

openModalSignin.on('click', function(event){
    event.preventDefault();

    // Топорно, нужно будет потом отрефакторить
    // Сдесь мы вызываем клик на второй таб для показа формы регистрации
    // Нужно из-за наличия двух кнопок - вход и регистрации
    // $('ul.s_tabs_list li:nth-child(2)').trigger('click');

    overlay.fadeIn(200,
        function(){
            $(modalLogin)
                .css('display', 'block')
                .animate({opacity: 1}, 200);
        });
    scrollLock();
});

closeModalLogin.on('click', function(){
    modalLogin
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                overlay.fadeOut(200);
            }
        );
    scrollUnlock();
});

//transform effect
$('.js-link-transformed').on('click', function(){
    $(this).closest('.modal--login').toggleClass('transform');
});
$('.js-register-height-login').on('click', function(){
    $(this).closest('.modal--login').removeClass('modal-register-height');
});
$('.js-register-height-reg').on('click', function(){
    $(this).closest('.modal--login').addClass('modal-register-height');
});
