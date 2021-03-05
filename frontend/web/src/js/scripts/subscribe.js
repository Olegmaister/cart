$(document).on('click', '.subscribe-btn_js', function () {
    let btn = $(this);
    let type = btn.attr('data-type');
    var email = btn.parents('.subscribe-wrapper_js').find('input').val();
    let form = $('html').attr('data-form');
    $.ajax({
        method: 'POST',
        url: "/add-subscribe",
        data: {
            'type': type,
            'email': email,
            [form]: form
        }
    }).done(function (response) {
        notify(response.msg);
        $('.subscribe-form-input').val('')
    });
})
