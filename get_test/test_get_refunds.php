<?php

require_once __DIR__.'/../db_work.php';

$db = getConnection($config_path);

//$refund_json = $_POST['refund'];
$refund_json = '{"refund_id":10,"keys":{"3":"1","4":"1","5":"0"},"percent":"7.00"}';

$refund = json_decode($refund_json);

$refund = getAssociativeRefundArray($refund);
$refund_order = findKeysOrders($db, $refund);


if(is_string($refund_order)){
	echo 'The key with id '.$refund_order.' does not exist in the system';
	return;
}
elseif(is_array($refund_order)){
	$keys_amount = getAmountOfKeysForOrders($refund_order);
	$inserted = insertCanceledKeys($db, $refund_order);
	
	if(is_string($inserted)){
		echo 'The key with id '.$inserted.' has already been canceled';
		return;
	}
	elseif(is_bool($inserted)){
		$canceled_keys = getCanceledKeys($db, $refund_order['refund_id']);
		//sending this keys to Accaunt service
		$ref_res = calculateRefund($db, $refund_order, $keys_amount);
		if(is_null($ref_res['refund'])){
			$response_f = '';
			
			for($i = 0; $i < count($ref_res['data']); $i++){
				$response_f .= ', '.$ref_res['data'][$i]; 	
			}
			
			echo 'All orders of refunds have been canceled. IDs of orders: '.$response_f;
		}
		else{
			$refunds_data = $ref_res['refund'];
			$refunds_data_j = json_encode($refunds_data);
			//sending data to AS
			$response = sendData($db, 'refunds', $refund_pack_j, 'http://10.55.33.36/refund.php');
			if(!is_null($ref_res['data'])){
				$response_f = '';
			
				for($i = 0; $i < count($ref_res['data']); $i++){
					$response_f .= ', '.$ref_res['data'][$i]; 	
				}
				$response_f = 'These orders were already canceled '.$response_f;
				$response = $response.' '.$response_f;	
			}
			
			echo $response;	
		}
	}
}

?>