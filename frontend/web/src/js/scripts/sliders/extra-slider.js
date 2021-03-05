// Слайдер - "Вы смотрели товары"
var sliderWatchedGoods = {
	slider: '.js-slider-watched-goods',
	slides: '.product-card-col',
	arrowPrev: '.js-slider-watched-goods-arrows .js-slider-arrows-prev',
	arrowNext: '.js-slider-watched-goods-arrows .js-slider-arrows-next',
	maxSlide: 4
};
initExtraSlider(sliderWatchedGoods);


// Слайдер - "Покупатели так же смотрят"
var sliderAlsoWatching = {
	slider: '.js-slider-also-watching',
	slides: '.product-card-col',
	arrowPrev: '.js-slider-also-watching-arrows .js-slider-arrows-prev',
	arrowNext: '.js-slider-also-watching-arrows .js-slider-arrows-next',
	maxSlide: 4
};
initExtraSlider(sliderAlsoWatching);

//Слайдер личного кабинета, вкладка "Только для вас"
var sliderOnlyForYou = {
	slider: '.js-slider-only-for-you',
	slides: '.product-card-col',
	arrowPrev: '.js-slider-only-for-you-arrows .js-slider-arrows-prev',
	arrowNext: '.js-slider-only-for-you-arrows .js-slider-arrows-next',
	maxSlide: 3
};
initExtraSlider(sliderOnlyForYou);


var sliderOnlyForYouLook = {
	slider: '.js-slider-only-for-you-look',
	slides: '.product-card-col',
	arrowPrev: '.js-slider-only-for-you-look-arrows .js-slider-arrows-prev',
	arrowNext: '.js-slider-only-for-you-look-arrows .js-slider-arrows-next',
	maxSlide: 3
};
initExtraSlider(sliderOnlyForYouLook);



// Слайдеры в табах,
// начинаемсо второго nth-child, потому что первый элемент в выборке не слайдер
var sliderTabs1 = {
	slider: '.js-tab-slider-wrap:nth-child(2) .js-tab-slider',
	slides: '.js-tab-slider-wrap:nth-child(2) .product-card-col',
	arrowPrev: '.js-tab-slider-wrap:nth-child(2) .js-tab-slider-prev',
	arrowNext: '.js-tab-slider-wrap:nth-child(2) .js-tab-slider-next',
	maxSlide: 4
};
initExtraSlider(sliderTabs1);

var sliderTabs2 = {
	slider: '.js-tab-slider-wrap:nth-child(3) .js-tab-slider',
	slides: '.js-tab-slider-wrap:nth-child(3) .product-card-col',
	arrowPrev: '.js-tab-slider-wrap:nth-child(3) .js-tab-slider-prev',
	arrowNext: '.js-tab-slider-wrap:nth-child(3) .js-tab-slider-next',
	maxSlide: 4
};
initExtraSlider(sliderTabs2);

var sliderTabs3 = {
	slider: '.js-tab-slider-wrap:nth-child(4) .js-tab-slider',
	slides: '.js-tab-slider-wrap:nth-child(4) .product-card-col',
	arrowPrev: '.js-tab-slider-wrap:nth-child(4) .js-tab-slider-prev',
	arrowNext: '.js-tab-slider-wrap:nth-child(4) .js-tab-slider-next',
	maxSlide: 4
};
initExtraSlider(sliderTabs3);


var sliderTabs4 = {
	slider: '.js-tab-slider-wrap:nth-child(5) .js-tab-slider',
	slides: '.js-tab-slider-wrap:nth-child(5) .product-card-col',
	arrowPrev: '.js-tab-slider-wrap:nth-child(5) .js-tab-slider-prev',
	arrowNext: '.js-tab-slider-wrap:nth-child(5) .js-tab-slider-next',
	maxSlide: 4
};

initExtraSlider(sliderTabs4);


function initExtraSlider(settings) {
	// слайдер и слайды
	var slider = document.querySelector(settings.slider);
	if (!slider) return false;

	var slide = slider.querySelectorAll(settings.slides);

	// стрелки
	var arrowPrev = document.querySelector(settings.arrowPrev);
	// дизейблим стрелку "предыдущий" слайд в начале
	arrowPrev.classList.add('is-disable');
	var arrowNext = document.querySelector(settings.arrowNext);

	// параметры для вычислений
	var numberActiveSlide;
	if (window.innerWidth > 1023) {
		numberActiveSlide = settings.maxSlide;
	} else {
		numberActiveSlide = 2;
	}

	var numberSlide = slide.length;
	var position = 0;

	arrowNext.addEventListener('click', function () {

		arrowPrev.classList.remove('is-disable');

		if ( position === (numberSlide - numberActiveSlide) ) {
			return false;
		}

		var translateX = getNumber(slider.style.transform);
		slider.style.transform = 'translateX(-' + (translateX + (slider.offsetWidth / numberActiveSlide)) + 'px)';
		position += 1;

		// добавляем некликабельность стрелке
		if ( position === (numberSlide - numberActiveSlide) ) {
			this.classList.add('is-disable');
		}
	});

	arrowPrev.addEventListener('click', function () {

		arrowNext.classList.remove('is-disable');

		if (position === 0) {
			return false;
		}

		var translateX = getNumber(slider.style.transform);

		slider.style.transform = 'translateX(-' + (translateX - (slider.offsetWidth / numberActiveSlide)) + 'px)';
		position -= 1;

		// добавляем некликабельность стрелке
		if (position === 0) {
			this.classList.add('is-disable');
		}
	});

	// вычисляем или нужны стрелки
	appendArrow();
	function appendArrow() {
		// показываем стрелки, а ниже опять их скрываем если надо
		arrowPrev.style.display = 'block';
		arrowNext.style.display = 'block';

		if (window.innerWidth > 1023) {
			if (slide.length <= settings.maxSlide) {
				arrowPrev.style.display = 'none';
				arrowNext.style.display = 'none';
			}
		} else {
			if (slide.length <= 2) {
				arrowPrev.style.display = 'none';
				arrowNext.style.display = 'none';
			}
		}
	}


	// перерисовка слайдера
	window.addEventListener('resize', function() {
		// перерисовываем с расчетом ширины новых карточек + на сколько карточек прокручено
		slider.style.transform = 'translateX(0px)';
		position = 0;
		arrowPrev.classList.add('is-disable');
		arrowNext.classList.remove('is-disable');

		//кол-во слайдов, смотрим в сss
		if (window.innerWidth > 1023) {
			numberActiveSlide = settings.maxSlide;
		} else {
			numberActiveSlide = 2;
		}

		// вычисляем или нужны стрелки при ресайзе
		appendArrow();
	});

	// свайп табов
	var eventTouch = null;

	slider.addEventListener('touchstart', function (e) {
		eventTouch = e;

		this.addEventListener('touchmove', listenAxis);
		function listenAxis(e) {
			if (eventTouch) {
				if (e.touches[0].pageX - eventTouch.touches[0].pageX < 0) {
					arrowNext.click();
				} else if (e.touches[0].pageX - eventTouch.touches[0].pageX > 0) {
					arrowPrev.click();
				}
			}
			this.removeEventListener('touchmove', listenAxis);
		}

		this.addEventListener('touchend', listenTouchend);
		function listenTouchend() {
			eventTouch = null;
			this.removeEventListener('touchend', listenTouchend);
		}
	});

	// для выделения числа из css свойства
	function getNumber(num) {
		return Number(num.replace(/[^0-9\.]+/g,""));
	}
}