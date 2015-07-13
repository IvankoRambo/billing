<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class RefundController extends Zend_Controller_Action{
	
	protected $db;
	
	public function init(){
		 $config_path = 'config/db.ini';
		 $connection = OOP\ServiceLocator::getConnection($config_path);
		 $this->db = $connection->getDBSource();
	}
	
	public function indexAction(){
		
		$this->_invokeArgs['noViewRenderer'] = true;
		Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
		$this->_helper->layout->disableLayout();
		$Data = new OOP\ProxyData();
		$Data_trial = new OOP\Data();
		$Key = new OOP\SecretKey();
		$Logging = new OOP\Logging('logs/refunds_response.log');
			
			if( !is_null($this->getRequest()->getPost()) ){
			
			$refund = $Data->receiveData($this->getRequest()->getPost('refund'), $this->db, $Key, true);
			if($refund === false){
				echo 'Sorry, but you are not the one I have expected for.';
				return;
			}
			else{
				$Refund = new OOP\Refund($this->db, $refund);
				$refund = $Refund->getAssociativeRefundArray();	
				$refund_order = $Refund->findKeysOrders();
				if(is_string($refund_order)){
					$refund_order = explode(',', $refund_order);
					$refund_order = json_encode($refund_order);
					echo "{'status':'notexists'; 'id_keys': {$refund_order}; 'id_refund': {$refund['refund_id']}; 'success': false}";
					$CRM_res = $Data->sendData($this->db, 'refunds', "{'status':'notexists'; 'id_keys': {$refund_order}; 'id_refund': {$refund['refund_id']}; 'success': false}", null, null, 'http://10.55.33.27/', 'refund/receiveResponse', 'CRM', '1');
					$Logging->insertIntoLogFile($CRM_res, date("Y-m-d H:i:s"));
					return;
				}
				elseif(is_array($refund_order)){
					$keys_amount = $Refund->getAmountOfKeysForOrders($refund_order);
					$inserted = $Refund->insertCanceledKeys($refund_order);
				
					if(is_string($inserted)){
						$inserted = explode(',', $inserted);
						$inserted = json_encode($inserted);
						echo "{'status': 'canceled', 'id_keys': {$inserted}, 'id_refund': {$refund['refund_id']}, 'success': false}";
						$CRM_res = $Data->sendData($this->db, 'refunds', "{'status': 'canceled', 'id_keys': {$inserted}, 'id_refund': {$refund['refund_id']}, 'success': false}", null, null, 'http://10.55.33.27/', 'refund/receiveResponse', 'CRM', '1');
						$Logging->insertIntoLogFile($CRM_res, date("Y-m-d H:i:s"));
						return;
					}
					elseif(is_bool($inserted)){
						$ref_res = $Refund->calculateRefund($keys_amount);
						if(is_null($ref_res['refund'])){
							$response_f = '';
							
							for($i = 0; $i < count($ref_res['data']); $i++){
								$response_f .= ', '.$ref_res['data'][$i]; 	
							}
							$response_f = trim($response_f, ',');
							echo "{'status': 'all', 'success': false,  'id_keys': [], 'id_refund': {$refund['refund_id']}}, 'success': false}";
							$CRM_res = $Data->sendData($this->db, 'refunds', "{'status': 'all', 'success': false,  'id_keys': [], 'id_refund': {$refund['refund_id']}}, 'success': false}", null, null, 'http://10.55.33.27/', 'refund/receiveResponse', 'CRM', '1');
							$Logging->insertIntoLogFile($CRM_res, date("Y-m-d H:i:s"));
						}
						else{
							
							$canceled_keys = $Refund->getCanceledKeys($refund_order['refund_id']);
							$canceled_keys_j = json_encode($canceled_keys);
							//sending this keys to Accaunt service
							if(($AC_res = $Data->sendData($this->db, 'refunds', $canceled_keys_j, null, null, 'http://10.55.33.34/', 'discard', 'AccountService', 'password')) && !preg_match('/not found/', $AC_res)){
								//insertIntoLogFile("../refunds_response.log", $AC_res, date("Y-m-d H:i:s"));
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
							$id_keys = json_encode($id_keys);
							$refunds_data['refunds'] = $ref_res['refund'];
							$refunds_data['id_refund'] = $refund['refund_id'];
							$refunds_data['id_keys'] = $id_keys;
							$refunds_data_j = json_encode($refunds_data);
							
							//sending data to PP
							if(($PP_response = $Data_trial->sendData($this->db, 'refunds', $refunds_data_j, 'http://10.55.33.21/without_routing/discard.php')) && !preg_match('/not found/', $PP_response)){
								//insertIntoLogFile('../refunds_response.log', $response, date("Y-m-d H:i:s"));
							}
							
							echo "{'success': true, 'id_keys': {$id_keys}, 'status': 'OK', 'id_refund': {$refund['refund_id']}, 'payment': {$PP_response}}";
							$CRM_res = $Data->sendData($this->db, 'refunds', "{'success': true, 'id_keys': {$id_keys}, 'status': 'OK', 'id_refund': {$refund['refund_id']}, 'payment': {$PP_response}}", null, null, 'http://10.55.33.27/', 'refund/receiveResponse', 'CRM', '1');
							$Logging->insertIntoLogFile($CRM_res, date("Y-m-d H:i:s"));	
						}
					}
				}
				
			}
			
			//$refund_json = '{"keys":[{"keyId":"874","orderId":"50","status":"1","percent":"172.99","id":"3"}, {"keyId":"875","orderId":"50","status":"1","percent":"172.99","id":"3"}],"percent":"8.00","refundID":"70"}';
			//$refund = json_decode($refund_json, true);
			
			}

		}
		
	}


?>