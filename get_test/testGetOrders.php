<?php
	require(__DIR__.'/../db_work.php');
	$db = getConnection($config_path);

	//function postOrder($db, $order_id, $product_id, $product_quantity, $card_name, $sum, $keys, $user_id = NULL) {

	//testing without sendOrder.php
	// srand(time());
	// postOrder($db, rand(1, 1000), rand(1, 1000), rand(1, 1000), "RD".rand(1, 1000000),
	// 	rand(1, 1000), 
	// 	array(4, 6, 2, 1 ,5 , 9), 
	// 	rand(1, 1000));

	if (isset($_POST) && isset($_POST['data'])) {
		$order = json_decode($_POST['data']);
		if (!isset($order->user_id)) {
			$order->user_id = NULL;
		}
		$res = postOrder($db, 
				  $order->order_id,
				  $order->product_id,
				  $order->product_quantity,
				  $order->card_name,
				  $order->sum,
				  $order->keys,
				  $order->user_id);
		echo $res;
		// var_dump($order);
	}
	// echo "YEAH";
?>