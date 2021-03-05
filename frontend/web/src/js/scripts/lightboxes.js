$( function()

{

    $('.js-open-modal-grid-size').imageLightbox(
        {
            selector:       'id="imagelightbox"',   // string;
            allowedTypes:   'png|jpg|jpeg|gif',     // string;
            animationSpeed: 250,                    // integer;
            preloadNext:    true,                   // bool;            silently preload the next image
            enableKeyboard: true,                   // bool;            enable keyboard shortcuts (arrows Left/Right and Esc)
            quitOnEnd:      false,                  // bool;            quit after viewing the last image
            quitOnImgClick: false,                  // bool;            quit when the viewed image is clicked
            quitOnDocClick: true,                   // bool;            quit when anything but the viewed image is clicked
            onStart:        false,                  // function/bool;   calls function when the lightbox starts
            onEnd:          false,                  // function/bool;   calls function when the lightbox quits
            onLoadStart:    false,                  // function/bool;   calls function when the image load begins
            onLoadEnd:      false                   // function/bool;   calls function when the image finishes loading
        });

});

// $(document).on('click', '.js-open-modal-grid-size', function () {
//     setTimeout(function(){$('#imagelightbox').wrapAll('<div id="imagelightbox" class="imagelightbox-wrap"></div>');}, 1000);
// });