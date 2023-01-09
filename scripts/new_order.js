// get the form
let form = document.getElementById("new_order_form");

// send input data to variables

let all_elements_validity = false;

let elements = {
	'username': false, 
	'phone': false,
	'area': false,
	'date': false,
	'description': false,
	'image': false
};

const username = document.getElementById('username');
const phone = document.getElementById('phone');
const work_area = document.getElementById('area');
const date = document.getElementById('date');
const comment = document.getElementById('description');
const user_image = document.getElementById('image');

// validate input data

username.addEventListener('input', function() {
	let username_validity = /^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$/.test(username.value);
  let username_len_validity = /^.{0,100}$/.test(username.value);
	if (username_validity && username_len_validity) {
		this.classList.remove('error');
		elements['username'] = true;
		checkForm();
	} else {
		this.classList.add('error');
		elements['username'] = false;
		checkForm();
		this.setCustomValidity("Jméno nesmí obsahovat speciální znaky");
		this.reportValidity();
	}
});

phone.addEventListener('input', function() {
	let phone_validity = /^[0-9]{9}$/.test(this.value);
	if (phone_validity) {
		this.classList.remove('error');
		elements['phone'] = true;
		checkForm();
	} else {
		this.classList.add('error');
		elements['phone'] = false;
		checkForm();
		this.setCustomValidity("Telefonní číslo musí obsahovat 9 znaků bez zvláštních znaků");
		this.reportValidity();
	}
});

area.addEventListener('input', function() {
	if (this.value) {
		this.classList.remove('error');
		elements['area'] = true;
		checkForm();
	} else {
		this.classList.add('error');
		elements['area'] = false;
		checkForm();
		this.setCustomValidity("Vyberte si oblast města s počtem nabízených možností");
		this.reportValidity();
	}
});

date.addEventListener('input', function() {
	let todayDate = new Date(Date.now());
	let nextYearDate = new Date(todayDate);
	nextYearDate = new Date(nextYearDate.setFullYear(nextYearDate.getFullYear() + 1));

	let choosedDate = new Date(this.value);
	
	let date_validity = todayDate <= choosedDate && choosedDate <= nextYearDate;

	if (date_validity) {
		this.classList.remove('error');
		elements['date'] = true;
		checkForm();
	} else {
		this.classList.add('error');
		elements['date'] = false;
		checkForm();
		this.setCustomValidity("Zadejte datum, které není dříve než aktuální datum a ne později než za rokí");
		this.reportValidity();
	}
});

description.addEventListener('input', function() {
	let description_validity = /^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$/.test(description.value);
  let description_len_validity = /^.{0,100}$/.test(description.value);
	// let comment_validity = /^[\w\s.,?!]{0,10}$/.test(this.value);
	if (description_validity && description_len_validity) {
		this.classList.remove('error');
		elements['description'] = true;
		checkForm();
	} else {
		this.classList.add('error');
		elements['description'] = false;
		checkForm();
		this.setCustomValidity("Zadejte popis bez speciálních znaků kromě středníku až do délky 100 znaků");
		this.reportValidity();
	}
});

image.addEventListener('input', function() {
	let allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
	if (allowedExtensions.exec(image.value)) {
		this.nextElementSibling.classList.remove('error');
		elements['image'] = true;
		checkForm();
	} else {
		this.nextElementSibling.classList.add('error');
		elements['image'] = false;
		checkForm();
		this.setCustomValidity("Obrázek až 2 MB");
		this.reportValidity();
	}
});

// check if all data is valid and prevent sending it to server if not

function checkForm() {
	for(var key in elements) {
		if (elements[key] == true) {
			all_elements_validity = true;
		} else {
			all_elements_validity = false;
			break;
		}
	}
}

form.addEventListener('submit', function(event) {
	if(!all_elements_validity) {
		event.preventDefault();
	}
});