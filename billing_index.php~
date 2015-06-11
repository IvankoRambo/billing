<?php
	require_once __DIR__.'/db_work.php';


	$db = getConnection($config_path);
	
	$info = getAllProducts($db);
	$info = filterProductsKeys($info);
	$str = convertProductsInJSON($db, $info);

	$response = sendData('products', $str, 	'http://127.0.0.1/billing/get_products.php');
	
	echo($response);
?>
