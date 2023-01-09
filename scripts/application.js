// get the form
let form = document.getElementById("apply_for_order_form");

// validate entered price

price_validity = false;

const price = document.getElementById('price');

price.addEventListener('input', function() {
	if (price.value > 0 && price.value < 10000000) {
		this.classList.remove('error');
		price_validity = true;
	} else {
		this.classList.add('error');
		price_validity = false;
		this.setCustomValidity("Navrhovaná cena by se měla pohybovat od 0 do 10000000");
		this.reportValidity();
	}
});

// if price is not valid than prevent sending it to server

form.addEventListener('submit', function(event) {
	if(!price_validity) {
		event.preventDefault();
	}
});