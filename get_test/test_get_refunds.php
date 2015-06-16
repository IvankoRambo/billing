<?php

require_once __DIR__.'/db_work.php';

$db = getConnection($config_path);

//$_POST['cancelRequest']

$json_refund = '[{"id":"14","status":"0","email_us":"d@s.ua","date":"2015-06-12 18:16:51","product":"Phone","product_num":"1","order_num":"0"}]';

/*
 * Here is received refund
 * if(isset($_POST['cancelRequest'])){
	$json = $_POST['cancelRequest'];
	$query = $db->prepare("INSERT INTO test1 (test) VALUE (:cancel)");
	$query->bindParam(":cancel", $json, PDO::PARAM_STR);
	$query->execute();
}
else{
	return;
}*/

//if(!isset($_POST['cancelRequest'])){
if(false){
	return;
}
else{
	$refund = json_decode($json_refund);
	$refund_data = (array)$refund[0];
	print_r($refund_data);
	$check = addNewRefund($db, 4, $refund_data['order_num'], 2, $refund_data['product_num']);
	var_dump($check);
}


?>