// get the form
let form = document.getElementById("login_form");

// send input data to variables

let all_elements_validity = false;

let elements = {
	'email': false, 
	'password': false
};

const email = document.getElementById('email');
const password = document.getElementById('password');

// validate input data

email.addEventListener('input', function() {
	let email_validity = /^[\w-\.]+@[\w-]+\.[a-z]+$/.test(this.value);
  let email_len_validity = /^.{0,100}$/.test(this.value);
	if (email_validity && email_len_validity) {
		this.classList.remove('error');
		elements['email'] = true;
		checkForm();
	} else {
		this.classList.add('error');
		elements['email'] = false;
		checkForm();
		this.setCustomValidity("E-mail musí obsahovat pouze latinská písmena, @ a tečku");
		this.reportValidity();
	}
});

password.addEventListener('input', function() {
	let password_validity = /^.{6,20}$/.test(this.value);
	if (password_validity) {
		this.classList.remove('error');
		elements['password'] = true;
		checkForm();
	} else {
		this.classList.add('error');
		elements['password'] = false;
		checkForm();
		this.setCustomValidity("Heslo musí obsahovat 6 až 20 znaků");
		this.reportValidity();
	}
});

// function to check form inputs data and prevent sending it to server if it is not valid

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