var open_modal = $('.js-open-modal-call');
var close = $('.modal__close--call, #overlay');
var modal = $('.modal--call');

open_modal.click( function(event){
    event.preventDefault();
    var div = $(this).attr('href');
    overlay.fadeIn(400,
        function(){
            $(modal)
                .css('display', 'flex')
                .animate({opacity: 1}, 200);
            $('form.auxiliary_form').show().trigger('reset');
            $('.reserve-success-text').remove();
        });
    scrollLock()
});
close.click( function(){
    modal
        .animate({opacity: 0}, 200,
            function(){
                $(this).css('display', 'none');
                overlay.fadeOut(400);
            }
        );
    scrollUnlock()
});

$('.modal__close, #overlay').on('click', function () {
  $('.modal')
    .animate({opacity: 0}, 200,
      function(){
        $(this).css('display', 'none');
        overlay.fadeOut(400);
      }
    );
  scrollUnlock()
});