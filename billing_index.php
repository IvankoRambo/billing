<?php
	require_once __DIR__.'/db_work.php';
	
	$db = getConnection($config_path);
	
	$str = sendProductsInJSON($db, 'Avarum Key SuperAntivirus', 0.12);
	var_dump($str);
	
?>