<?php

$config_path = 'config/db.ini';

function getConnection($config_path){
	$config = parse_ini_file($config_path);
	
	try{
		$db = new PDO("mysql:host={$config['host']};dbname={$config['db_name']}", $config['user'], $config['password']);
	}
	catch(PDOException $e){
		echo "Connection is failed:".$e->getMessage();
		return;
	}
	
	return $db;
		
}

/*
 * Products
*/


function getAllProducts($db){
	$query = $db->prepare("SELECT * FROM products");
	$query->execute();
	
	return ( $query->fetchAll(PDO::FETCH_ASSOC) );
}

function getLastProduct($db){
	$query = $db->prepare("SELECT * FROM products where id=(SELECT MAX(id) FROM products)");
	$query->execute();
	
	return ( $query->fetchAll(PDO::FETCH_ASSOC) );
}


function filterProductsKeys($product_info){
	$keys = [];
	for($i = 0; $i<count($product_info); $i++){
		$keys[] = $product_info[$i]['id'];
	}
	
	return $keys;
}


function insertIntoProducts($db, $name, $price, $description){
	$query = $db->prepare("INSERT INTO products (name, price, description) VALUE (:name, :price, :description)");
	$query->bindParam(":name", $name, PDO::PARAM_STR);
	$query->bindParam(":price", $price, PDO::PARAM_STR);
	$query->bindParam(":description", $description, PDO::PARAM_STR);
	
	return ( $query->execute() ) ? true : false;
}



/*
 *function for converting products array in JSON
 */
 

function convertProductsInJSON($db, $products_keys){
		
	$products_keys_str = '';
	
	for($i = 0; $i<count($products_keys); $i++){
		if($i == count($products_keys)-1)	$products_keys_str .= $products_keys[$i];
		else $products_keys_str .= $products_keys[$i].', ';
	}
	
	$query = $db->prepare("SELECT * FROM products where id IN ($products_keys_str)");
	$query->execute();
	
	$JSON_products = array("products" => array());
	$array_products = $query->fetchAll(PDO::FETCH_ASSOC);
	
	
	
	for($i = 0; $i<count($array_products); $i++) $JSON_products['products'][] = $array_products[$i];
	
	return json_encode($JSON_products);
	
}


/*
 * Working with 'failed script' 
*/

function insertIntoFailedTable($db, $sufix, $data, $destination){
	
	$query = $db->prepare("INSERT INTO failed_{$sufix} (data, destination) VALUE (:data, :destination)");
	$query->bindParam(":data", $data, PDO::PARAM_STR);
	$query->bindParam(":destination", $destination, PDO::PARAM_STR);
	
	return ( $query->execute() );
		
}

/*
 * Sending some data in JSON for systems
 */

 
function sendData($db, $key_info ,$info, $address, $secret_key = null){

				
		$url = $address;
		
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
	
	if(!$response || preg_match('/not found/', $response)){
		insertIntoFailedTable($db, $key_info, $info, $url);	
	}
	
	return $response;
		
}

/*
 * admins 
*/

 function insertNewAdmin($db, $name, $password){
 	$query = $db->prepare('INSERT INTO admins (name, password) VALUES (:name, :password)');
	$query->bindParam(':name', $name);
	$query->bindParam(':password', $password);
	
	return ( $query->execute() );
	
 }
 
 function isRightPassword($db, $name, $password){
	$query = $db->prepare("SELECT id FROM admins WHERE name = :name AND password = :password");
	$query->bindParam(":name", $name, PDO::PARAM_STR);
	$query->bindParam(":password", $password, PDO::PARAM_STR);
	$query->execute();
	$check = $query->fetchAll(PDO::FETCH_NUM);
	

	return ( !empty($check) );

}	
 
/*
 *	updates and deletes of products 
*/

function updateProduct($db, $id, $name, $price, $description) {
	$query = $db->prepare("UPDATE products SET name=:name, price=:price, description=:description WHERE id=:id");
	$price = (string)$price;
	$query->bindParam(':name', $name, PDO::PARAM_STR);
	$query->bindParam(':price', $price, PDO::PARAM_STR);
	$query->bindParam(":description", $description, PDO::PARAM_STR);
	$query->bindParam(':id', $id, PDO::PARAM_INT);
	return ($query->execute());
}

function deleteProduct($db, $id) {
	$query = $db->prepare('DELETE FROM products WHERE id=:id');
	$query->bindParam(':id', $id, PDO::PARAM_INT);
	return ($query->execute());
}


function getProductsViaId($db, $id){
	$query = $db->prepare("SELECT name, price, description FROM products WHERE id=:id");
	$query->bindParam(":id", $id, PDO::PARAM_INT);
	$query->execute();
	
	return ( $query->fetchAll(PDO::FETCH_ASSOC) );
}


/*
 * Working with orders 
*/

function postOrder($db, $order_id, $product_id, $product_quantity, $card_name, $sum, $keys, $date, $user_id = NULL) {
	$tables = array('orders', 'orders_log');
	foreach ($tables as $table) {	
		$query = $db->prepare("INSERT INTO `$table`".
							  '(`order_id`, `product_id`, `product_quantity`, `card_name`, `sum`, `date`, `user_id`)'.
							  'VALUES'.
							  '(:order_id, :product_id, :product_quantity, :card_name, :sum, :date, :user_id)');
		$query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
		$query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
		$query->bindParam(':product_quantity', $product_quantity, PDO::PARAM_INT);
		$query->bindParam(':card_name', $card_name, PDO::PARAM_STR);
		$query->bindParam(':sum', $sum, PDO::PARAM_INT);
		$query->bindParam(':date', $date, PDO::PARAM_STR);
		$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
		$res = $query->execute();
		
		if (!$res) {
			echo '<pre>';
			var_dump($query->errorInfo());
			echo '</pre>';
			insertIntoLogFile(__DIR__.'/log_error_files/orders_error', 
				'Unsuccessful adding order to database table '.$table.'. Error message:'.
				$query->errorInfo()[2], 
				date('Y-m-d H:i:s', time()));

		} else {
			insertIntoLogFile(__DIR__.'/log_error_files/orders_log', 
				'Successful adding order to database table '.$table, 
				date('Y-m-d H:i:s', time()));
		}
	}

	$query = $db->prepare('INSERT INTO `orders`'.
						  '(`order_id`, `product_id`, `product_quantity`, `card_name`, `sum`, `date`, `user_id`)'.
						  'VALUES'.
						  '(:order_id, :product_id, :product_quantity, :card_name, :sum, :date, :user_id)');
	$query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
	$query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
	$query->bindParam(':product_quantity', $product_quantity, PDO::PARAM_INT);
	$query->bindParam(':card_name', $card_name, PDO::PARAM_STR);
	$query->bindParam(':sum', $sum, PDO::PARAM_INT);
	$query->bindParam(':date', $date, PDO::PARAM_STR);
	$query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
	$res = $query->execute();
	
	if (!$res) {
		echo '<pre>';
		var_dump($query->errorInfo());
		echo '</pre>';

	}
	// echo $res? "True" : "False";

	$query_str = 'INSERT INTO `order_keys`'.
				 '(`order_id`, `key_id`)'.
				 'VALUES';
	$keys_count = count($keys);
	for ($i = 1; $i < $keys_count; $i++) {
		$query_str = $query_str."(:order_id, :key_id$i), ";
	}
	$query_str = $query_str."(:order_id, :key_id$keys_count);";
	
	// print($query_str);

	$query = $db->prepare($query_str);
	
	$i = 1;
	$query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
	foreach ($keys as $key) {
		// echo "<br>";
		// print($i.' - '.$key);
		$query->bindValue(':key_id'.$i, $key, PDO::PARAM_INT);
		$i++;
	}
	// echo '<br>';
	// print($query->queryString);


	$res = $query->execute();

	// echo $res? "True" : "False";
	if (!$res) {
		echo '<pre>';
		var_dump($query->errorInfo());
		echo '</pre>';

		insertIntoLogFile(__DIR__.'/log_error_files/orders_error', 
				'Unsuccessful adding order and keys to database table order_keys. Error message: '.
				$query->errorInfo()[2], 
				date('Y-m-d H:i:s', time()));
	} else {
		insertIntoLogFile(__DIR__.'/log_error_files/orders_log', 
				'Successful adding order and keys to database table order_keys', 
				date('Y-m-d H:i:s', time()));
	}

	$res = '';
	// function sendData($db, $key_info ,$info, $address, $secret_key = null){
	// AccountService/AS/test_getOrderId.php') ; 
	// $data = array(
	// 	'order_id' => $order_id,
	// 	'keys' => $keys
	// );
	// $res1 = sendData($db, 'orders', json_encode($data), 'http://10.55.33.34/test_getOrderId.php');
	// if (!$res1) {
	// 	insertIntoLogFile(__DIR__.'/log_error_files/orders_error', 
	// 			'Unsuccessful sending order and keys to account service.', 
	// 			date('Y-m-d H:i:s', time()));
	// } else {
	// 	insertIntoLogFile(__DIR__.'/log_error_files/orders_log', 
	// 			'Successful sending order and keys to account service.', 
	// 			$query->errorInfo()[2], 
	// 			date('Y-m-d H:i:s', time()));
	// }
	// $res .= $res1;
	// CRM
	$data = array(
		'order_id' => $order_id,
		'keys' => $keys,
		'sum' => $sum,
		'user_id' => $user_id
	);
	$res1 = sendData($db, 'orders', json_encode($data), 'http://10.55.33.27/dev/addOrder.php');
	if (!$res1) {
		insertIntoLogFile(__DIR__.'/log_error_files/orders_error', 
				'Unsuccessful sending order and keys to CRM.', 
				date('Y-m-d H:i:s', time()));
	} else {
		insertIntoLogFile(__DIR__.'/log_error_files/orders_log', 
				'Successful sending order and keys to CRM.',
				date('Y-m-d H:i:s', time()));
	}
	$res .= $res1;
	return $res;
	}
	

/*
 * Working with refunds
 */
 
 function getAssociativeRefundArray($ref_array){
 	
	$ref_array_output = array();
	
	foreach($ref_array->keys as $key_id=>$status){
		$ref_array_output['keys'][] = array('key_id' => $key_id, 'status' => $status);
	}
	
	$ref_array_output['key_num'] = count($ref_array_output['keys']);
	$ref_array_output['refund_id'] = $ref_array->refund_id;
	$ref_array_output['percent'] = $ref_array->percent;
	
	return $ref_array_output;
	
 }
 
 function isThisKeyExistsInOrder($db, $key_id){
 	
 	$query = $db->prepare("SELECT order_id, key_id FROM order_keys WHERE key_id = :key_id");
	$key_id = (int)$key_id;
	$query->bindParam(":key_id", $key_id, PDO::PARAM_INT);
	$query->execute();
	
	return ( $query->fetchAll(PDO::FETCH_ASSOC) );
	
 }
 
 
 function findKeysOrders($db, $ref_array){
 		
		$existed = '';
			
 		for($i = 0; $i < count($ref_array['keys']); $i++){
 			$order_info = isThisKeyExistsInOrder($db, $ref_array['keys'][$i]['key_id']);
 			if(!empty($order_info)){
 				$ref_array['keys'][$i]['order_id'] = $order_info[0]['order_id'];
 			}
			else{
				$existed .= $ref_array['keys'][$i]['order_id'].',';
			}
 		}
		
		return ($existed != false) ? rtrim($existed, ',') : $ref_array;
 }
 
 
 function getAmountOfKeysForOrders($ref_array){
 	
	$keys_amount = array();
	
	for($i = 0; $i < count($ref_array['keys']); $i++){
		
		if(!isset($keys_amount[$ref_array['keys'][$i]['order_id']])){
			$keys_amount[$ref_array['keys'][$i]['order_id']] = 1;	
		}
		else{
			$keys_amount[$ref_array['keys'][$i]['order_id']] += 1;	
		}
	}
	
	return $keys_amount;
	
 }
 
 function wasnotKeyCanceled($db, $key_id){
 	$query = $db->prepare('SELECT * FROM refund_keys WHERE canceled_keys = :key_id');
	$key_id = (int)$key_id;
	$query->bindParam(':key_id', $key_id, PDO::PARAM_INT);
	$query->execute();
	
	$check = $query->fetchAll(PDO::FETCH_ASSOC);
	return ( empty($check) );
 }
 
 function getCanceledKeys($db, $id_refund){
 	$query = $db->prepare('SELECT canceled_keys FROM refund_keys WHERE id_refund = :id_refund');
	$id_refund = (int)$id_refund;
	$query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
	$query->execute();
	
	$key_array = $query->fetchAll(PDO::FETCH_NUM);
	$key_array_output = array();
	for($i = 0; $i < count($key_array); $i++){
		$key_array_output[] = $key_array[$i][0];
	}
	
	return $key_array_output;
	
 }
 
 function getAmountOfCanceledKeys($db, $id_refund, $id_order){
 	$query = $db->prepare('SELECT canceled_keys FROM refund_keys WHERE id_refund = :id_refund AND id_order = :id_order');
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
 
 
 function insertCanceledKeys($db, $ref_array){
	
	$canceled = '';
	
	for($i = 0; $i < count($ref_array['keys']); $i++){
		if($ref_array['keys'][$i]['status'] == 1){
		
			if(wasnotKeyCanceled($db, $ref_array['keys'][$i]['key_id'])){		
				$query = $db->prepare('INSERT INTO refund_keys (id_refund, id_order, canceled_keys) VALUE (:id_refund, :id_order, :canceled_keys)');
				$id_refund = (int)$ref_array['refund_id'];
				$id_order = (int)$ref_array['keys'][$i]['order_id'];
				$key_id = (int)$ref_array['keys'][$i]['key_id'];
				$query->bindParam(':id_refund', $id_refund, PDO::PARAM_INT);
				$query->bindParam(":id_order", $id_order, PDO::PARAM_INT);
				$query->bindParam(':canceled_keys', $key_id, PDO::PARAM_INT);
				$query->execute();
			}
			else{
				$canceled = $ref_array['keys'][$i]['key_id'].',';
			}
		}
	}
	
	return ($canceled != false) ? rtrim($canceled, ',') : true;
					
 }
 
 
 function isOrderCanceled($db, $id_order){
 	$query = $db->prepare('SELECT product_quantity, sum FROM orders WHERE order_id = :id_order');
	$id_order = (int)$id_order;
	$query->bindParam(':id_order', $id_order, PDO::PARAM_INT);
	$query->execute();
	
	$order_info = $query->fetchAll(PDO::FETCH_ASSOC);
	return ( ($order_info[0]['product_quantity'] <= 0) || ($order_info[0]['sum'] <= 0) ) ? true : false;
 }
 
 
 function getOrder($db, $id_order){
 	$query = $db->prepare('SELECT * FROM orders WHERE order_id = :id_order');
	$id_order = (int)$id_order;
	$query->bindParam(':id_order', $id_order, PDO::PARAM_INT);
	$query->execute();
	
	return ( $query->fetchAll(PDO::FETCH_ASSOC) );
 }


 function insertProductPriceInOrder($db, $id_order, $order_price){
 	$query = $db->prepare('INSERT INTO order_price (id_order, price) VALUES (:id_order, :price)');
	$order_price = (string)$order_price;
	$query->bindParam(':id_order', $id_order, PDO::PARAM_INT);
	$query->bindParam(':price', $order_price, PDO::PARAM_STR);
	return $query->execute();
 }
 
 
 function getProductPriceInOrder($db, $id_order){
 	$query = $db->prepare('SELECT * FROM order_price WHERE id_order = :id_order');
	$id_order = (int)$id_order;
	$query->bindParam(':id_order', $id_order, PDO::PARAM_INT);
	$query->execute();
	
	return ( $query->fetchAll(PDO::FETCH_ASSOC) );
	
 }
 

 function calculateRefund($db, $ref_array, $keys_amount){
 	
	$response = array(
		'refund' => null,
		'data' => null
	);
	$percent = (float)$ref_array['percent'];
	$refund_id = (int)$ref_array['refund_id'];
	
	foreach($keys_amount as $order_id=>$key_num){
		
		if(!isOrderCanceled($db, $order_id)){
			
			$price_info = getProductPriceInOrder($db, $order_id);
			$order_info = getOrder($db, $order_id);
			$sum = (float)$order_info[0]['sum'];
			$quantity = (int)$order_info[0]['product_quantity'];
			$order_info = getOrder($db, $order_id);
			if(empty($price_info)){
				$price_for_product = $sum/$quantity;
				insertProductPriceInOrder($db, $order_id, $price_for_product);
			}
			else{
				$price_for_product = $price_info[0]['price'];
			}
			
			$refund_sum = ($percent/100)*$price_for_product*(int)$key_num;
			$response['refund'][] = array('id_order' => $order_id, 'sum' => $refund_sum, 'card' => $order_info[0]['card_name']);
			
			$query = $db->prepare('INSERT INTO refunds (id_order, num_keys, sum, id_refund) VALUES (:id_order, :num_keys, :sum, :id_refund)');
			$num_keys = (int)$key_num;
			$order_id = (int)$order_id;
			$refund_sum = (string)$refund_sum;
			$query->bindParam(':id_order', $order_id, PDO::PARAM_INT);
			$query->bindParam(':num_keys', $num_keys, PDO::PARAM_INT);
			$query->bindParam(':sum', $refund_sum, PDO::PARAM_INT);
			$query->bindParam(':id_refund', $refund_id, PDO::PARAM_INT);
			$query->execute();
			
			$canceled_keys_amount = getAmountOfCanceledKeys($db, $refund_id, $order_id);
			$current_sum = $sum - $refund_sum;
			$current_sum = (string)$current_sum;
			$current_quantity = $quantity-$canceled_keys_amount;
			$query = $db->prepare("UPDATE orders SET sum = :current_sum, product_quantity = :current_quantity WHERE order_id=:id_order");
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
