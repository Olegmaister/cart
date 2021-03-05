initRequiredField();

function initRequiredField() {
	var requiredInput = $('.field-input');

	for (var i = 0; i < requiredInput.length; i++) {
		checkValue(requiredInput.eq(i));
	}

	requiredInput.on('focus', function() {
		$(this).closest('.field ').find('.js-field-required').fadeOut(0);
		$(this).closest('.b-field ').find('.js-field-required').fadeOut(0);
	});

	requiredInput.on('blur', function() {
		var that = this;
		setTimeout(function () {
			checkValue(that);
		}, 50);
	});
	
	
	function checkValue(elem) {
		if ( $(elem).val() !== '' ) {
			$(elem).closest('.field ').find('.js-field-required').fadeOut(0);
			$(elem).closest('.b-field ').find('.js-field-required').fadeOut(0);
		}
		else {
			$(elem).closest('.field ').find('.js-field-required').fadeIn(0);
			$(elem).closest('.b-field ').find('.js-field-required').fadeIn(0);
		}
	}
}