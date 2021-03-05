initRating();

function initRating() {
	let rating = document.querySelector('.js-rating');

	// выходим если нет блока с рейтиногом
	if (!rating) {
		return false;
	}

	let stars = rating.querySelectorAll('.js-rating-star');
	let input = rating.querySelector('.js-rating-input');

	// Вешаем на все звезды событие
	for (let i = 0; i < stars.length; i++) {
		stars[i].addEventListener('click', function () {
			// Меняем акивный класс
			let active = rating.querySelector('.js-rating-star.is-active');
			if (active) {
				active.classList.remove('is-active');
			}

			this.classList.add('is-active');

			// Меняем значение в инпуте
			input.value = this.getAttribute('data-vote');
			// console.log(input.value);
		});
	}
}
