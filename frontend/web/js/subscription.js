$('.submit_letter').on('click', function (e) {
    e.preventDefault();

    let form = $('form.newsletter_subscription');
    $.ajax({
        type: "POST",
        url: '/pages/subscription',
        data: form.serialize(),
        success: function (data) {
            if(data) {
                $('.newsletter_block').addClass('hide');
                $('.thenks_block').removeClass('hide');
            }
        }
    });
});

$('.submit_thanks').on('click', function (e) {
    e.preventDefault();

    location.reload();
});