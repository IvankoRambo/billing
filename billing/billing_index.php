<?php
	require_once __DIR__.'/db_work.php';
	
	$db = getConnection($config_path);
	
	$info = getAllProducts($db);
	$str = convertProductsInJSON($db,[1, 3, 4]);
	var_dump($str);
	
?>