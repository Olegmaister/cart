

//Модальное видео окно
var btnOpenVideo = document.querySelectorAll('.js-video-modal-open');
var btnCloseVideo = document.querySelector('.js-modal-video-close');

//открытие видео
if(btnOpenVideo.length) {
	(function () {
		for (var i = 0; i < btnOpenVideo.length; i++) {
			btnOpenVideo[i].addEventListener('click', function() {
				scrollLock();
				openVideo(this);
			});
		}
	})();
}

//закрытие по крестику
if (btnCloseVideo) {
	btnCloseVideo.addEventListener('click', function() {
		scrollUnlock();
		closeVideo();
	});
}


document.addEventListener('mouseup', function (event) {
	var body = document.querySelector('body');
	var modalVideo = document.querySelector('.video-modal-window');

	// Закрываем модалку c видео если клик мимо
	if (body.classList.contains('modal-video-is-open')) {
		if (!modalVideo.contains(event.target)) {
			//запускаем прокрутку scroll-lock.js
			scrollUnlock();
			// Закрываем модалку и удаляем видео modal-video.js
			closeVideo();
		}
	}
});

function openVideo(currentTis) {
	var body = document.querySelector('body');
	var idVideo = currentTis.getAttribute('data-video-src');
	var videoFrame = document.querySelector('.js-modal-video-youtube');
	var query = '?rel=0&showinfo=0&autoplay=1';
	var srcVideo = "https://www.youtube.com/embed/" + idVideo + query;

	replaceTag(videoFrame, 'iframe');

	videoFrame = document.querySelector('.js-modal-video-youtube');

	body.classList.add('modal-video-is-open');

	if ( videoFrame.getAttribute('src') === '' ) {
		videoFrame.setAttribute('src', srcVideo);
	}
	else if ( videoFrame.getAttribute('src') === srcVideo ) {
		return false;
	}
	else if ( videoFrame.getAttribute('src') !== srcVideo ) {
		videoFrame.setAttribute('src', srcVideo);
	}
}

function closeVideo() {
	var body = document.querySelector('body');
	var videoFrame = document.querySelector('.js-modal-video-youtube');
	body.classList.remove('modal-video-is-open');
	body.setAttribute('style', '');
	videoFrame.setAttribute('src', '');
}

// переделываем div в iframe
function replaceTag(element, newTagName) {
	// Создаём новый тэг.
	var newTag = document.createElement(newTagName);

	// Вставляем новый тэг перед старым.
	element.parentElement.insertBefore(newTag, element);

	// Переносим в новый тэг атрибуты старого с их значениями.
	for (var i = 0, attrs = element.attributes, count = attrs.length; i < count; ++i)
		newTag.setAttribute(attrs[i].name, attrs[i].value);

	// Переносим в новый тэг все дочерние элементы старого.
	var childNodes = element.childNodes;
	while (childNodes.length > 0)
		newTag.appendChild(childNodes[0]);

	// Удаляем старый тэг.
	element.parentElement.removeChild(element);
}

