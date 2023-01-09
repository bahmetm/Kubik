<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'bahmemak';
$DATABASE_PASS = 'redEyedRabbit23';
$DATABASE_NAME = 'bahmemak';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password'])) {
	exit('Please fill both the username and password fields!');
}