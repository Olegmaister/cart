var openModalPageVideos = $('.js-open-modal-page-videos');
var closeModalPageVideos = $('.modal__close--page-videos, #overlay');
var modalPageVideos = $('.modal--page-videos');

openModalPageVideos.click( function(event){
    event.preventDefault();
    var div = $(this).attr('href');
    overlay.fadeIn(400,
        function(){
            $(modalPageVideos)
                .css('display', 'flex')
                .animate({opacity: 1}, 200);
        });
    scrollLock()
});
closeModalPageVideos.click( function(){
    modalPageVideos
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                overlay.fadeOut(400);
            }
        );
    scrollUnlock()
});