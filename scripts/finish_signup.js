// select the form
let form = document.getElementById("signup_worker_finish_form");

// send input data to variables

let all_elements_validity = false;

let elements = {
	'worker_image': false, 
	'work_area': false,
	'car': false,
	'description': false
};

const worker_image = document.getElementById('worker_image');
const work_area = document.getElementById('area');
const container = document.getElementById('container');
const dump = document.getElementById('dump');
const description = document.getElementById('description');

// validate input data

worker_image.addEventListener('input', function() {
	let allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
	if (allowedExtensions.exec(worker_image.value)) {
		this.nextElementSibling.classList.remove('error');
		elements['worker_image'] = true;
		checkForm();
	} else {
		this.nextElementSibling.classList.add('error');
		elements['worker_image'] = false;
		checkForm();
		this.setCustomValidity("Obrázek až 2 MB");
		this.reportValidity();
	}
});

work_area.addEventListener('input', function() {
	if (this.value) {
		this.classList.remove('error');
		elements['work_area'] = true;
		checkForm();
	} else {
		this.classList.add('error');
		elements['work_area'] = false;
		checkForm();
		this.setCustomValidity("Vyberte si oblast města s počtem nabízených možností");
		this.reportValidity();
	}
});

description.addEventListener('input', function() {
	let description_validity = /^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$/.test(description.value);
  let description_len_validity = /^.{0,100}$/.test(description.value);
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

// funcion to check input data and prevent sending it to server if it is not valid

function checkForm() {
	if (container.checked || dump.checked) {
		elements['car'] = true;
	}
	
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