<?php

require_once __DIR__.'/../db_work.php';

$db = getConnection($config_path);


$refund_json = '{"refund_id":10,"keys":{"3":"1","4":"1","5":"0"},"percent":"7.00"}';

$refund = json_decode($refund_json);
$canceled_keys = array();

foreach($refund->keys as $key_id=>$status){
	if($status == 1){
		$canceled_keys[] = $key_id;
	}
}

$canceled_keys_json = json_encode($canceled_keys);

echo sendData($db ,'refunds', $canceled_keys_json, 'http://10.55.33.34/cancelKey.php');
// 
// if(isset($_POST)){
// $refund = $_POST['refund'];
// echo($refund);


//}



?>