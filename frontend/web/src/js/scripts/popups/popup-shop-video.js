var openModalShopVideo = $('.js-open-modal-shop-video');
var closeModalShopVideo = $('.modal__close--shop-video, #overlay');
var modalShopVideo = $('.modal--shop-video');

openModalShopVideo.click( function(event){
    event.preventDefault();
    var div = $(this).attr('href');
    overlay.fadeIn(400,
        function(){
            $(modalShopVideo)
                .css('display', 'flex')
                .animate({opacity: 1}, 200);
        });
    scrollLock();
});
closeModalShopVideo.click( function(){
    modalShopVideo
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                overlay.fadeOut(400);
            }
        );
    scrollUnlock();
});

var openModalShopVideo2 = $('.js-open-modal-shop-video2');
var closeModalShopVideo2 = $('.modal__close--shop-video2, #overlay');
var modalShopVideo2 = $('.modal--shop-video2');

openModalShopVideo2.click( function(event){
    event.preventDefault();
    var div = $(this).attr('href');
    overlay.fadeIn(400,
        function(){
            $(modalShopVideo2)
                .css('display', 'flex')
                .animate({opacity: 1}, 200);
        });
    scrollLock();
});
closeModalShopVideo2.click( function(){
    modalShopVideo2
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                overlay.fadeOut(400);
            }
        );
    scrollUnlock()
});

var openModalShopVideo3 = $('.js-open-modal-shop-video3');
var closeModalShopVideo3 = $('.modal__close--shop-video3, #overlay');
var modalShopVideo3 = $('.modal--shop-video3');

openModalShopVideo3.click( function(event){
    event.preventDefault();
    var div = $(this).attr('href');
    overlay.fadeIn(400,
        function(){
            $(modalShopVideo3)
                .css('display', 'flex')
                .animate({opacity: 1}, 200);
        });
    scrollLock()
});
closeModalShopVideo3.click( function(){
    modalShopVideo3
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                overlay.fadeOut(400);
            }
        );
    scrollUnlock()
});