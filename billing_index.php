<?php
	require_once __DIR__.'/db_work.php';
	
	$db = getConnection($config_path);
	
	$str = sendProductsInJSON($db, 'Some Antivirus', 0.12);
	var_dump($str);
	
?>