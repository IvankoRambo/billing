<?php
	require('db_work.php');
	$db = getConnection($config_path);

	// function getOrder($db, $product_id, $product_quantity, $card_name, $sum, $user_id = NULL) {

	getOrder($db, 1, 1, "DB62224", 220, 4);
?>