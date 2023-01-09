<?php

require_once('php/boot.php');

unauthorized_check();
unfinished_signup_check();
worker_check();

$_SESSION["token"] = md5(uniqid(mt_rand(), true));

?>


<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main_style.css">
	<link rel="stylesheet" type="text/css" href="styles/account.css">



	<title>Account</title>
</head>
<body>
	<div class="wrapper">
		<header>
			<div class="header-wrapper">
				<img src="media/logo.png" alt="logo" class="logo">
				<nav class="header-nav">
					<a href="main_worker.php">Najít práci</a>
					<a href="current_orders.php">Aktuální objednávky</a>
					<a href="finished_orders.php">Historie objednávek</a>
					<a href="account.php" id="current_page">Osobní účet</a>
				</nav>
			</div>
			<div class="theme_wrapper">
				<button name="dark_theme" id="dark_theme">Změnit téma</button>
			</div>
		</header>
		<div class="content-wrapper">
			<main class="content">
				<div class="main_label_container">
					<h1>Osobní účet</h1>
				</div>
				<div class="user_data_container">
					<div class="user_photo">
						<img src="<?=$_SESSION['user']['image']?>" alt="Account Image" id="user_photo">
					</div>
					<div class="user_text_data">
						<div class="user_data">
							<span class="user_data_label">ID: </span><span id="user_id"><?=$_SESSION['user']['id']?></span>
						</div>
						<div class="user_data">
							<span class="user_data_label">Jméno a příjmení: </span><span id="user_name"><?=$_SESSION['user']['username']?></span>
						</div>
						<div class="user_data">
							<span class="user_data_label">E-mail: </span><span id="user_email"><?=$_SESSION['user']['email']?></span>
						</div>					
						<div class="user_data">
							<span class="user_data_label">Telefonní číslo: </span><span id="user_phone"><?=$_SESSION['user']['phone']?></span>
						</div>
						<div class="user_data">
							<span class="user_data_label">Okres práce: </span><span id="user_phone"><?=$_SESSION['user']['area']?></span>
						</div>
						<div class="user_data">
							<span class="user_data_label">Typ vozidla: </span><span id="user_phone"><?=$_SESSION['user']['container'] ? "Kontejner" : "Sklápěčka"?></span>
						</div>
						<div class="user_data">
							<span class="user_data_label">Úklid: </span><span id="user_phone"><?=$_SESSION['user']['cleaning'] ? "Ano" : "Ne"?></span>
						</div>
						<div class="user_data">
							<span class="user_data_label">Nakládka: </span><span id="user_phone"><?=$_SESSION['user']['loading'] ? "Ano" : "Ne"?></span>
						</div>
						<div class="user_data">
							<span class="user_data_label">Popis: </span><span id="user_phone"><?=$_SESSION['user']['description']?></span>
						</div>
					</div>
				</div>
				<form action="php/logout.php" method="POST">
					<input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
					<button class="logout">Logout</button>
				</form>
				<a href="https://drive.google.com/drive/folders/1pyIIwOJExSbg_ZewSuFGjkeVaDCuCzPM?usp=sharing">Doxygen documentace</a>
			</main>
		</div>
	</div>

	
	<script src="scripts/dark_theme.js"></script>
</body>
</html>