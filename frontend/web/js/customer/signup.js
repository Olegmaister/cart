let registerConfirmData = {
  '_csrf-backend': $('meta[name="csrf-token"]').attr("content")
}

$(document).ready(function () {


  $('.js-submit-recovery').on('click', function () {

    var $yiiform = $('#js-form-recovery');

    $.ajax({
      method: $yiiform.attr('method'),
      url: '/' + currentLang() +'/customer/reset/request',
      data: $yiiform.serializeArray(),
      dataType: 'json',
      'success': function (data) {

      },
      'error': function (response) {

      }
    });


  });


  // регистрация пользователя
  checkRegistrationForm();

  function checkRegistrationForm() {
    // Кнопка для регистрации, если ее нет на странице то выходим сразу из функции
    var btnRegistrationForm = document.querySelector('.js-btn-event-registration');
    if (!btnRegistrationForm) {
      return false;
    }

    // Форма регистрации
    var form = document.querySelector('#js-form-registration');

    // Инпуты
    var username = document.querySelector('#signupform-username');
    var lastname = document.querySelector('#signupform-lastname');
    var phone = document.querySelector('#signupform-phone');
    var password = document.querySelector('#signupform-password');
    var repeatpassword = document.querySelector('#signupform-repeatpassword');


    /**=============================================================================*
     *  Предаврительная работа с телефонами - НАЧАЛО
     * */
    // подставляем в номер код страны
    listenerPhoneInput(phone, form);

    // функция для подставки номера страны
    function listenerPhoneInput(input, wrapper) {
      if (!input) {
        return false;
      }

      input.addEventListener('focus', function () {
        // Подставляем код страны в инпут телефона
        if (this.value.indexOf(findPhoneCode(wrapper)) === -1) {
          this.value = findPhoneCode(wrapper) + this.value;
        }

        mask_for_ua(phone, '.field-signupform-phone');
      });
    }

    // Вычислаем код телефона страны, он есть в разметке виджета
    function findPhoneCode(wrapper) {
      var selectedCountryLi = wrapper.querySelector('.iti__active[data-dial-code] .iti__dial-code');
      if (selectedCountryLi) {
        var phoneCode = selectedCountryLi.textContent;
        return phoneCode;
      }
    }

    setTimeout(function () {
      mask_for_ua(phone, '.field-signupform-phone');
    }, 1000);

    function mask_for_ua(input, parent) {
      var flag = document.querySelector(parent + ' [aria-activedescendant="iti-item-ua"]');

      if (flag) {
        $(input).mask("+380 99 999 99 99");
      } else {
        $(input).unmask();
      }
    }

    /**
     *  Предаврительная работа с телефонами - КОНЕЦ
     *==============================================================================*/


    // checkbox disable email field for register form
    $('#no-email').change(function () {
      const $fields = $('#signupform-email, #orderform-email, #customerform-email');
      $fields.removeClass('has-error').attr('disabled', function (_, attr) {
        return !attr
      });
      $fields.next().text('');
      $fields.parent().next().toggle();
    });

    /**=============================================================================*
     *  Валидация после нажатия кнопки для регистрации - НАЧАЛО
     * */
    btnRegistrationForm.addEventListener('click', function () {

      var $yiiform = $('#js-form-registration');
      const data = $yiiform.serializeArray();
      let invalid = false;

      $.each(data, function (k, v) {
        const $input = $('input[name="' + v.name + '"]');
        const $formGroup = $input.closest('.form-group');
        const $errorMsg = $formGroup.find('.help-block');

        $input.removeClass('has-error');

        if ($input.val() === '') {
          $input.addClass('has-error');
          $errorMsg.text(_tr('required'));
          invalid = true;
        }
      });

      if (invalid) {
        return;
      }


      var param = $('meta[name="csrf-param"]').attr("content");
      var token = $('meta[name="csrf-token"]').attr("content");


      $.ajax({
        method: $yiiform.attr('method'),
        url: '/' + currentLang() + '/customer/signup/signup',
        data: data,
        dataType: 'json',
        'success': function (data) {
          const $firstName = $('#signupform-username');
          const $lastName = $('signupform-lastname');
          const $email = $('#signupform-email');
          const $phone = $('#signupform-phone');
          const $password = $('#signupform-password');
          const $passwordConfirm = $('#signupform-repeatpassword');

          if (data.success) {

            let url;

            // если указан email
            if ($email.val()) {
              url = '/' + currentLang() + '/registration-confirm/send-email';
              registerConfirmData['email'] = $email.val();
            } else {
              url = '/' + currentLang() + '/registration-confirm/send-sms';
              registerConfirmData['phone'] = $phone.val().replace(/\s+/g, '');
            }

            $.post(url, registerConfirmData, function (res) {
              if (res.result) {
                $('#js-form-registration').hide();
                $('#js-confirm-registration').show().find('.text-roboto span').text(registerConfirmData['email'] ? 'email' : _tr('sms'));
              }
            });

          } else {
            if (data.errors.password) {
              $password.addClass('has-error');
              $password.next().text(data.errors.password);
            }
            if (data.errors.email) {
              $email.addClass('has-error');
              $email.next().text(data.errors.email[0]);
            }
            if (data.errors.phone) {
              $phone.addClass('has-error');
              $phone.closest('.form-group').find('.help-block').text(data.errors.phone[0]);
            }
            if (data.message) {
              $yiiform.attr('data-message', data.message);
            }
          }
        },
        'error': function (response) {

        }
      });
    });
    /**
     *  Валидация после нажатия кнопки для регистрации - КОНЕЦ
     *=============================================================================**/
  }


  //авторизация пользователя
  checkAuthForm();

  function checkAuthForm() {
    // Кнопка для авторизации, если ее нет на странице то выходим сразу из функции
    var btnAuthForm = document.querySelector('.js-btn-event-auth');
    if (!btnAuthForm) {
      return false;
    }

    // Форма регистрации
    var form = document.querySelector('#js-form-auth');

    // Инпуты
    var phone = document.querySelector('#loginform-phone');
    var email = document.querySelector('#loginform-email');
    var password = document.querySelector('#loginform-password');

    /**============================================================================*
     *  Предаврительная работа с телефоном - НАЧАЛО
     * */
    // подставляем в номер код страны
    listenerPhoneInput(phone, form);

    // функция для подставки номера страны
    function listenerPhoneInput(input, wrapper) {
      if (!input) {
        return false;
      }

      input.addEventListener('focus', function () {
        // Подставляем код страны в инпут телефона
        if (this.value.indexOf(findPhoneCode(wrapper)) === -1) {
          this.value = findPhoneCode(wrapper) + this.value;
        }

        mask_for_ua(phone, '.field-loginform-phone');
      });
    }

    // Вычислаем код телефона страны, он есть в разметке виджета
    function findPhoneCode(wrapper) {
      var selectedCountryLi = wrapper.querySelector('.iti__active[data-dial-code] .iti__dial-code');
      if (selectedCountryLi) {
        var phoneCode = selectedCountryLi.textContent;
        return phoneCode;
      }
    }

    setTimeout(function () {
      mask_for_ua(phone, '.field-loginform-phone');
    }, 1000);

    function mask_for_ua(input, parent) {
      var flag = document.querySelector(parent + ' [aria-activedescendant="iti-item-ua"]');

      if (flag) {
        $(input).mask("+380 99 999 99 99");
      } else {
        $(input).unmask();
      }
    }

    /**
     *  Предаврительная работа с телефонами - КОНЕЦ
     *==============================================================================*/


    if (btnAuthForm) {
      btnAuthForm.addEventListener('click', function () {

        // Удаляем сообщения об ошибках, что бы проверить заново
        // form.classList.remove('form-is-empty');
        // form.classList.remove('form-error-email');
        // form.classList.remove('form-empty-phone');
        // form.classList.remove('form-empty-user');
        // form.classList.remove('form-error-phone-password');
        // form.classList.remove('form-error-email-password');
        // password.classList.remove('has-error');
        // phone.classList.remove('has-error');
        // email.classList.remove('has-error');
        $('input').removeClass('has-error');


        var $yiiform = $('#js-form-auth');

        $.ajax({
          method: $yiiform.attr('method'),
          url: '/' + currentLang() + '/customer/login/login',
          data: $yiiform.serializeArray(),
          dataType: 'json',
          'success': function (data) {
            const $password = $('#loginform-password');

            if (data.success) {
              window.location.replace(data.redirect);
            } else {
              if (data.errors.password) {
                $password.addClass('has-error');
                $password.next().text(data.errors.password);
              }
              if (data.message) {
                $yiiform.attr('data-message', data.message);
              }
            }

            // if ( data['success'] ) {
            //     window.location.replace(data['redirect']);
            // } else {
            //     //тут ошибки
            //     if (data) {
            //         // console.log(data);
            //         var errors = ''; // сюда записываем ошибку
            //
            //         if ( data['errors'] ) {
            //             if ( data['errors']['password'] ) {
            //                 if ( data['errors']['password'][0] === 'Необходимо заполнить обязательные поля «».') {
            //                     errors = 'Необходимо заполнить обязательные поля «».';
            //                 }
            //             }
            //             if ( data['errors']['email'] ) {
            //                 if ( data['errors']['email'][0] === 'Значение «» не является правильным email адресом.' ) {
            //                     errors = 'Значение «» не является правильным email адресом.';
            //                 }
            //             }
            //         }
            //
            //         if ( data['message'] ) {
            //             if ( data['message'] === "Пользователь не найден." ) {
            //                 errors = "Пользователь не найден.";
            //             }
            //             if ( data['message'] === "Undefined user or password." ) {
            //                 errors = "Undefined user or password.";
            //             }
            //         }
            //
            //
            //         // Проверка ошибки
            //         switch (errors) {
            //             case 'Необходимо заполнить обязательные поля «».':
            //                 form.classList.add('form-is-empty');
            //                 password.classList.add('has-error');
            //                 if ( !email.value && !phone.value ) {
            //                     email.classList.add('has-error');
            //                     phone.classList.add('has-error');
            //                 }
            //                 break;
            //
            //             case "Пользователь не найден.":
            //                 if ( phone.value ) {
            //                     form.classList.add('form-empty-phone');
            //                     phone.classList.add('has-error');
            //                 } else {
            //                     form.classList.add('form-empty-user');
            //                     email.classList.add('has-error');
            //                     phone.classList.add('has-error');
            //                 }
            //                 break;
            //
            //             case "Undefined user or password.":
            //                 if ( email.value && phone.value ) {
            //                     form.classList.add('form-empty-user');
            //                     email.classList.add('has-error');
            //                     phone.classList.add('has-error');
            //                 } else if ( phone.value ) {
            //                     form.classList.add('form-error-phone-password');
            //                     phone.classList.add('has-error');
            //                     password.classList.add('has-error');
            //                 } else if ( email.value ) {
            //                     form.classList.add('form-error-email-password');
            //                     email.classList.add('has-error');
            //                     password.classList.add('has-error');
            //                 }
            //                 break;
            //
            //             case 'Значение «» не является правильным email адресом.':
            //                 form.classList.add('form-error-email');
            //                 email.classList.add('has-error');
            //                 break;
            //         }
            //     }
            // }
          },
          'error': function (response) {

          }
        });
      });
    }
  }

});

// отправка формы с кодом подтверждения регистрации по смс или email
$('#js-confirm-registration').on('submit', function (e) {
  e.preventDefault();
  let url;
  const $input = $(this).find('input[name="code-confirm"]');
  const isFourDigits = /^\d{4}$/.test($input.val());

  $(this).find('.text-danger').remove();
  $input.removeClass('has-error');

  if (!isFourDigits) {
    $input.addClass('has-error').after('<div class="text-danger">' + _tr('required') + '</div>');
    return;
  }

  registerConfirmData['code'] = +$input.val();

  if (registerConfirmData['email']) {
    url = '/' + currentLang() + '/registration-confirm/confirm-by-email';
  } else {
    url =  '/' + currentLang() + '/registration-confirm/confirm-by-sms';
  }

  $.post(url, registerConfirmData, function (res) {
    if (res.result) {
      document.location.reload();
    } else {
      notify(_tr('wrong-confirm-code'));
    }
  });
});
