<?php
	$order_id = 2;
	$keys = array(rand(1, 1000), rand(1, 1000), rand(1, 1000), rand(1,1000));
	$data = array(
		'order_id' => $order_id,
		'keys' => $keys
	);
	
	$key_info = 'orders';
	$info = json_encode($data);
	$url = 'http://10.55.33.34/test_getOrderId.php';
	
	$fields = array(
	$key_info => $info,
	'secret_key' => $secret_key
	);
	
	$fields_str = '';
	
	foreach($fields as $key=>$value) { $fields_str .= $key.'='.$value.'&'; }
	$fields_str = trim($fields_str, '&');
		
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_str);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
	
	echo $response;
?>