function initAccumulationProgress() {
	// контейнер для графика накопительной скидки
	let container = document.querySelector('.js-accumulation-progress');
	if (!container) {
		return false;
	}
	// Координаты контейнера для вычисления на сколько надо подвинуть ползунок
	let rectContainer = container.getBoundingClientRect();

	// Сколько потратил клиент в магазине - идет с бека
	let totalMoney = container.getAttribute('data-total-money');
	console.log(totalMoney);
	// Активная линия
	let progressLine = container.querySelector('.js-progress-line');

	// Все уровни скидок
	let accumulationPoint = container.querySelectorAll('.js-accumulation-point');

	//активная скидка - порядковый номер
	let currentAccumulationPoint;

	// сколько потрачено для достижения текущего уровня и сколько до следующего
	let startAccumulationPoint = 0;
	let endAccumulationPoint;

	// Скидка уже больше не будет - достигнут предел
	if ( +totalMoney > getNumber(accumulationPoint[accumulationPoint.length - 1].getAttribute('data-money') ) ) {

		// Закрашиваем пройденные уровни и текущий
		for ( let i = 0; i < accumulationPoint.length; i++ ) {
			accumulationPoint[i].classList.add('active');
		}

		//активная скидка - порядковый номер
		currentAccumulationPoint = accumulationPoint.length;

		// растояние от левого края до элемента - активного уровня скидки и контейнера
		let rectAccumulationPoint = accumulationPoint[currentAccumulationPoint-1].getBoundingClientRect();
		let rectContainer = container.getBoundingClientRect();

		// ширина от левого края контейнера до активного уровня скидки
		let left = rectAccumulationPoint.left - rectContainer.left;

		// двигаем ползунок
		progressLine.style.width = left + 'px';
	}
	// промежуточные уровни скидки
	else {
		for (let i = 0; i < accumulationPoint.length; i++) {
			let accumulationPointMoney = getNumber(accumulationPoint[i].getAttribute('data-money'));

			// если потрачено меньше уровня, то не зайдет в проверку,
			// остануться данный предыдущего цикла с предыдущий уровня, он же и будет текущим
			if ( +totalMoney < accumulationPointMoney  ) {
				//активная скидка - порядковый номер
				currentAccumulationPoint = i;

				// Вычисляем рамки денежные между уровнями (текущим и следующим, где будем заполнять линию)
				if ( i === 0 ) {
					endAccumulationPoint = getNumber(accumulationPoint[i].getAttribute('data-money'));

					// растояние от левого края до элемента - активного уровня скидки
					let rectAccumulationPoint = accumulationPoint[currentAccumulationPoint].getBoundingClientRect();

					// Полоска от 0 до первого уровня скидки
					let widthStep = rectAccumulationPoint.left - rectContainer.left;

					// Формула для вычисления на сколько надо подвинуть ползунок
					let activeWidthStep = ( +totalMoney / (endAccumulationPoint / 100) ) * (widthStep / 100);

					// двигаем ползунок
					progressLine.style.width = activeWidthStep + 'px';

				} else {
					startAccumulationPoint = getNumber(accumulationPoint[i-1].getAttribute('data-money'));
					endAccumulationPoint = getNumber(accumulationPoint[i].getAttribute('data-money'));

					// Вычисляем на сколько надо подвинуть до текущего уровня
					// растояние от левого края до элемента - активного уровня скидки
					let rectAccumulationPoint = accumulationPoint[currentAccumulationPoint-1].getBoundingClientRect();
					let widthToCurrentStep = rectAccumulationPoint.left - rectContainer.left;

					// Сколько надо потратить денег, что бы пройти уровень
					let maneyAccumulationPoint = endAccumulationPoint - startAccumulationPoint;

					// полоска от текущего уровня до следующего
					let rectAccumulationNextPoint = accumulationPoint[currentAccumulationPoint].getBoundingClientRect();
					let widthToNextStep = rectAccumulationNextPoint.left - rectContainer.left;
					let currentStepWidth = widthToNextStep - widthToCurrentStep;

					// Формула для вычисления на сколько надо подвинуть ползунок
					let activeWidthStep = ( ( +totalMoney - startAccumulationPoint ) / (maneyAccumulationPoint / 100) ) * (currentStepWidth / 100) + widthToCurrentStep;

					// двигаем ползунок
					progressLine.style.width = activeWidthStep + 'px';
				}

				break;

			} else if ( +totalMoney === accumulationPointMoney ) {
				//активная скидка - порядковый номер
				currentAccumulationPoint = i+1;
			}
		}

		// Закрашиваем пройденные уровни и текущий
		for ( let i = 0; i < currentAccumulationPoint; i++ ) {
			accumulationPoint[i].classList.add('active');
		}
	}

	// Удаляет из строки не числа и возвращает число
	function getNumber(num) {
		return Number(num.replace(/[^0-9\.]+/g,""));
	}
}

initAccumulationProgress();

window.addEventListener('resize', initAccumulationProgress);