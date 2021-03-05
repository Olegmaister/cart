initCatalogMenu();

function initCatalogMenu() {
	var mainMenuLi = document.querySelectorAll('.js-cat-menu-li');

	// меняем ширину второго меню на 1 и 2 колонки
	if (mainMenuLi.length) {
		for (var i = 0; i < mainMenuLi.length; i++) {
			mainMenuLi[i].addEventListener('mouseenter', function () {
				var subMenu = this.querySelector('.js-cat-menu-sub');
				var subMenuItem = subMenu.querySelectorAll('.js-cat-menu-link');

				if (subMenuItem.length > 11) {
					subMenu.classList.add('is-two-columns');
				}
			});

			mainMenuLi[i].addEventListener('mouseleave', function () {
				var subMenu = this.querySelector('.js-cat-menu-sub');
				subMenu.classList.remove('is-two-columns');
			});
		}
	}
}

$('.header-cat-menu_sub').parent().addClass('header-cat-menu__item--show-sub');

$(document).on('click', '.js-cat-menu-sub-show', function () {

	//$(this).next().next().toggleClass('is-visible');
	//$(this).toggleClass('toggle');

	if ($(this).next().next().css('display') == 'none') {

		$(this).next().next().slideDown( "fast", function() {});
		$(this).addClass('toggle');

		$(this).closest('.header-cat-menu__item').parent().addClass('toggle');

	} else {

		$(this).next().next().slideUp( "fast", function() {});
		$(this).removeClass('toggle');

		$(this).closest('.header-cat-menu__item').parent().removeClass('toggle');

	}

});