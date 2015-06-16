<?php
	require('db_work.php');
	$db = getConnection($config_path);

	// function postOrder($db, $product_id, $product_quantity, $card_name, $sum, $user_id = NULL) {

	if (isset($_POST) && isset($_POST['data'])) {
		$order = json_encode($_POST['data']);
		var_dump($order);
	}
	echo "YEAH";
?>