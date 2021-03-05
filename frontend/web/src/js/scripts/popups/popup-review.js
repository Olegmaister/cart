var openModalReview = $('.js-open-modal-review');
var openModalReviewChild = $('.js-open-modal-review-child');
var closeModalReview = $('.modal__close--review, #overlay');
var modalReview = $('.modal--review');

var modalReviewChild = $('.modal--review-child');

openModalReview.on('click', function(){
    overlay.fadeIn(400,
        function(){
            $(modalReview)
                .css('display', 'flex')
                .animate({opacity: 1}, 200);
        });
    scrollLock();
});

openModalReviewChild.on('click', function(){
    overlay.fadeIn(400,
        function(){
            $(modalReviewChild)
                .css('display', 'flex')
                .animate({opacity: 1}, 200);
        });
    scrollLock();
});
closeModalReview.on('click', function(){
    modalReview
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                overlay.fadeOut(400);
            }
        );

    modalReviewChild
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                overlay.fadeOut(400);
            }
        );


    scrollUnlock();
});