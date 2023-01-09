<?php

// define authorization data to connect to database

define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'bahmemak');
define('DATABASE_PASS', 'redEyedRabbit23');
define('DATABASE_NAME', 'bahmemak');

// regex for input data validation

$text_regex = "/^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$/i";
$email_regex = "/^[\w-\.]+@[\w-]+\.[a-z]+$/i";
$phone_regex = "/^[0-9]{9}$/i";
$passord_regex = "/^.{6,20}$/i";

// variables for input data validation

$image_allowed_extensions = array('png', 'jpg', 'jpeg');
$area_allowed = array('Prague 1', 'Prague 2', 'Prague 3', 'Prague 4', 'Prague 5', 'Prague 6', 'Prague 7', 'Prague 8', 'Prague 9', 'Prague 10')
?>