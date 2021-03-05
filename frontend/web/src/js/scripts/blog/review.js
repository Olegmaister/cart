var btnAddComment = document.querySelector('.js-btn-add-review');
var btnAddCommentChild = document.querySelector('.js-add-review-child');
var btnAddReview = document.querySelector('.js-add-review');

/*навешиваем события*/

//добавление нового комента
if (btnAddComment) {
  btnAddComment.addEventListener('click', function (e) {
    e.preventDefault();

    var $yiiform = $('#js-add-review');

    var $modalReviewForm = $yiiform.find('.popup-review');
    let $textField = $('#reviewform-text');
    let $nameField = $('#reviewform-name');
    let $rating = $('#reviewform-rating');
    var $errorMessage = $('.js-error-message');
    let text = $textField.val();
    let name = $nameField.val();

    // Если это отзыв на отзыв, то не надо ставить рейтинг,
    // по этому задаем значение по умолчанию
    let rating;
    if ( $('.js-rating').hasClass('no-validation') ) {
      rating = 'no-validation';
    } else {
      rating = $rating.val();
    }

    if (!name || !text || !rating) {

      let errorEmptyFields = $modalReviewForm.attr('data-empty-fields');
      let errorRatingFields = $modalReviewForm.attr('data-rating-field');
      $errorMessage.html( errorEmptyFields );

      if (!name) {
        $nameField.addClass('has-error');
      }

      if (!text) {
        $textField.addClass('has-error');
      }

      if (name && text && !rating) {
        $errorMessage.html( errorRatingFields );
      }

      return false;
    }


    $.ajax({
      method: $yiiform.attr('method'),
      url: $yiiform.attr('action'),
      data: $yiiform.serializeArray(),
      dataType: 'json',
      complete: function () {
        // reset all
        $nameField.val('').removeClass('has-error');
        $textField.val('').removeClass('has-error');
        $errorMessage.html('');
        let currentRating = document.querySelector('.js-rating-star.is-active');
        let inputRating = document.querySelector('.js-rating-input');

        if (currentRating) {
          currentRating.classList.remove('is-active');
        }
        inputRating.value = '';
        $modalReviewForm.hide();
        $('.modal__title').hide();
        $('.popup-success').show();
      },
      'error': function (response) {

      }
    });

  });
}

$('.js-add-review-child').on('click', function () {
  $('.js-rating').addClass('no-validation');
  let id = $(this).data('id');
  $('#reviewform-reviewid').val(id);
  $('.popup-review-rating').hide();
  resetReviewForm();
});

// if(btnAddCommentChild){
//         btnAddCommentChild.addEventListener('click',function(e)
//         {
//                 alert('vbv');
//                 $('#reviewform-reviewid').val($(this).data('id'));
//         });
// }


$('.js-btn-show-review').on('click', function () {

  let page = $(this).data('page');
  let id = $(this).data('id');

  $.ajax({
    method: 'get',
    url: '/blogs/review?page=' + page + '&id=' + id,
    data: {},
    dataType: 'json',
    'success': function (data) {
      $('.journal-one-reviews-items').append(data['view']);
      $('.js-btn-show-review').data('page', page + 1);
      if (!data['button']) {
        $('.js-btn-show-review').css({'display': 'none'});
      }
    },
    'error': function (response) {

    }
  });
});

if (btnAddReview) {
  btnAddReview.addEventListener('click', function (e) {
    $('.popup-review-rating').show();
    $('#reviewform-reviewid').val('');
    resetReviewForm();
  });
}

function resetReviewForm() {
  $('#js-add-review .popup-review, .modal__title').show();
  $('.popup-success').hide();
}



