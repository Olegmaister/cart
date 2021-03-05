// Документация по ренжу - https://refreshless.com/nouislider/
// Небольшой туториал - https://www.youtube.com/watch?v=NSq3Yh2tVQM

// elem.noUiSlider.on('change', function (values) {
// 	console.log(values); // массив с значением из ренжа
// 	console.log(elem.noUiSlider); // обьект с его методами - можно посмотреть какие есть
// });

// elem.noUiSlider.on('update', function (values, handle) {
// 	someElem.innerHTML = parseInt(values[handle]);
// });

// console.log(elem.noUiSlider.get()); // метод - получает данные из ренжа


// Ренж цены в каталоге
// initFilterPriceRange();
// function initFilterPriceRange() {
// 	var filterPriceRange = document.querySelector('.js-filter-price');
//
// 	if ( filterPriceRange ) {
// 		// Берем все настройки с data атрибутов, куда они попадают с админки
// 		var valueMin = +filterPriceRange.getAttribute('data-value-min');
// 		var valueMax = +filterPriceRange.getAttribute('data-value-max');
// 		var step = +filterPriceRange.getAttribute('data-step');
// 		var min = +filterPriceRange.getAttribute('data-min');
// 		var max = +filterPriceRange.getAttribute('data-max');
//
// 		noUiSlider.create(filterPriceRange, {
// 			start: [valueMin, valueMax],
// 			connect: true,
// 			range: {
// 				'min': min,
// 				'max': max
// 			},
// 			step: step
// 		});
//
// 		var priceValues = [
// 			document.querySelector('.js-filter-price-min'),
// 			document.querySelector('.js-filter-price-max')
// 		];
//
// 		filterPriceRange.noUiSlider.on('update', function (values, handle) {
// 			priceValues[handle].innerHTML = parseInt(values[handle]);
// 		});
// 	}
// }

