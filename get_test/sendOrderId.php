<?php
	require __DIR__.'/../db_work.php';

	$db = getConnection($config_path);

	$order_id = 2;
	$keys = array(rand(1, 1000), rand(1, 1000), rand(1, 1000), rand(1,1000));
	$data = array(
		'order_id' => $order_id,
		'keys' => $keys
	);
	$res = sendData($db, 'orders', json_encode($data), 'http://10.55.33.34/test_getOrderId.php') ; 
	echo $res;
?>