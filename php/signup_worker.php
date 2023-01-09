<?php

// if all data is valid sent it to server to sign up new user

require_once 'boot.php';

// check the token
if (isset($_POST['token']) && isset($_SESSION['token'])) {
	if ($_POST['token'] !== $_SESSION['token']) {
		// return 403 http status code
		header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
		exit;
	} else {
		// clearing the token to prevent attacks
		unset($_SESSION['token']);
	}
} else {
	// return 403 http status code
	header($_SERVER['SERVER_PROTOCOL'] . ' 403 Forbidden');
	exit;
}

// check if all input data was sent

if (!isset($_POST['username']) || !isset($_POST['email']) || !isset($_POST['phone']) || !isset($_POST['password']) || !isset($_POST['password_repeat'])) {
	$_SESSION['message'] = $unset_field_in_form;
	header('Location: ../signup.php');
	exit();
}

// send input data to variables

$username = clearData($_POST['username']);
$email = clearData($_POST['email']);
$phone = clearData($_POST['phone']);
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];
$worker = 1;

$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['phone'] = $phone;

// validate input data

$fields_validity = true;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if(empty($username)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Zadejte jméno";
	}

	if(strlen($username) > 100) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Jméno musí obsahovat méně než 100 znaků";
	}
	
	if(!preg_match($text_regex, $username)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Zadejte skutečné jméno";
	}

	if(empty($email)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Zadejte email";
	}

	if(strlen($email) > 100) {
		$fields_validity = false;
		$_SESSION['username_message'] = "E-mail musí obsahovat méně než 100 znaků";
	}
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Zadejte skutečný email";
	}

	if(empty($phone)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Zadejte telefonní číslo";
	}
	
	if(!preg_match($phone_regex, $phone)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Zadejte skutečný telefon";
	}

	if(strlen($password) < 6 || strlen($password) > 20) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Heslo musí obsahovat 6 až 20 znaků";
	}
	
	if ($password != $password_repeat) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Hesla se musí shodovat";
	}
	
	if (!$fields_validity) {
		header('Location: ../signup.php#sign_up_worker_form');
		exit();
	}
}

// check if there is same accounts

if ($stmt = $con->prepare('SELECT id, username, email, phone, password FROM accounts WHERE email = ? OR phone = ?')) {
	$stmt->bind_param('ss', $email, $phone);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		$_SESSION['message'] = $account_already_exists;
		header('Location: ../signup.php#sign_up_worker_form');
		exit();
	// if everything is valid send data to server to sign up new worker account
	} else {
		if($stmt = $con->prepare('INSERT INTO accounts (username, email, phone, password, worker) VALUES (?, ?, ?, ?, ?)')) {
			$password = password_hash($password, PASSWORD_DEFAULT);
			$stmt->bind_param('ssssi', $username, $email, $phone, $password, $worker);
			$stmt->execute();
			unset($_SESSION['username']);
			unset($_SESSION['email']);
			unset($_SESSION['phone']);
			header('Location: ../finish_signup.php');
		} else {
			echo ('error');
		}
	}
	$stmt->close();
} else {
	echo 'Could not prepare statement!';
}

$con->close();

?>


