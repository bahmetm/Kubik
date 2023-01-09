<?php

require_once('php/boot.php');

unauthorized_check();
user_check();

$_SESSION["token"] = md5(uniqid(mt_rand(), true));

?>

<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main_style.css">

	<title>Make new order</title>
</head>
<body>
	<div class="wrapper">
		<header>
			<div class="header-wrapper">
				<img src="media/logo.png" alt="logo" class="logo">
				<nav class="header-nav">
					<a href="main_user.php">Objednávky</a>
					<a href="account_user.php">Osobní účet</a>
				</nav>
			</div>
			<div class="theme_wrapper">
				<button name="dark_theme" id="dark_theme">Změnit téma</button>
			</div>
		</header>
		<div class="content-wrapper">
			<main>
				<div class="form-wrapper">
					<div id="form_header">
						<h1>Objednávka</h1>
					</div>
					<form class="login_form" id="new_order_form" enctype="multipart/form-data" action="php/new_order.php" method="POST">
						<input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
						<div class="form_input_container">
							<div class="label_container"><label for="username">Celé jméno</label></div>
							<input type="text" placeholder="Jméno Příjmení" pattern="/^[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|\s]+[^\[\]\&\*\+\<\=\>\:\;\^\%\'\/\{\}\|]*$" value="<?php if (isset($_SESSION['username'])) echo $_SESSION['username']; ?>" name="username" id="username" required>
						</div>
						
						<div class="form_input_container">
							<div class="label_container"><label for="phone">Telefonní číslo</label></div>
							<input type="tel" placeholder="XXXXXXXXX" name="phone" id="phone" pattern=".{6,20}" value="<?php if (isset($_SESSION['phone'])) echo $_SESSION['phone']; ?>" required>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="area">Okres práce</label></div>
							<select name="area" id="area" required>
								<option value="">Praha</option>
								<option value="Prague 1" <?php if (isset($_SESSION['area'])) echo $_SESSION['area'] == 'Prague 1' ? "checked" : "" ?>>Praha 1</option>
								<option value="Prague 2" <?php if (isset($_SESSION['area'])) echo $_SESSION['area'] == 'Prague 2' ? "checked" : "" ?>>Praha 2</option>
								<option value="Prague 3" <?php if (isset($_SESSION['area'])) echo $_SESSION['area'] == 'Prague 3' ? "checked" : "" ?>>Praha 3</option>
								<option value="Prague 4" <?php if (isset($_SESSION['area'])) echo $_SESSION['area'] == 'Prague 4' ? "checked" : "" ?>>Praha 4</option>
								<option value="Prague 5" <?php if (isset($_SESSION['area'])) echo $_SESSION['area'] == 'Prague 5' ? "checked" : "" ?>>Praha 5</option>
								<option value="Prague 6" <?php if (isset($_SESSION['area'])) echo $_SESSION['area'] == 'Prague 6' ? "checked" : "" ?>>Praha 6</option>
								<option value="Prague 7" <?php if (isset($_SESSION['area'])) echo $_SESSION['area'] == 'Prague 7' ? "checked" : "" ?>>Praha 7</option>
								<option value="Prague 8" <?php if (isset($_SESSION['area'])) echo $_SESSION['area'] == 'Prague 8' ? "checked" : "" ?>>Praha 8</option>
								<option value="Prague 9" <?php if (isset($_SESSION['area'])) echo $_SESSION['area'] == 'Prague 9' ? "checked" : "" ?>>Praha 9</option>
								<option value="Prague 10" <?php if (isset($_SESSION['area'])) echo $_SESSION['area'] == 'Prague 10' ? "checked" : "" ?>>Praha 10</option>
								<option value="" disabled="disabled">Bude k dispozici později</option>
							</select>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="date">Datum a čas</label></div>
							<input type="date" min="2022-12-05" max="2032-12-05" name="date" id="date" value="<?php if (isset($_SESSION['date'])) echo $_SESSION['date']; ?>" required>
						</div>

						<div class="form_input_container" id="form_input_container_checkbox">
							<div class="label_container"><label>Typ vozidla</label></div>
							<div class="checkbox_wrapper" id="radio_wrapper">
								<div>
									<input class="car_radio" type="radio" name="car" value="container" id="container" checked>
									<label class="checkbox_label" for="container" <?php if (isset($_SESSION['car']))
										echo $_SESSION['car'] == 'container' ? "checked" : ""; ?>>Kontejner</label>
								</div>
								<div>
									<input class="car_radio" type="radio" name="car" value="dump" id="dump">
									<label class="checkbox_label" for="dump" <?php if (isset($_SESSION['car'])) echo $_SESSION['car'] == 'dump' ? "checked" : ""; ?>>Sklápěčka</label>
								</div>
							</div>
						</div>

						<div class="form_input_container">
							<div class="label_container"><label for="loading">Doplňkové služby</label></div>
							<div>
								<div class="checkbox_wrapper">
									<div>
										<input type="checkbox" name="cleaning" id="cleaning">
										<label class="checkbox_label" for="cleaning" <?php if (isset($_SESSION['cleaning'])) echo $_SESSION['cleaning'] == 'true' ? "checked" : ""; ?>>Úklid</label>
									</div>
									<div>
										<input type="checkbox" name="loading" id="loading">
										<label class="checkbox_label" for="loading" <?php if (isset($_SESSION['loading'])) echo $_SESSION['loading'] == 'true' ? "checked" : ""; ?>>Nakládka</label>
									</div>
								</div>
							</div>
						</div>
						
						<div class="form_input_container">
							<div class="label_container"><label for="description">Popis</label></div>
							<textarea class="description" name="description" id="description" cols="70" placeholder="Popis" required><?php if (isset($_SESSION['description'])) echo $_SESSION['description']; ?></textarea>
						</div>
						
						<div class="form_input_container">
							<div class="label_container"><label for="image">Fotografie</label></div>
							<input class="input_image" type="file" accept="image/png, image/gif, image/jpeg" name="image" id="image" required>
							<label for="image" class="input_image_label"><span>Vybrat soubor (png, jpg, jpeg)</span></label>
						</div>
	
						<div class="form_input_container">
							<button class="submit button_container" id="make_order">Uložit</button>
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
	<script src="scripts/new_order.js"></script>
</body>
</html>