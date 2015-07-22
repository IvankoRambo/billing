<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class RefundController extends Component\BaseController{
	
	
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
					$ref_request['status'] = 'notexists';
					$ref_request['id_keys'] = $refund_order;
					$ref_request['id_refund'] = $refund['refund_id'];
					$ref_request['success'] = false;
					$ref_request_j = json_encode($ref_request);
					echo $ref_request_j;
					$CRM_res = $Data->sendData($this->db, 'refunds', $ref_request_j, null, null, 'http://10.55.33.27/', 'refund/receiveResponse', 'CRM', '1');
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
						$ref_request['status'] = 'canceled';
						$ref_request['id_keys'] = $inserted;
						$ref_request['id_refund'] = $refund['refund_id'];
						$ref_request['success'] = false;
						$ref_request_j = json_encode($ref_request);
						echo $ref_request_j;
						$CRM_res = $Data->sendData($this->db, 'refunds', $ref_request_j, null, null, 'http://10.55.33.27/', 'refund/receiveResponse', 'CRM', '1');
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
							$ref_request['status'] = 'all';
							$ref_request['id_keys'] = [];
							$ref_request['id_refund'] = $refund['refund_id'];
							$ref_request['success'] = false;
							$ref_request_j = json_encode($ref_request);
							echo $ref_request_j;
							$CRM_res = $Data->sendData($this->db, 'refunds', $ref_request_j, null, null, 'http://10.55.33.27/', 'refund/receiveResponse', 'CRM', '1');
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
							//$id_keys_payment = array();
							
							for($i = 0; $i < count($ref_res['refund']); $i++){
								
								//sending data to PP
								//print_r($ref_res);
								$refunds_data['id_order'] = $ref_res['refund'][$i]['id_order'];
								$refunds_data['sum'] = $ref_res['refund'][$i]['sum'];
								$refunds_data['card'] = $ref_res['refund'][$i]['card'];
								$refunds_data['id_refund'] = $refund['refund_id'];
								$refunds_data['id_keys'] = $id_keys;
								$refunds_data_j = json_encode($refunds_data);
								if(($PP_response = $Data_trial->sendData($this->db, 'refunds', $refunds_data_j, 'http://10.55.33.36/refund.php')) && !preg_match('/not found/', $PP_response)){
									$Logging->insertIntoLogFile($PP_response, date("Y-m-d H:i:s"));	
								}
								
								try{
									$PP_response_data = json_decode($PP_response, true);
									
									if(json_last_error() !== JSON_ERROR_NONE){
										throw new Exception("The response of PP is not a JSON");						
									}
									
								}
								catch(Exception $e){
									echo 'Exception: '.$e->getMessage();
								}
								
								if( (int)$PP_response_data['code'] !== 1) {
									$p_keys = $Refund->getCanceledKeys($ref_res['id_refund'], $ref_res[$i]['id_order']);
									
									for($i = 0; $i < count($p_keys); $i++){
										array_push($id_keys_payment[], $p_keys[$i]);	
									}
									
								}
								
							}
							$ref_request = array();
							$ref_request['status'] = 'OK';
							$ref_request['id_keys'] = $id_keys;
							$ref_request['id_refund'] = $refund['refund_id'];;
							$ref_request['success'] = true;
							//$ref_request['id_keys_payment'] = $id_keys_payment;
							$ref_request_j = json_encode($ref_request);
							echo $ref_request_j;
							$CRM_res = $Data->sendData($this->db, 'refunds', $ref_request_j, null, null, 'http://10.55.33.27/', 'refund/receiveResponse', 'CRM', '1');
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