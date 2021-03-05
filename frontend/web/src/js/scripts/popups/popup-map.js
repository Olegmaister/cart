var openModalMap = $('.js-open-modal-map');
var closeModalMap = $('.modal__close--map, #overlay');
var modalMap = $('.modal--map');

openModalMap.click( function(event){
    event.preventDefault();
    var div = $(this).attr('href');
    overlay.fadeIn(400,
        function(){
            $(modalMap)
                .css('display', 'flex')
                .animate({opacity: 1}, 200);
        });
    scrollLock()
});
closeModalMap.click( function(){
    modalMap
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                overlay.fadeOut(400);
            }
        );
    scrollUnlock()
});