<?php

require_once('php/boot.php');

unauthorized_check();
user_check();


$_SESSION["token"] = md5(uniqid(mt_rand(), true));

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

$orders_per_page = 8;

$orders = null;
$num_orders = null;

$accounts = null;

$current_page_name = pathinfo(__FILE__, PATHINFO_BASENAME);

if($stmt = $con->prepare('SELECT COUNT(*) FROM orders WHERE creator = ?')) {
	$creator = $_SESSION['user']['id'];
	$stmt->bind_param('s', $creator);

	$stmt->execute();
	$stmt->bind_result($count);

	$stmt->fetch();
	$num_orders = $count;
	$stmt->close();
} else {
	echo 'Could not prepare statement!';
}

$num_pages = ceil($num_orders / $orders_per_page);

if ($page <= 0) {
	$page = 1;
} elseif ($page > $num_pages) {
	$page = $num_pages;
}


if ($stmt = $con->prepare('SELECT * FROM orders WHERE creator = ? ORDER BY date DESC LIMIT ?, ?')) {
	$current_page = ($page - 1) * $orders_per_page;
	$creator = $_SESSION['user']['id'];
	$stmt->bind_param('sii', $creator, $current_page, $orders_per_page);
	$stmt->execute();
	$result = $stmt->get_result();
	// $stmt->store_result();
	$orders = $result->fetch_all(MYSQLI_ASSOC);

	
	$stmt->close();
} else {
	echo 'Could not prepare statement!';
}

?>

<!DOCTYPE html>
<html lang="cs">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main_style.css">
	<link rel="stylesheet" type="text/css" href="styles/main_customer_style.css">

	<title>Main customer</title>
</head>
<body>
	<div class="wrapper">
		<header>
			<div class="header-wrapper">
				<img src="media/logo.png" alt="logo" class="logo">
				<nav class="header-nav">
					<a href="main_user.php" id="current_page">Objednávky</a>
					<a href="account_user.php">Osobní účet</a>
				</nav>
			</div>
			<div class="theme_wrapper">
				<button name="dark_theme" id="dark_theme">Změnit téma</button>
			</div>
		</header>
		<div class="content-wrapper">
			<main class="content">
				<div class="main_label_container"><h1>Objednávky</h1></div>
				<div class="list order_list">

					<?php foreach($orders as $order): ?>
						<div class="order list_element" id="<?=$order['id']?>">
						<div class="order_info list_element_info">
							<p class="adress list_element_label"><?=$order['area']?></p>
							<div class="date_container"><p>Datum: </p><p class="date"><?=date("Y.m.d", strtotime($order['date']))?></p></div>
							<div class="comment_container"><p>Komentář: </p><p class="comment"><?=$order['description']?></p></div>
							<div class="order_id_container"><p>Číslo objednávky: #</p><p class="order_id"><?=$order['id']?></p></div>
						</div>
						<div class="button_container">
							<form method="POST">
								<?php
								switch ($order['status']){
									case 0:
										$class_button = "canceled";
										$name_button = "order_info";
			          		$text_button = $cancelled_order_text;
										break;
									case 1:
										$class_button = "in_process";
										$name_button = "order_info";
			          		$text_button = $in_process_order_text;
										break;
									case 2:
										$class_button = "choose_worker";
										$name_button = "view_applications";
			          		$text_button = $waiting_for_choose_order_text;
										break;
									case 4:
										$class_button = "done";
										$name_button = "order_info";
			          		$text_button = $done_order_text;
										break;
									default:
										$class_button = "in_process";
										$name_button = "order_info_with_executor";
			          		$text_button = $in_process_order_text;
										break;
								}
								?>
								<button name="<?=$name_button?>" value="<?=$order['id']?>" class="<?=$class_button?>"><?=$text_button?></button>
							</form>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="form_input_container">
					<a href="new_order.php" id="new_order">Objednat</a>
				</div>
				<?php if (ceil($num_orders / $orders_per_page) > 0): ?>
				<ul class="pagination">
					<?php if ($page > 1): ?>
					<li class="prev"><a href="<?=$current_page_name?>?page=<?php echo $page-1 ?>">Prev</a></li>
					<?php endif; ?>

					<?php if ($page > 3): ?>
					<li class="start"><a href="<?=$current_page_name?>?page=1">1</a></li>
					<li class="dots">...</li>
					<?php endif; ?>

					<?php if ($page-2 > 0): ?><li class="page"><a href="<?=$current_page_name?>?page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
					<?php if ($page-1 > 0): ?><li class="page"><a href="<?=$current_page_name?>?page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

					<li class="currentpage"><a href="<?=$current_page_name?>?page=<?php echo $page ?>"><?php echo $page ?></a></li>

					<?php if ($page+1 < ceil($num_orders / $orders_per_page)+1): ?><li class="page"><a href="<?=$current_page_name?>?page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
					<?php if ($page+2 < ceil($num_orders / $orders_per_page)+1): ?><li class="page"><a href="<?=$current_page_name?>?page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

					<?php if ($page < ceil($num_orders / $orders_per_page)-2): ?>
					<li class="dots">...</li>
					<li class="end"><a href="<?=$current_page_name?>?page=<?php echo ceil($num_orders / $orders_per_page) ?>"><?php echo ceil($num_orders / $orders_per_page) ?></a></li>
					<?php endif; ?>

					<?php if ($page < ceil($num_orders / $orders_per_page)): ?>
					<li class="next"><a href="<?=$current_page_name?>?page=<?php echo $page+1 ?>">Next</a></li>
					<?php endif; ?>
				</ul>
				<?php endif; ?>
			</main>

			<aside class="content">
				<?php
					if(isset($_POST["order_info"])) {
						$choosed_order = array_filter($orders, function ($arr) {
							return $arr['id'] == $_POST['order_info'];
						});
				?>
				<div class="main_label_container"><h1>Informace</h1></div>
				<div class="workers_list list order_info_wrapper">
					<div class="text_order_info">
						<h3>Obecné informace</h3>
						<div class="order_info_container"><p class="order_info_label">Localita: </p><p><?php echo array_values($choosed_order)[0]['area']; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Jméno: </p><p><?php echo array_values($choosed_order)[0]['username']; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Číslo telefonu: </p><p><?php echo array_values($choosed_order)[0]['phone']; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Datum: </p><p><?php echo array_values($choosed_order)[0]['date']; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Typ vozidla: </p><p><?php echo array_values($choosed_order)[0]['container'] ? "Ano" : "Ne"; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Úklid: </p><p><?php echo array_values($choosed_order)[0]['cleaning'] ? "Ano" : "Ne"; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Nakládka: </p><p><?php echo array_values($choosed_order)[0]['loading'] ? "Ano" : "Ne"; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Popis: </p><p title="<?php echo array_values($choosed_order)[0]['description']; ?>"><?php echo array_values($choosed_order)[0]['description']; ?></p></div>
					</div>
					<div class="image_order_info">
						<img src="<?php echo array_values($choosed_order)[0]['image']; ?>">
					</div>
				</div>

				

				<?php } elseif (isset($_POST["order_info_with_executor"])) { ?>

				<?php
						$choosed_order = array_filter($orders, function ($arr) {
							return $arr['id'] == $_POST['order_info_with_executor'];
						});
				?>
				<div class="main_label_container"><h1>Informace</h1></div>
				<div class="workers_list list order_info_wrapper">
					<div class="text_order_info">
						<h3>Obecné informace</h3>
						<div class="order_info_container"><p class="order_info_label">Localita: </p><p><?php echo array_values($choosed_order)[0]['area']; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Jméno: </p><p><?php echo array_values($choosed_order)[0]['username']; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Číslo telefonu: </p><p><?php echo array_values($choosed_order)[0]['phone']; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Datum: </p><p><?php echo array_values($choosed_order)[0]['date']; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Typ vozidla: </p><p><?php echo array_values($choosed_order)[0]['container'] ? "Ano" : "Ne"; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Úklid: </p><p><?php echo array_values($choosed_order)[0]['cleaning'] ? "Ano" : "Ne"; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Nakládka: </p><p><?php echo array_values($choosed_order)[0]['loading'] ? "Ano" : "Ne"; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Popis: </p><p title="<?php echo array_values($choosed_order)[0]['description']; ?>"><?php echo array_values($choosed_order)[0]['description']; ?></p></div>
						<h3>Informace o dodavatele</h3>
						<div class="order_info_container"><p class="order_info_label">Cena: </p><p class="price"><?php echo array_values($choosed_order)[0]['executor']; ?></p></div>
						<div class="order_info_container"><p class="order_info_label">Jméno: </p><p class="executor"><?php echo array_values($choosed_order)[0]['price']; ?></p></div>
					</div>
					<div class="image_order_info">
						<img src="<?php echo array_values($choosed_order)[0]['image']; ?>">
					</div>
				</div>

				<?php } elseif (isset($_POST["view_applications"])) { ?>
					
				<div class="main_label_container"><h1>Vybrat dodavatele</h1></div>
				<div class="workers_list list">
				<?php
						$choosed_order = $_POST['view_applications'];
						if ($stmt = $con->prepare('SELECT * FROM applications WHERE `order` = ?')) {
							$lalala = $choosed_order;
							$stmt->bind_param('s', $lalala);
							$stmt->execute();
							$result = $stmt->get_result();
							// $stmt->store_result();
							$accounts = $result->fetch_all(MYSQLI_ASSOC);
							// print_r($accounts);

							foreach($accounts as $account) {
								if($stmt = $con->prepare('SELECT * FROM accounts WHERE id = ?')) {
									$id_of_applicant = $account['account'];
									$stmt->bind_param('s', $id_of_applicant);
									$stmt->execute();
									$result = $stmt->get_result();
									$applicant = $result->fetch_all(MYSQLI_ASSOC);
				?>
					<div class="worker list_element">
						<div class="worker_info list_element_info">
							<p class="worker_name list_element_label"><?php echo array_values($applicant)[0]['username']; ?></p>
							<div class="price_container"><p>Cena: </p><p class="price"><?= $account['price'];?></p><p> Kč</p></div>
						</div>
						<div class="button_container">
							<form action="php/choose_worker.php" method="POST">
								<input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
								<input type="hidden" name="order_id" value="<?= $account['order'];?>"/>
								<button name="worker_id" value="<?=array_values($applicant)[0]['id'];?>" class="choose">Zvolit</button>
							</form>
						</div>
					</div>
				
					</div>			
					<?php }
		        }
	        }
	        $stmt->close();}?>	
			</aside>
		</div>
	</div>

	<script src="scripts/dark_theme.js"></script>
</body>
</html>