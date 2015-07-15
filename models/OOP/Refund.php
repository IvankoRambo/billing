<?php
namespace OOP;
use \PDO;


class Refund {

	protected $ref_array;
	protected $connection;
	
	public function __construct($db, $ref_array){
		$this->ref_array = $ref_array;
		$this->connection = $db;
	}
	
	
	
	public function getAssociativeRefundArray(){
 	
	$ref_array_output = array();
	
	for($i = 0; $i < count($this->ref_array['keys']); $i++){
		
		$ref_array_output['keys'][$i] = array('key_id' => $this->ref_array['keys'][$i]['keyId'], 'status' => $this->ref_array['keys'][$i]['status']);
		
	}
	
	
	$ref_array_output['key_num'] = count($this->ref_array['keys']);
	$ref_array_output['refund_id'] = $this->ref_array['refundID'];
	$ref_array_output['percent'] = $this->ref_array['percent'];
	
	$this->ref_array = $ref_array_output;
	return $this->ref_array;
	
 }
	

	public function isThisKeyExistsInOrder($key_id){
 	
	 	$query = $this->connection->prepare("SELECT order_id, key_id FROM order_keys WHERE key_id = :key_id");
		$key_id = (int)$key_id;
		$query->bindParam(":key_id", $key_id, PDO::PARAM_INT);
		$query->execute();
		
		return ( $query->fetchAll(PDO::FETCH_ASSOC) );
	
 	}
	
	
 	public function findKeysOrders(){
	 		
			$existed = '';
				
	 		for($i = 0; $i < count($this->ref_array['keys']); $i++){
	 			$order_info = $this->isThisKeyExistsInOrder($this->ref_array['keys'][$i]['key_id']);
	 			if(!empty($order_info)){
	 				$this->ref_array['keys'][$i]['order_id'] = $order_info[0]['order_id'];
	 			}
				else{
					$existed .= $this->ref_array['keys'][$i]['key_id'].',';
				}
	 		}
			
			return ($existed != false) ? rtrim($existed, ',') : $this->ref_array;
	 }
	
	public function getAmountOfKeysForOrders(){
 	
		$keys_amount = array();
		
		for($i = 0; $i < count($this->ref_array['keys']); $i++){
			
			if(!isset($keys_amount[$this->ref_array['keys'][$i]['order_id']])){
				$keys_amount[$this->ref_array['keys'][$i]['order_id']] = 1;	
			}
			else{
				$keys_amount[$this->ref_array['keys'][$i]['order_id']] += 1;	
			}
		}
		
		return $keys_amount;
	
 	}
	
	public function wasnotKeyCanceled($key_id){
	 	$query = $this->connection->prepare('SELECT * FROM refund_keys WHERE canceled_keys = :key_id');
		$key_id = (int)$key_id;
		$query->bindParam(':key_id', $key_id, PDO::PARAM_INT);
		$query->execute();
		
		$check = $query->fetchAll(PDO::FETCH_ASSOC);
		return ( empty($check) );
 	}
	
	public function getCanceledKeys($id_refund, $id_order = null){
		
		if(is_null($id_order)){
		 	$query = $this->connection->prepare('SELECT canceled_keys FROM refund_keys WHERE id_refund = :id_refund');		
			$id_refund = (int)$id_refund;
			$query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
		}
		else{
			$query = $this->connection->prepare('SELECT canceled_keys FROM refund_keys WHERE id_refund = :id_refund AND id_order = :id_order');
			$id_refund = (int)$id_refund;
			$id_order = (int)$id_order;
			$query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
			$query->bindParam(':id_order', $id_order, PDO::PARAM_INT);
		}
		
		$query->execute();
		
		$key_array = $query->fetchAll(PDO::FETCH_NUM);
		$key_array_output = array();
		for($i = 0; $i < count($key_array); $i++){
			$key_array_output[] = $key_array[$i][0];
		}
		
		return $key_array_output;
	
 }
	
	
	public function getAmountOfCanceledKeys($id_refund, $id_order){
	 	$query = $this->connection->prepare('SELECT canceled_keys FROM refund_keys WHERE id_refund = :id_refund AND id_order = :id_order');
		$id_refund = (int)$id_refund;
		$id_order = (int)$id_order;
		$query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
		$query->bindParam(':id_order', $id_order, PDO::PARAM_INT);
		$query->execute();
		
		$canceled_keys = $query->fetchAll(PDO::FETCH_NUM);
		$canceled_keys_output = array();
		
		for($i = 0; $i < count($canceled_keys); $i++){
			$canceled_keys_output[] = $canceled_keys[$i][0];
		}
		
		return count($canceled_keys_output);
		
	 }


	public function insertCanceledKeys(){
	
		$canceled = '';
		
		for($i = 0; $i < count($this->ref_array['keys']); $i++){
			if($this->ref_array['keys'][$i]['status'] == 1){
			
				if($this->wasnotKeyCanceled($this->ref_array['keys'][$i]['key_id'])){		
					$query = $this->connection->prepare('INSERT INTO refund_keys (id_refund, id_order, canceled_keys) VALUE (:id_refund, :id_order, :canceled_keys)');
					$id_refund = (int)$this->ref_array['refund_id'];
					$id_order = (int)$this->ref_array['keys'][$i]['order_id'];
					$key_id = (int)$this->ref_array['keys'][$i]['key_id'];
					$query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
					$query->bindParam(":id_order", $id_order, PDO::PARAM_INT);
					$query->bindParam(':canceled_keys', $key_id, PDO::PARAM_INT);
					$query->execute();
				}
				else{
					$canceled .= $this->ref_array['keys'][$i]['key_id'].',';
				}
			}
		}
		
		
		return ($canceled != false) ? rtrim($canceled, ',') : true;
					
 	}
	
	
	 public function isOrderCanceled($id_order){
	 	$query = $this->connection->prepare('SELECT product_quantity, sum FROM orders WHERE order_id = :id_order');
		$id_order = (int)$id_order;
		$query->bindParam(':id_order', $id_order, PDO::PARAM_INT);
		$query->execute();
		
		$order_info = $query->fetchAll(PDO::FETCH_ASSOC);
		return ( ($order_info[0]['product_quantity'] <= 0) || ($order_info[0]['sum'] <= 0) ) ? true : false;
 	}
	 
	public function getOrder($id_order){
 		$query = $this->connection->prepare('SELECT * FROM orders WHERE order_id = :id_order');
		$id_order = (int)$id_order;
		$query->bindParam(':id_order', $id_order, PDO::PARAM_INT);
		$query->execute();
	
		return ( $query->fetchAll(PDO::FETCH_ASSOC) );
 	}
	
	public  function insertProductPriceInOrder($id_order, $order_price){
	 	$query = $this->connection->prepare('INSERT INTO order_price (id_order, price) VALUES (:id_order, :price)');
		$order_price = (string)$order_price;
		$query->bindParam(':id_order', $id_order, PDO::PARAM_INT);
		$query->bindParam(':price', $order_price, PDO::PARAM_STR);
		return $query->execute();
 	}

	public function getProductPriceInOrder($id_order){
	 	$query = $this->connection->prepare('SELECT * FROM order_price WHERE id_order = :id_order');
		$id_order = (int)$id_order;
		$query->bindParam(':id_order', $id_order, PDO::PARAM_INT);
		$query->execute();
		
		return ( $query->fetchAll(PDO::FETCH_ASSOC) );
		
	 }
	
	
	function calculateRefund($keys_amount){
 	
		$response = array(
			'refund' => null,
			'data' => null
		);
		$percent = (float)$this->ref_array['percent'];
		$refund_id = (int)$this->ref_array['refund_id'];
		
		foreach($keys_amount as $order_id=>$key_num){
			
			if(!$this->isOrderCanceled($order_id)){
				
				$price_info = $this->getProductPriceInOrder($order_id);
				$order_info = $this->getOrder($order_id);
				$sum = (float)$order_info[0]['sum'];
				$quantity = (int)$order_info[0]['product_quantity'];
				if(empty($price_info)){
					$price_for_product = $sum/$quantity;
					$this->insertProductPriceInOrder($order_id, $price_for_product);
				}
				else{
					$price_for_product = $price_info[0]['price'];
				}
				
				$refund_sum = ($percent/100)*$price_for_product*(int)$key_num;
				$response['refund'][] = array('id_order' => $order_id, 'sum' => $refund_sum, 'card' => $order_info[0]['card_name']);
				
				$query = $this->connection->prepare('INSERT INTO refunds (id_order, num_keys, sum, id_refund) VALUES (:id_order, :num_keys, :sum, :id_refund)');
				$num_keys = (int)$key_num;
				$order_id = (int)$order_id;
				$refund_sum = (string)$refund_sum;
				$query->bindParam(':id_order', $order_id, PDO::PARAM_INT);
				$query->bindParam(':num_keys', $num_keys, PDO::PARAM_INT);
				$query->bindParam(':sum', $refund_sum, PDO::PARAM_INT);
				$query->bindParam(':id_refund', $refund_id, PDO::PARAM_INT);
				$query->execute();
				
				$canceled_keys_amount = $this->getAmountOfCanceledKeys($refund_id, $order_id);
				$current_sum = $sum - $refund_sum;
				$current_sum = (string)$current_sum;
				$current_quantity = $quantity-$canceled_keys_amount;
				$query = $this->connection->prepare("UPDATE orders SET sum = :current_sum, product_quantity = :current_quantity WHERE order_id=:id_order");
				$query->bindParam(':current_sum', $current_sum, PDO::PARAM_STR);
				$query->bindParam(':current_quantity', $current_quantity, PDO::PARAM_INT);
				$query->bindParam(':id_order', $order_id, PDO::PARAM_INT);
				$query->execute();
			}
			else{
				$response['data'][] = 'Order '.$order_id.' is already fully refunded';
			}
			
		}
	
		return $response;
	
 	}
	
	

}




