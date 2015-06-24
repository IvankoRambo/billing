<?php

require_once __DIR__.'/../db_work.php';
require_once __DIR__.'/../loggings.php';

$db = getConnection($config_path);

//$refund_json = $_POST['refund'];
$refund_json = '{"refund_id":10,"keys":{"3":"1","4":"1","5":"0"},"percent":"7.00"}';

$refund = json_decode($refund_json);

$refund = getAssociativeRefundArray($refund);
$refund_order = findKeysOrders($db, $refund);

if(is_string($refund_order)){
	echo "{'status':'exists'; 'id_keys': [{$refund_order}]; 'id_refund': {$refund['refund_id']}; 'success': false}";
	return;
}
elseif(is_array($refund_order)){
	$keys_amount = getAmountOfKeysForOrders($refund_order);
	$inserted = insertCanceledKeys($db, $refund_order);
	
	if(is_string($inserted)){
		echo "{'status': 'canceled', 'id_keys': [{$inserted}], 'id_refund': {$refund['refund_id']}, 'success': false}";
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
			echo "{'status': 'all', 'success': false,  'id_keys': [], 'id_refund': {$refund['refund_id']}}";

		}
		else{
			$refunds_data = $ref_res['refund'];
			$refunds_data_j = json_encode($refunds_data);
			//sending data to AS
			if(($response = sendData($db, 'refunds', $refund_pack_j, 'http://10.55.33.36/refund.php')) && !preg_match('/not found/', $response)){
				insertIntoLogFile('refunds_response.log', $response, date("Y-m-d H:i:s"));
			}
			$id_keys = array();
			if(!is_null($ref_res['data'])){
				for($i = 0; $i < count($ref_res['data']); $i++){
					$failed_order = $ref_res['data'][$i];
					
					for($i = 0; $i < count($refund_order['keys']); $i++){
						if($failed_order == $refund_order['keys'][$i]['order_id']){
							$id_keys[] = $refund_order['keys'][$i]['key_id'];							
						}
					}
					 	
				}						
			}
			
			echo "{'success': true, 'id_keys': {$id_keys}, 'status': 'OK', 'id_refund': {$refund['refund_id']}, 'payment': {$response}}";	
		}
	}
}

?>