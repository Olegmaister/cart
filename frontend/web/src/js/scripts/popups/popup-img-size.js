var openModalImgSize = $('.js-open-modal-img-size');
var closeModalImgSize = $('.modal__close--img-size, #overlay');
var modalImgSize = $('.modal--img-size');

openModalImgSize.click( function(event){
    event.preventDefault();
    var div = $(this).attr('href');
    overlay.fadeIn(400,
        function(){
            $(modalImgSize)
                .css('display', 'flex')
                .animate({opacity: 1}, 200);
        });
    //scrollLock()
});
closeModalImgSize.click( function(){
    modalImgSize
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                overlay.fadeOut(400);
            }
        );
    //scrollUnlock()
});