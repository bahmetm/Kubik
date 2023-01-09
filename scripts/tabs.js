document.getElementById("defaultOpen").click();

function openTab(evt, tab) {
  var i, tabcontent, tablinks;

  tabcontent = document.getElementsByClassName("tabs");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
    tabcontent[i].className = tabcontent[i].className.replace(" active", "");
  }

  tablinks = document.getElementsByClassName("tab_links");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  document.getElementById(tab).style.display = "flex";
  document.getElementById(tab).className += " active";
  evt.currentTarget.className += " active";
	if (evt.currentTarget.id == 'defaultOpen') {
		document.getElementById("sign_up_selector_underline").style = "right: none";
	}

	if (evt.currentTarget.id == 'tab_link2') {
		document.getElementById("sign_up_selector_underline").style = "right: 0";
	}

  var form = document.getElementsByClassName('login_form tabs active')[0];

  all_elements_validity = false;

  for (let input of form.elements) {
    input.addEventListener('input', function() {
      let validation_rule = this.dataset.validation_rule;
      let value = this.value;
      
      switch (validation_rule) {
        case 'full_name':
          let name_validity = /[a-zA-Z]{1,20} [a-zA-Z]{1,20}/.test(value);
          if (name_validity) {
            this.classList.remove('error');
            this.classList.add('valid');
            all_elements_validity = true;
          } else {
            this.classList.remove('valid');
            this.classList.add('error');
            all_elements_validity = false;
          }
          break;

        case 'email':
          let email_validity = /^[\w-\.]+@[\w-]+\.[a-z]{1,20}$/.test(value);
          if (email_validity) {
            this.classList.remove('error');
            this.classList.add('valid');
            all_elements_validity = true;
          } else {
            this.classList.remove('valid');
            this.classList.add('error');
            all_elements_validity = false;
          }
          break;

        case 'phone':
          let phone_validity = /[0-9]{9}/.test(value);
          if (phone_validity) {
            this.classList.remove('error');
            this.classList.add('valid');
            all_elements_validity = true;
          } else {
            this.classList.remove('valid');
            this.classList.add('error');
            all_elements_validity = false;
          }
          break;

        case 'password':
          let password_validity = /.{6,20}/.test(value);
          if (password_validity) {
            this.classList.remove('error');
            this.classList.add('valid');
            all_elements_validity = true;
          } else {
            this.classList.remove('valid');
            this.classList.add('error');
            all_elements_validity = false;
          }
          break;

        case 'password_repeat':
          main_password = document.querySelector('.login_form.tabs.active #user_password').value;
          if (value == main_password) {
            this.classList.remove('error');
            this.classList.add('valid');
            all_elements_validity = true;
          } else {
            this.classList.remove('valid');
            this.classList.add('error');
            all_elements_validity = false;
          }
          break;

      }
    });

    form.addEventListener('submit', function(event) {
	    if(!all_elements_validity) {
		    event.preventDefault();
	    }
    });
  }

}
