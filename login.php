<?php

require_once('php/boot.php');

// unfinished_signup_check();
authorized_check();

$_SESSION["token"] = md5(uniqid(mt_rand(), true));

?>

<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main_style.css">

	<title>Log in</title>
</head>
<body>
	<div class="wrapper">
		<header>
			<div class="header-wrapper">
				<img src="media/logo.png" alt="logo" class="logo">
			</div>
			
			<div class="theme_wrapper">
				<button name="dark_theme" id="dark_theme">Změnit téma</button>
			</div>
		</header>
		<div class="content-wrapper">
			<main>
				<div class="form-wrapper">
					<div id="form_header">
						<h1>Vítejte</h1>
						<h3>Přihlaste se k používání služby</h3>
					</div>
					<form class="login_form" id="login_form" action="php/login.php" method="POST">
						<input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
						<div class="form_input_container">
							<div class="label_container"><label for="email">E-mail</label></div>
							<input type="email" placeholder="example@abc.cz" maxlength="100" name="email" id="email" value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?>" title="Zadejte svůj e-mail">
						</div>
	
						<div class="form_input_container">
							<div class="label_container"><label for="password">Heslo</label></div>
							<input type="password" placeholder="********" name="password" id="password" title="Zadejte své heslo">
						</div>
	
						<div class="form_input_container">
							<button class="submit button_container" id="log_in">Přihlásit se</button>
						</div>
	
						<div class="form_input_container">
							<a href="signup.php" id="new_sign_up">Vytvořit účet</a>
						</div>
					</form>

					<?php
						if (isset($_SESSION['message'])) {
							echo '<p class="error_message">' . $_SESSION['message'] . '</p>';
						}
            unset($_SESSION['message']);
					?>
				</div>
			</main>
		</div>
	</div>
	
	<script src="scripts/dark_theme.js"></script>
	<script src="scripts/no_validate.js"></script>
	<script src="scripts/login.js"></script>
</body>
</html>