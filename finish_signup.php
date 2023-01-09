<?php

require_once('php/boot.php');

authorized_check();
unauthorized_check();

$_SESSION["token"] = md5(uniqid(mt_rand(), true));

?>

<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main_style.css">

	<title>Finish sign up</title>
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
						<h1>Registrace</h1>
					</div>
					<form class="login_form" id="signup_worker_finish_form" enctype="multipart/form-data" action="php/finish_signup.php" method="POST">
						<input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
						<div class="form_input_container"> 
							<div class="label_container"><label for="worker_image">Fotografie</label></div>
							<input class="input_image" type="file" accept="image/png, image/gif, image/jpeg" name="image" id="worker_image" title="hello" required>
							<label for="worker_image" class="input_image_label"><span>Vybrat soubor (png, jpg, jpeg)</span></label>
						</div>
	
						<div class="form_input_container">
							<div class="label_container"><label for="area">Okres práce</label></div>
							<select name="area" id="area" required>
								<option value="">Praha</option>
								<option value="Prague 1">Praha 1</option>
								<option value="Prague 2">Praha 2</option>
								<option value="Prague 3">Praha 3</option>
								<option value="Prague 4">Praha 4</option>
								<option value="Prague 5">Praha 5</option>
								<option value="Prague 6">Praha 6</option>
								<option value="Prague 7">Praha 7</option>
								<option value="Prague 8">Praha 8</option>
								<option value="Prague 9">Praha 9</option>
								<option value="Prague 10">Praha 10</option>
								<option value="" disabled="disabled">Bude k dispozici později</option>
							</select>
						</div>

						<div class="form_input_container" id="form_input_container_checkbox">
							<div class="label_container"><label>Typ vozidla</label></div>
							<div class="checkbox_wrapper" id="radio_wrapper">
								<div>
									<input class="car_radio" type="radio" name="car" value="container" id="container" checked>
									<label class="checkbox_label" for="car">Kontejner</label>
								</div>
								<div>
									<input class="car_radio" type="radio" name="car" value="dump" id="dump">
									<label class="checkbox_label" for="car">Sklápěčka</label>
								</div>
							</div>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="loading">Doplňkové služby</label></div>
							<div>
								<div class="checkbox_wrapper">
									<div>
										<input type="checkbox" name="cleaning" id="cleaning">
										<label class="checkbox_label" for="cleaning">Úklid</label>
									</div>
									<div>
										<input type="checkbox" name="loading" id="loading">
										<label class="checkbox_label" for="loading">Nakládka</label>
									</div>
								</div>
							</div>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="description">Popis</label></div>
							<textarea class="description" name="description" id="description" maxlength="255" cols="70" placeholder="Popis" required></textarea>
						</div>
	
						<div class="form_input_container">
							<button class="submit button_container" id="sign_up">Vytvořit účet</button>
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
	<script src="scripts/finish_signup.js"></script>
</body>
</html>