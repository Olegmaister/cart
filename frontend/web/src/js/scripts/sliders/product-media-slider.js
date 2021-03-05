// таб в карточке товара
var initProductMediaSliderButton = document.querySelector('.js-init-product-media-slider');

//Класс на стр - О нас
var initAboutMediaSlider = document.querySelector('.js-init-about-media-slider');

// если есть таб, то вешаем событие
if ( initProductMediaSliderButton ) {
	initProductMediaSliderButton.addEventListener('click', initProductMediaSlider);
}

// если есть класс, то вешаем событие
if ( initAboutMediaSlider ) {
    initProductMediaSlider()
}

// Инициализация слайдера в табе и в модалке
function initProductMediaSlider() {
	var $slider = $('.js-product-media-slider');
	// крестик для закрытия модалки
	var $btnClose = $("<svg class=\"modal-slider-close js-modal-slider-close\" width=\"18\" height=\"18\" viewBox=\"0 0 18 18\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
		"            <path d=\"M15.75 0L18 2.24999L2.25006 17.9999L6.58121e-05 15.7499L15.75 0Z\"></path>\n" +
		"            <path d=\"M0 2.24999L2.24999 2.46558e-06L17.9999 15.7499L15.7499 17.9999L0 2.24999Z\"></path>\n" +
		"        </svg>");

	// Клонируем слайдер и вставляем в конец боди, что бы открывать при клике на слайд
	$('<section class="modal-slider"></section>').appendTo("body");
	$slider.clone().appendTo(".modal-slider")
		.addClass("product-media--modal js-modal-product-media-slider")
		.removeClass('js-product-media-slider');
	$btnClose.appendTo(".modal-slider");

	// Элементы с модального слайдера
	var $modalSlider = $('.js-modal-product-media-slider');
	var $modalVideo = $('.js-modal-product-media-slider .product-media__video');

	// В модальном слайдере все превьюхи видео заменяем на фреймы ютуба
	for(var i = 0; i < $modalVideo.length; i++) {
		var videoId = $modalVideo.eq(i).find('img').attr('data-video-src');
		var srcVideo = "https://www.youtube.com/embed/" + videoId;
		$modalVideo.eq(i).html("<iframe src='' data-src='" + srcVideo + "' class='product-media__video-frame js-modal-slider-video'></iframe>");
	}

	// Настройки слайдера в модалке
	var settingsModalSlider = {
		dots: false,
		fade: false,
		autoplay: false,
		autoplaySpeed: 10000,
		pauseOnFocus: true,
		pauseOnHover: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true
	};

	// Настройки слайдера в табе
	// var settingsSlider = {
	// 	dots: false,
	// 	fade: false,
	// 	autoplay: true,
	// 	autoplaySpeed: 10000,
	// 	pauseOnFocus: true,
	// 	pauseOnHover: true,
	// 	slidesToShow: 2,
	// 	slidesToScroll: 1,
	// 	arrows: true
	// };

	// запуск слайдера в табе
	// $slider.not('.slick-initialized').slick(settingsSlider);

	// Событие для запуска и открытия слайдера на стр Товара
	var imgTab = document.querySelectorAll('.js-product-media-slider .product-media-col');
	if ( imgTab || imgTab.length ) {
		for (var j = 0; j < imgTab.length; j++) {
			imgTab[j].addEventListener('click', openModalSlider);
		}
	}

    // Событие для запуска и открытия слайдера на стр О нас
    var imgAbout = document.querySelectorAll('.js-product-media-slider .p-about-factory-gallery-item');
    if ( imgAbout || imgAbout.length ) {
        for (var a = 0; a < imgAbout.length; a++) {
            imgAbout[a].addEventListener('click', openModalSlider);
        }
    }

	// закрываем модалку по крестику
	var btnCloseModalSlider = document.querySelector('.js-modal-slider-close');
	if ( btnCloseModalSlider ) {
		btnCloseModalSlider.addEventListener('click', closeModalSlider);
	}

	// закрываем модалку по клику на оверлей
	var modalOverlay = document.querySelector('.modal-slider');
	modalOverlay.addEventListener('click', function(e) {
		if (e.target === this) { // клик по оверлею
			closeModalSlider();
		}
	});

	// вызываем когда надо открыть модальный слайдер
	function openModalSlider() {
		// задаем ссылки у видео в слайдере при открытии
		var vidoes = document.querySelectorAll('.js-modal-slider-video');
		if (vidoes || vidoes.length) {
			for(var i = 0; i < vidoes.length; i++) {
				var src = vidoes[i].getAttribute('data-src');
				vidoes[i].setAttribute('src', src);
			}
		}

		// Инициализация слайдера в модалке
		$modalSlider.not('.slick-initialized').slick(settingsModalSlider);

		// Прокрутка к нужному слайду
		var indexElem = getElementIndex(this);
		$modalSlider.slick('slickGoTo', indexElem);

		// Открываем слайдер и морозим прокрутку
		document.body.classList.add('modal-slider--is-open');
		scrollLock();
	}

	// вызываем когда надо закрыть модальный слайдер
	function closeModalSlider() {
		// удаляем ссылку на видео, что бы отключить его при закрытии слайдера
		var vidoes = document.querySelectorAll('.js-modal-slider-video');
		if (vidoes || vidoes.length) {
			for(var i = 0; i < vidoes.length; i++) {
				vidoes[i].setAttribute('src', '');
			}
		}

		// закрываем и запускаем прокрутку
		document.body.classList.remove('modal-slider--is-open');
		scrollUnlock();
	}

	// возвращает порядковый номер в выборке элементов
	function getElementIndex(elem) {
		elem = elem.tagName ? elem : document.querySelector(elem);
		return [].indexOf.call(elem.parentNode.children, elem)
	}

	// отмена события, что бы не создавало тучу слайдеров
	initProductMediaSliderButton.removeEventListener('click', initProductMediaSlider);
}



