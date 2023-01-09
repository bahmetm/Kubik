<?php

// define authorization data to connect to database

require_once 'boot.php';

unauthorized_check();
worker_check();

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

// check if all data was sent

if (!isset($_FILES["image"])) {
	header('Location: ../finish_signup.php');
	exit();
}

if (!isset($_POST['area'])) {
	header('Location: ../finish_signup.php');
	exit();
}

if (!isset($_POST['car'])) {
	header('Location: ../finish_signup.php');
	exit();
}

if (!isset($_POST['description'])) {
	header('Location: ../finish_signup.php');
	exit();
}

// give all input data variables

$image = $_FILES['image'];
$area = $_POST['area'];
$car = $_POST['car'];
$description = clearData($_POST['description']);

$container = ($car == 'contaner') ? 1 : 0;

$cleaning = isset($_POST['cleaning']) ? 1 : 0;
$loading = isset($_POST['loading']) ? 1 : 0;

// send input data to session variables

$_SESSION['image'] = $image;
$_SESSION['area'] = $area;
$_SESSION['car'] = $car;
$_SESSION['cleaning'] = $cleaning;
$_SESSION['loading'] = $loading;
$_SESSION['description'] = $description;

$fields_validity = true;

// validate input data

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	if (!is_uploaded_file($_FILES['image']['tmp_name'])) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Vložte obrázek";
	}

	if (($_FILES['image']['size'] >= 2097152) || ($_FILES["image"]["size"] == 0)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Vložte obrázek až do 2 MB";
	}

	if (!in_array(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION), $image_allowed_extensions)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Vložte obrázek až do 2 MB";
	}

	if(!in_array($area, $area_allowed)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Vyberte oblast města";
	}

	if(($car != 'container') && ($car != 'dump')) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Vyberte požadované auto";
	}

	if($description == "") {
		$fields_validity = false;
		$_SESSION['username_message'] = "Zadejte popis";
	}
	
	if (!$fields_validity) {
		header('Location: ../finish_signup.php');
		exit();
	}
}

// validate input image

$path = 'uploads/' . time() . '_' . $_FILES['image']['name'];
if (!move_uploaded_file($_FILES['image']['tmp_name'], '../' . $path)) {
	$_SESSION['message'] = $image_send_error;
	header('Location: ../finish_signup.php');
	exit();
}

// if all data is valid send it to database

if ($stmt = $con->prepare('UPDATE accounts SET image = ?, area = ?, container = ?, cleaning = ?, loading = ?, description = ? WHERE email = ?')) {
	$stmt->bind_param('ssiiiss', $path, $area, $container, $cleaning, $loading, $description, $_SESSION['email']);
	$stmt->execute();
	
	unset($_SESSION['username']);
	unset($_SESSION['phone']);
	unset($_SESSION['image']);
	unset($_SESSION['area']);
	unset($_SESSION['car']);
	unset($_SESSION['cleaning']);
	unset($_SESSION['loading']);
	unset($_SESSION['description']);
	session_destroy();

	header('Location: ../login.php');
} else {
	echo ('error');
}

// close connection with database

$stmt->close();

$con->close();

?>