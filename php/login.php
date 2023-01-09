<?php

// define authorization data to connect to database

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

if (!isset($_POST['email']) || !isset($_POST['password'])) {
	$_SESSION['message'] = $unset_field_in_form;
	header('Location: ../login.php');
	exit();
}

// send data to variables

$email = clearData($_POST['email']);
$password = $_POST['password'];

$_SESSION['email'] = $email;

$fields_validity = true;

// validation input data

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if(empty($email)) {
		$fields_validity = false;
	}
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$fields_validity = false;
	}
	
	if (!$fields_validity) {
		$_SESSION['message'] = $incorrect_fields;
		header('Location: ../login.php');
		exit();
	}
}

// if all input data is valid login user with data for certain account

if ($stmt = $con->prepare('SELECT id, username, email, password, worker, phone, image, area, container, cleaning, loading, description FROM accounts WHERE email = ?')) {
	$stmt->bind_param('s', $email);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		$stmt->bind_result($id, $username, $email, $password_of_account, $worker, $phone, $image, $area, $container, $cleaning, $loading, $description);
		$stmt->fetch();
		if (password_verify($password, $password_of_account)) {
			// if account has type worker and already has finished signin up
			if ($worker) {
				if (isset($area)) {
					$_SESSION['user'] = [
						"id" => $id,
						"username" => $username,
						"email" => $email,
						"worker" => $worker,
						"phone" => $phone,
						"image" => $image,
						"area" => $area,
						"container" => $container,
						"cleaning" => $cleaning,
						"loading" => $loading,
						"description" => $description
					];
					header('Location: ../main_worker.php');
				// if account has type worker and has not already finished signin up
				} else {
					$_SESSION['user'] = [
						"id" => $id,
						"username" => $username,
						"email" => $email,
						"worker" => $worker,
						"phone" => $phone,
					];
					header('Location: ../finish_signup.php');
				}
			// if account has type user
			} else {
				$_SESSION['user'] = [
					"id" => $id,
					"username" => $username,
					"email" => $email,
					"worker" => $worker
				];
				header('Location: ../main_user.php');
			}
		// if password is incorrect
		} else {
			$_SESSION['message'] = $incorrect_email_or_password;
			header('Location: ../login.php');
			exit();
		}
	// if email is incorrect
	} else {
		$_SESSION['message'] = $incorrect_email_or_password;
		header('Location: ../login.php');
	}
	// close connection to database
	$stmt->close();
} else {
	echo 'Could not prepare statement!';
}

// close connection to database
$con->close();

?>