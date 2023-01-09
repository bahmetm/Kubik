// get the form to not validate
let formToNotValidate = document.querySelectorAll("form")

// disable validation for form
formToNotValidate.forEach(form => {
	form.noValidate = true
});