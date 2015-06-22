<?php

require_once __DIR__.'/../db_work.php';

$db = getConnection($config_path);


$refund_json = '{"refund_id":10,"keys":{"3":"1","4":"1","5":"0"},"percent":"7.00"}';

$refund = json_decode($refund_json);
print_r($refund_json);

echo "<br />";
$refund = getAssociativeRefundArray($refund);
$refund_order = findKeysOrders($db, $refund);
print_r($refund_order);
$keys_amount = getAmountOfKeysForOrders($refund_order);
insertCanceledKeys($db, $refund_order);
$canceled_keys = getCanceledKeys($db, $refund_order['refund_id']);


// Block for sending info to AC
/*$canceled_keys = array();

foreach($refunds->keys as $key_id=>$status){
	if($status == 1){
		$canceled_keys[] = $key_id;
	}
}

$canceled_keys_json = json_encode($canceled_keys);

echo sendData($db ,'refunds', $canceled_keys_json, 'http://10.55.33.29//AS/test.php');*/
// 
// if(isset($_POST)){
// $refund = $_POST['refund'];
// echo($refund);


//}


?>