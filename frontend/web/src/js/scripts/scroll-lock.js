/**
 *     Блокировака прокрутки при открытии модалок
 **/

// блокируем прокрутку
function scrollLock() {
	var pagePosition = window.scrollY;
	// Если одна модалка открывает другую модалку, то не надо задавать все еще раз
	if ( document.body.classList.contains('scroll-lock') ) {
		return false;
	}

	document.body.classList.add('scroll-lock');
	document.body.dataset.position = pagePosition;
	document.body.style.top = -pagePosition + 'px';
	if ( window.innerWidth > 991) {
		document.body.style.paddingRight = '8px';
	}
}

// востанавливаем прокрутку
function scrollUnlock() {
	var pagePosition = document.body.dataset.position;
	document.body.style.top = '';
	document.body.style.paddingRight = '';
	document.body.classList.remove('scroll-lock');
	window.scroll({top: pagePosition, left: 0});
	document.body.removeAttribute('data-position');
}

