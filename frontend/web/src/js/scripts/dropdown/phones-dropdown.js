initDropDownPhones();

function initDropDownPhones() {
	var dropDownPhones = document.querySelectorAll('.js-phones-dropdown');

	if (dropDownPhones.length) {
		for (var i = 0; i < dropDownPhones.length; i++) {
			dropDownPhones[i].addEventListener('click', dropDown);
		}
	}

	function dropDown() {
		this.classList.toggle('is-open');
	}
}