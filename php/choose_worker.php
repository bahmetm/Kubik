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

// check if all data was sent

if (isset($_POST["worker_id"])) {
	$worker = $_POST['worker_id'];
	$order = $_POST['order_id'];
}

// if all data validated update order with executor and change status

if ($stmt = $con->prepare('UPDATE `orders` SET `executor` = ?, status = ? WHERE id = ?')) {
	$status = 3;
	$stmt->bind_param('ssi', $worker, $status, $order);
	$stmt->execute();
	header('Location: ../main_user.php');
	exit();
} else {
	echo 'Could not prepare statement!';
}


?>