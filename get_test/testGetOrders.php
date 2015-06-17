<?php
	require('db_work.php');
	$db = getConnection($config_path);

	// function postOrder($db, $product_id, $product_quantity, $card_name, $sum, $user_id = NULL) {

	if (isset($_POST) && isset($_POST['data'])) {
		$order = json_decode($_POST['data']);
		if (!isset($order->user_id)) {
			$order->user_id = NULL;
		}
		postOrder($db, 
				  $order->product_id,
				  $order->product_quantity,
				  $order->card_name,
				  $order->sum,
				  $order->user_id);
		var_dump($order);
	}
	echo "YEAH";
?>