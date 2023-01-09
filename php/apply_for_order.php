<?php

// connect to database and global variables
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

// check if price was sent

if (!isset($_POST['price'])) {
	$_SESSION['message'] = $unset_field_in_form;
	header('Location: ../main_worker.php');
	exit();
}

// validating price

$price = clearData($_POST['price']);
$order_id = $_POST['apply'];

$fields_validity = true;

$_SESSION['price'] = $price;

if (isset($_POST["apply"])) {
	if(empty($price)) {
		$fields_validity = false;
		$_SESSION['message'] = "Zadejte cenu";
	}

	if($price < 0) {
		$fields_validity = false;
		$_SESSION['message'] = "Cena musí být kladné číslo";
	}

	if($price > 10000000) {
		$fields_validity = false;
		$_SESSION['message'] = "Cena musí být nižší než 10000000";
	}

	if (!$fields_validity) {
		header('Location: ../main_user.php');
		exit();
	}
}

// if price validated send application to database

if ($stmt = $con->prepare('INSERT INTO applications (`order`, `account`, price) VALUES (?, ?, ?)')) {
	$stmt->bind_param('ssi', $order_id, $_SESSION['user']['id'], $price);
	$stmt->execute();
	if ($stmt = $con->prepare('UPDATE orders SET status = ? WHERE id = ?')) {
		$status = 2;
		$stmt->bind_param('is', $status, $order_id);
		$stmt->execute();
	}
	header('Location: ../main_worker.php');
	exit();
} else {
	echo 'Could not prepare statement!';
}


?>