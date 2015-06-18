<?php
    
	require_once __DIR__.'/db_work.php';


	$db = getConnection($config_path);
	
	$info = getAllProducts($db);
	$info = filterProductsKeys($info);
	$str = convertProductsInJSON($db, [1,2,3]);

//    var_dump($str);

	$response1 = sendData('products', $str, 'http://10.55.33.33/Account_Service/AS/get_products.php');
	$response2 = sendData('products', $str, 'http://payment.proc/billing/GetProductsFromBilling.php');
	
	echo($response2);
?>
