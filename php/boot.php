<?php
// starting session
session_start();

// connecting variables

require("config.php");
require("text_fields.php");

// function to clear input data

function clearData($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = str_replace(['\'', '\"'], '', $data);
	$data = strip_tags($data);
	$data = htmlspecialchars($data);
	return $data;
}

// function to check if user with worker account finished signing up

function unfinished_signup_check() {
	if (isset($_SESSION['user'])) {
		if ($_SESSION['user']['worker']) {
			if (!isset($_SESSION['user']['area'])) {
				header('Location: finish_signup.php');
				exit();
			}
		}
	}
}

// function to check if user authorized

function authorized_check() {
	if (isset($_SESSION['user'])) {
		if ($_SESSION['user']['worker']) {
			if (isset($_SESSION['user']['area'])) {
				header('Location: main_worker.php');
				exit();
			}
		} else {
			header('Location: main_user.php');
			exit();
		}
	}
}

// function to check if user unauthorized

function unauthorized_check() {
	if (!isset($_SESSION['user'])) {
		header('Location: login.php');
		exit();
	}
}

// function to check if account is not worker

function user_check() {
	if ($_SESSION['user']['worker']) {
		header('Location: main_worker.php');
		exit();
	}
}

// function to check if account is not user

function worker_check() {
	if (!$_SESSION['user']['worker']) {
		header('Location: main_user.php');
		exit();
	}
}

// connect to mysql database

$con = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// check if connection is fine

if(!$con) {
	die('Cannot connect to database: ' . mysqli_error());
}

