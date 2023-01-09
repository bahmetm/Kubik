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

if (!isset($_POST['username']) || !isset($_POST['phone']) || !isset($_POST['area']) || !isset($_POST['date']) || !isset($_POST['car']) || !isset($_POST['description']) || !isset($_FILES["image"])) {
	$_SESSION['message'] = $unset_field_in_form;
	header('Location: ../new_order.php');
	exit();
}

// send input data to variables

$username = clearData($_POST['username']);
$description = clearData($_POST['description']);

$image = $_FILES['image'];
$phone = $_POST['phone'];
$area = $_POST['area'];
$car = $_POST['car'];

$date = date($_POST['date']);

$container = ($car == 'container') ? 1 : 0;

$cleaning = isset($_POST['cleaning']) ? 1 : 0;
$loading = isset($_POST['loading']) ? 1 : 0;

$_SESSION['username'] = $username;
$_SESSION['phone'] = $phone;
$_SESSION['area'] = $area;
$_SESSION['date'] = $_POST['date'];
$_SESSION['car'] = $car;
$_SESSION['description'] = $description;
$_SESSION['image'] = $image;

// validate input data

$fields_validity = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

	if(empty($phone)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Zadejte telefonní číslo";
	}
	
	if(!preg_match($phone_regex, $phone)) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Zadejte skutečne telefonní číslo";
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

	if($date < date('Y-m-d')) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Vyberte si budoucí datum";
	}

	if($date > date('Y-m-d', strtotime('+12 months'))) {
		$fields_validity = false;
		$_SESSION['username_message'] = "Vyberte datum v průběhu roku";
	}
	
	if (!$fields_validity) {
		header('Location: ../new_order.php');
		exit();
	}
}

// validate input image

$path = 'uploads/' . time() . '_' . $_FILES['image']['name'];
if (!move_uploaded_file($_FILES['image']['tmp_name'], '../' . $path)) {
	$_SESSION['message'] = $image_send_error;
	header('Location: ../new_order.php');
	exit();
}

// if there is already the same order, than send error

if ($stmt = $con->prepare('SELECT id FROM orders WHERE username = ? AND phone = ? AND area = ? AND date = ? AND container = ? AND cleaning = ? AND loading = ? AND description = ? AND image = ?')) {
	$stmt->bind_param('ssssiiiss', $username, $phone, $area, $date, $container, $cleaning, $loading, $description, $path);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {

		$_SESSION['message'] = $order_already_exists;
		header('Location: ../new_order.php');
		exit();
	// if all data valid send it to database to create new order
	} else {
		if($stmt = $con->prepare('INSERT INTO orders (username, phone, area, date, container, cleaning, loading, description, image, creator, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)')) {
			$user_creator = $_SESSION['user']['id'];
			$status = 1;
			$stmt->bind_param('ssssiiissii', $username, $phone, $area, $date, $container, $cleaning, $loading, $description, $path, $user_creator, $status);
			$stmt->execute();
			unset($_SESSION['username']);
			unset($_SESSION['phone']);
			unset($_SESSION['area']);
			unset($_SESSION['date']);
			unset($_SESSION['car']);
			unset($_SESSION['description']);
			unset($_SESSION['image']);
			header('Location: ../main_user.php');
			exit();
		} else {
			echo ('error');
		}
	}
	// close connection to database
	$stmt->close();
} else {
	echo 'Could not prepare statement!';
}

?>


