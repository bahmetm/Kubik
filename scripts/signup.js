// get the form
let form = document.getElementById("signup_worker_finish_form");

let all_elements_user_validity = false;
let all_elements_worker_validity = false;

// get tab that was opened by user

const loadedPageForm = document.URL.split('#')[1];

switch (loadedPageForm) {
  case 'sign_up_user_form':
    tabLeft();
    break;
  case 'sign_up_worker_form':
    tabRight();
    break;
}

// if user has open left tab with sign up for user type of account

function tabLeft() {
  // turn of html validation
  document.getElementById('sign_up_selector_underline').classList.remove('nojs');

  // change styles
  document.getElementById('sign_up_selector_underline').style = 'right: none';

  // send input data to variables

  userElements = {
    'user_full_name': false,
    'user_email': false,
    'user_password': false,
    'user_password_repeat': false
  };

  const user_form = document.getElementById('sign_up_user_form');
  const user_full_name = document.getElementById('user_full_name'); 
  const user_email = document.getElementById('user_email'); 
  const user_password = document.getElementById('user_password'); 
  const user_password_repeat = document.getElementById('user_password_repeat'); 

  // validate input data

  let user_full_name_validity = /^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$/.test(user_full_name.value);
  let user_full_name_len_validity = /^.{0,100}$/.test(user_full_name.value);
  if (user_full_name_validity && user_full_name_len_validity) {
    userElements['user_full_name'] = true;
  } else {
    userElements['user_full_name'] = false;
  }

  let user_email_validity = /^[\w-\.]+@[\w-]+\.[a-z]+$/.test(this.value);
  let user_email_len_validity = /^.{0,100}$/.test(this.value);
  if (user_email_validity && user_email_len_validity) {
    userElements['user_email'] = true;
  } else {
    userElements['user_email'] = false;
  }

  user_full_name.addEventListener('input', function() {
    let user_full_name_validity = /^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$/.test(this.value);
    let user_full_name_len_validity = /^.{0,100}$/.test(this.value);
    if (user_full_name_validity && user_full_name_len_validity) {
      this.classList.remove('error');
      userElements['user_full_name'] = true;
      checkUserForm(userElements);
    } else {
      this.classList.add('error');
      userElements['user_full_name'] = false;
      checkUserForm(userElements);
      
      this.setCustomValidity("Jméno nesmí obsahovat speciální znaky");
      this.reportValidity();
    }
  });

  user_email.addEventListener('input', function() {
    let user_email_validity = /^[\w-\.]+@[\w-]+\.[a-z]+$/.test(this.value);
    let user_email_len_validity = /^.{0,100}$/.test(this.value);
    if (user_email_validity && user_email_len_validity) {
      this.classList.remove('error');
      userElements['user_email'] = true;
      checkUserForm(userElements);
    } else {
      this.classList.add('error');
      userElements['user_email'] = false;
      checkUserForm(userElements);
      
      this.setCustomValidity("E-mail musí obsahovat pouze latinská písmena, @ a tečku");
      this.reportValidity();
    }
  });

  user_password.addEventListener('input', function() {
    let user_password_validity = /^.{6,20}$/.test(this.value);
    if (user_password_validity) {
      this.classList.remove('error');
      userElements['user_password'] = true;
      checkUserForm(userElements);
    } else {
      this.classList.add('error');
      userElements['user_password'] = false;
      checkUserForm(userElements);
      
      this.setCustomValidity("Heslo musí obsahovat 6 až 20 znaků");
      this.reportValidity();
    }
  });

  user_password_repeat.addEventListener('input', function() {
    let user_password_repeat_validity = user_password_repeat.value == user_password.value;
    if (user_password_repeat_validity) {
      this.classList.remove('error');
      userElements['user_password_repeat'] = true;
      checkUserForm(userElements);
    } else {
      this.classList.add('error');
      userElements['user_password_repeat'] = false;
      checkUserForm(userElements);
      
      this.setCustomValidity("Hesla musí být identická");
      this.reportValidity();
    }
  });

  // check if all elements is valid and if not prevent sending data to server

  user_form.addEventListener('submit', function(event) {
    if (!all_elements_user_validity) {
      event.preventDefault();
    }
  });
}


// if user has open right tab with sign up for worker type of account

function tabRight() {
  // turn of html validation
  document.getElementById('sign_up_selector_underline').classList.remove('nojs');

  // change styles
  document.getElementById('sign_up_selector_underline').style = 'right: 0';

  // send input data to variables

  workerElements = {
    'worker_full_name': false,
    'worker_email': false,
    'worker_phone': false,
    'worker_password': false,
    'worker_password_repeat': false
  };

  const worker_form = document.getElementById('sign_up_worker_form');
  const worker_full_name = document.getElementById('worker_full_name'); 
  const worker_email = document.getElementById('worker_email'); 
  const worker_phone = document.getElementById('worker_phone'); 
  const worker_password = document.getElementById('worker_password'); 
  const worker_password_repeat = document.getElementById('worker_password_repeat'); 

  // validate input data

  let worker_full_name_validity = /^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$/.test(worker_full_name.value);
  let worker_full_name_len_validity = /^.{0,100}$/.test(worker_full_name.value);
  if (worker_full_name_validity && worker_full_name_len_validity) {
    workerElements['worker_full_name'] = true;
  } else {
    workerElements['worker_full_name'] = false;
  }

  let worker_email_validity = /^(?=.{5,100}$)[\w-\.]+@[\w-]+\.[a-z]+$/.test(worker_email.value);
  let worker_email_len_validity = /^.{0,100}$/.test(worker_email.value);
  if (worker_email_validity && worker_email_len_validity) {
    workerElements['worker_email'] = true;
  } else {
    workerElements['worker_email'] = false;
  }

  worker_full_name.addEventListener('input', function() {
    let worker_full_name_validity = /^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$/.test(this.value);
    let worker_full_name_len_validity = /^.{0,100}$/.test(this.value);
    if (worker_full_name_validity && worker_full_name_len_validity) {
      this.classList.remove('error');
      workerElements['worker_full_name'] = true;
      checkWorkerForm(workerElements);
    } else {
      this.classList.add('error');
      workerElements['worker_full_name'] = false;
      checkWorkerForm(workerElements);
      
      this.setCustomValidity("Jméno nesmí obsahovat speciální znaky");
      this.reportValidity();
    }
  });

  worker_email.addEventListener('input', function() {
    let worker_email_validity = /^(?=.{5,100}$)[\w-\.]+@[\w-]+\.[a-z]+$/.test(this.value);
    let worker_email_len_validity = /^.{0,100}$/.test(this.value);
    if (worker_email_validity && worker_email_len_validity) {
      this.classList.remove('error');
      workerElements['worker_email'] = true;
      checkWorkerForm(workerElements);
    } else {
      this.classList.add('error');
      workerElements['worker_email'] = false;
      checkWorkerForm(workerElements);
      
      this.setCustomValidity("E-mail musí obsahovat pouze latinská písmena, @ a tečku");
      this.reportValidity();
    }
  });

  worker_phone.addEventListener('input', function() {
    let worker_phone_validity = /^[0-9]{9}$/.test(this.value);
    if (worker_phone_validity) {
      this.classList.remove('error');
      workerElements['worker_phone'] = true;
      checkWorkerForm(workerElements);
    } else {
      this.classList.add('error');
      workerElements['worker_phone'] = false;
      checkWorkerForm(workerElements);
      
      this.setCustomValidity("Telefonní číslo musí obsahovat 9 znaků bez zvláštních znaků");
      this.reportValidity();
    }
  });

  worker_password.addEventListener('input', function() {
    let worker_password_validity = /^.{6,20}$/.test(this.value);
    if (worker_password_validity) {
      this.classList.remove('error');
      workerElements['worker_password'] = true;
      checkWorkerForm(workerElements);
    } else {
      this.classList.add('error');
      workerElements['worker_password'] = false;
      checkWorkerForm(workerElements);
      
      this.setCustomValidity("Heslo musí obsahovat 6 až 20 znaků");
      this.reportValidity();
    }
  });

  worker_password_repeat.addEventListener('input', function() {
    let worker_password_repeat_validity = worker_password_repeat.value == worker_password.value;
    if (worker_password_repeat_validity) {
      this.classList.remove('error');
      workerElements['worker_password_repeat'] = true;
      checkWorkerForm(workerElements);
    } else {
      this.classList.add('error');
      workerElements['worker_password_repeat'] = false;
      checkWorkerForm(workerElements);
      
      this.setCustomValidity("Hesla musí být identická");
      this.reportValidity();
    }
  });
  
  // check if all elements is valid and if not prevent sending data to server

  worker_form.addEventListener('submit', function(event) {
    if (!all_elements_worker_validity) {
      event.preventDefault();
    }
  });
}

// check all element validity from list and display result in one variable for user account input data

function checkUserForm(elementsList) {
  for(var key in elementsList) {
		if (elementsList[key] == true) {
			all_elements_user_validity = true;
		} else {
			all_elements_user_validity = false;
			break;
		}
	}
}

// check all element validity from list and display result in one variable for worker account input data

function checkWorkerForm(elementsList) {
  for(var key in elementsList) {
		if (elementsList[key] == true) {
			all_elements_worker_validity = true;
		} else {
			all_elements_worker_validity = false;
			break;
		}
	}
}


