// initHandleCounter();

function initHandleCounter() {
	var $handleCounter = $('[data-handle-counter]');
	// var $handleButton = $('[data-handle-counter] button');

	for(var i = 0; i < $handleCounter.length; i++) {
		$handleCounter.eq(i).handleCounter({
			minimum: 1,
			maximize: 9999
		});
	}
}