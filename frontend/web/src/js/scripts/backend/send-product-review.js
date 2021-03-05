// Product detail comment - for COMMIT
initProductReview();

function initProductReview() {
	// Если отзыв на отзыв, то подставляем id отзыва
	let reviewId = '';
	let productId;

	// модалка
	var $modalReview = $('.modal--review');

	// форма в модалке
	var $modalReviewForm = $('.js-product-review-form');

	// Поле для вывода ошибки
	var $errorMessage = $('.js-error-message');

	// Поля формы
	let $textField = $('.js-product-review-form textarea[name="comment"]');
	let $nameField = $('.js-product-review-form input[name="name"]');
	let $phoneField = $('.js-product-review-form input[name="phone"]');
	let $rating = $('.js-product-review-form .js-rating-input');

	if ($phoneField[0]) {
		$phoneField[0].addEventListener('keyup', function(){
			// валидируем добавление букв, при добавлении сразу удаляем добавленый
			this.value = this.value.replace(/[A-Za-zА-Яа-яЁё]/, '');
		});
	}



	// Открываем модалку отзыв на отзыв
	$(document).on('click', '.answer_review', function () {
		$('.js-rating').addClass('no-validation');

		// подставляем id отзыва
		reviewId = $(this).data('review_id');
		// подставляем id товара
		productId = $(this).data('product_id');
		resetRating();
		resetFieldsValue();
		deleteErrorMessages();
	});

	// ткрываем модалку отзыв на товар
	$(document).on('click', '.send__review', function () {
		$('.js-rating').removeClass('no-validation');

		reviewId = '';
		resetRating();
		resetFieldsValue();
		deleteErrorMessages();
	});

    var sendFlag = false;
	// отправляем отзыв - любой
	$(document).on('click', '.js-send-product-review', function () {
		deleteErrorMessages();

		// Данные для отправки формы
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


		// Валидация
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

		var data = {
			"_csrf-frontend": csrfToken,
			product_id: $('.page--product').data('product_id') || productId,
			author: name,
			text: text,
			vote: rating
		};

		// Если reviewId не пустое, то это отзыв на отзыв и
		// передаем id отзыва
		if (reviewId !== '') {
			data.answer_review_id = reviewId;
		}

        // Ставим флаг что-бы повторно не отправить
        if (sendFlag == false) {
        	sendFlag = true;
        } else {
        	return;
        }
		$.ajax({
			type: 'POST',
			url: "/products/set-review",
			data: data
		}).done(function (response) {
			// закрываем мдалку и востанавливаем прокрутку сайта
			// $modalReview.animate({opacity: 0}, 200,
			// 	function(){
			// 		$(this).css('display', 'none');
			// 		overlay.fadeOut(400);
			// 	}
			// );
			// scrollUnlock();
			$modalReview.find('.popup-review').hide();
      $('.popup-success').show();
		});
	});


	// Очищаем выбранный рейтинга
	function resetRating() {
		// Рейтинг
		let currentRating = document.querySelector('.js-rating-star.is-active');
		let inputRating = document.querySelector('.js-rating-input');

		if (currentRating) {
			currentRating.classList.remove('is-active');
		}
		inputRating.value = '';
	}

	// Удаляем ошибки формы и очищаем что было заполнено
	function resetFieldsValue() {
		$nameField.val('');
		$textField.val('');
		$errorMessage.html('');
		$modalReview.find('.popup-review').show();
		$('.popup-success').hide();
	}

	// Удаляем ошибки формы и очищаем что было заполнено
	function deleteErrorMessages() {
		$nameField.removeClass('has-error');
		$textField.removeClass('has-error');
		$errorMessage.html('');
		$('.js-field-required').fadeIn(0)
	}
}
