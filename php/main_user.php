<?php

require_once('boot.php');



if(isset($_POST["order_info_button"])) {
	if ($stmt = $con->prepare('SELECT * FROM orders WHERE id = ?')) {
		$order_id = $_POST("order_info_button");
		$stmt->bind_param('s', $order_id);
		$stmt->execute();
		$result = $stmt->get_result();
		
		$orders = $result->fetch_all(MYSQLI_ASSOC);

		$_SESSION['choosed_order'] = $orders[0];

		$stmt->close();
	} else {
		echo 'Could not prepare statement!';
	}
}



?>