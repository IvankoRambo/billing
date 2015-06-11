<?php
	require_once __DIR__.'/db_work.php';
	
	$r = new HttpRequest('http://example.com/form.php', HttpRequest::METH_POST);

	$db = getConnection($config_path);
	
	$info = getAllProducts($db);
	$info = filterProductsKeys($info);
	$str = convertProductsInJSON($db, $info);
	var_dump($str);
	

	/*$response = sendData('products', $str, 'get_products.php');
	
	var_dump($response);*/
	
?>
