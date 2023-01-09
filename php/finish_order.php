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

// finish order execution and change status

$order_id = $_POST['finish_order'];

if ($stmt = $con->prepare('UPDATE `orders` SET status = ? WHERE id = ?')) {
	$status = 4;
	$stmt->bind_param('ii', $status, $order_id);
	$stmt->execute();
	header('Location: ../current_orders.php');
	exit();
} else {
	echo 'Could not prepare statement!';
}


?>