<?php

require_once('php/boot.php');

unfinished_signup_check();
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
		<link rel="stylesheet" type="text/css" href="styles/signup_style.css">
		
		<title>Sign up</title>
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
						<h1>Vytvořit účet</h1>
					</div>

					<div class="tabs_wrapper">
						<a class="tab_links" href="#sign_up_user_form" onclick="tabLeft()">Jsem zákazník</a>
						<a class="tab_links" href="#sign_up_worker_form" onclick="tabRight()">Jsem pracovník</a>
					</div>


					<div class="tabs_underline">
						<div class="main_underline"></div>
						<div class="selector_underline nojs" id="sign_up_selector_underline"></div>
					</div>
					
					<form class="login_form tabs" id="sign_up_user_form" action="php/signup_user.php" method="POST">
						<input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
						<input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
						<div class="form_input_container">
							<div class="label_container"><label for="user_full_name">Celé jméno</label></div>
							<input type="text" name="username" placeholder="Jméno Příjmení" id="user_full_name" maxlength="100" pattern="/^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$" value="<?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?>" title="Zadejte své skutečné jméno" value="<?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?>" required>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="user_email">E-mail</label></div>
							<input type="email" name="email" placeholder="example@abc.cz" maxlength="100" id="user_email" pattern="^[\w-\.]+@[\w-]+\.[a-z]+$" value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?>" title="Zadejte svůj e-mail" required>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="user_password">Heslo</label></div>
							<input type="password" name="password" placeholder="********" class="password" id="user_password" pattern=".{6,20}" title="Heslo by mělo obsahovat 6 až 20 znaků" required>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="user_password_repeat">Potvrdit heslo</label></div>
							<input type="password" name="password_repeat" placeholder="********" class="password_repeat" id="user_password_repeat" title="Znovu zadejte své heslo" required>
						</div>

						<div class="form_input_container">
							<button class="submit" id="user_sign_up_button">Přihlásit se</button>
						</div>
					</form>
				
					<form class="login_form tabs" id="sign_up_worker_form" action="php/signup_worker.php" method="POST">
						<input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
						<div class="form_input_container">
							<div class="label_container"><label for="worker_full_name">Celé jméno</label></div>
							<input type="text" name="username" placeholder="Jméno Příjmení" id="worker_full_name" maxlength="100" pattern="/^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$" title="Zadejte své skutečné jméno" value="<?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?>" required>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="worker_email">E-mail</label></div>
							<input type="email" name="email" placeholder="example@abc.cz" id="worker_email" pattern="^[\w-\.]+@[\w-]+\.[a-z]+$" maxlength="100" value="<?php if (isset($_SESSION['email'])) echo $_SESSION['email']; ?>" title="Zadejte svůj e-mail" required>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="worker_phone">Telefonní číslo</label></div>
							<input type="tel" name="phone" placeholder="XXXXXXXXX" id="worker_phone" pattern="[0-9]{9}" value="<?php if (isset($_SESSION['phone'])) echo $_SESSION['phone']; ?>" title="Zadejte své telefonní číslo bez zvláštních znaků" required>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="worker_password">Heslo</label></div>
							<input type="password" name="password" placeholder="********" class="password" id="worker_password" pattern=".{6,20}" title="Heslo by mělo obsahovat 6 až 20 znaků" required>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="worker_password_repeat">Potvrdit heslo</label></div>
							<input type="password" name="password_repeat" placeholder="********" class="password_repeat" id="worker_password_repeat" title="Znovu zadejte své heslo" required>
						</div>

						<div class="form_input_container">
							<button class="submit" id="sign_up_worker_next">Další</button>
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
	
	<script src="scripts/no_validate.js"></script>
	<script src="scripts/signup.js"></script>
	<script src="scripts/dark_theme.js"></script>
</body>
</html>