<?php

require_once('php/boot.php');

unfinished_signup_check();
unauthorized_check();
worker_check();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

$orders_per_page = 8;

$orders = null;
$num_orders = null;

$current_page_name = pathinfo(__FILE__, PATHINFO_BASENAME);

if($stmt = $con->prepare('SELECT COUNT(*) FROM orders WHERE status = ? AND executor = ?')) {
	$stmt->bind_param('ii', $status, $creator);

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

if ($stmt = $con->prepare('SELECT * FROM orders WHERE status = ? AND executor = ? ORDER BY date DESC LIMIT ?, ?')) {
	$current_page = ($page - 1) * $orders_per_page;
	$status = 0;
	$creator = $_SESSION['user']['id'];
	$stmt->bind_param('iiii', $status, $creator, $current_page, $orders_per_page);
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

	<title>Main worker</title>
</head>
<body>
	<div class="wrapper">
		<header>
			<div class="header-wrapper">
				<img src="media/logo.png" alt="logo" class="logo">
				<nav class="header-nav">
					<a href="main_worker.php">Najít práci</a>
					<a href="current_orders.php">Aktuální objednávky</a>
					<a href="finished_orders.php" id="current_page">Historie objednávek</a>
					<a href="account_worker.php">Osobní účet</a>
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
								<button name="order_info" value="<?=$order['id']?>" class="finished"><?=$done_order_text?></button>
							</form>
						</div>
					</div>
					<?php endforeach; ?>

					
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
						<div class="order_info_container"><p class="order_info_label">Číslo telefonu: </p><?php echo array_values($choosed_order)[0]['phone']; ?></div>
						<div class="order_info_container"><p class="order_info_label">Datum: </p><?php echo array_values($choosed_order)[0]['date']; ?></div>
						<div class="order_info_container"><p class="order_info_label">Typ vozidla: </p><?php echo array_values($choosed_order)[0]['container'] ? "Ano" : "Ne"; ?></div>
						<div class="order_info_container"><p class="order_info_label">Úklid: </p><?php echo array_values($choosed_order)[0]['cleaning'] ? "Ano" : "Ne"; ?></div>
						<div class="order_info_container"><p class="order_info_label">Nakládka: </p><?php echo array_values($choosed_order)[0]['loading'] ? "Ano" : "Ne"; ?></div>
						<div class="order_info_container"><p class="order_info_label">Popis: </p><p title="<?php echo array_values($choosed_order)[0]['description']; ?>"><?php echo array_values($choosed_order)[0]['description']; ?></p></div>
					</div>
					<div class="image_order_info">
						<img src="<?php echo array_values($choosed_order)[0]['image']; ?>">
					</div>
				</div>
				<?php } ?>			
				</div>				
			</aside>
		</div>
	</div>

	<script src="scripts/dark_theme.js"></script>
	<script src="scripts/no_validate.js"></script>
</body>
</html>