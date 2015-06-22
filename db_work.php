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
 * checking is right password for admin or not 
*/

function isRightPassword($db, $name, $password){
	$query = $db->prepare("SELECT id FROM admins WHERE name = :name AND password = :password");
	$query->bindParam(":name", $name, PDO::PARAM_STR);
	$query->bindParam(":password", $password, PDO::PARAM_STR);
	$query->execute();
	$check = $query->fetchAll(PDO::FETCH_NUM);
	

	return ( !empty($check) );

}

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
 			
 		for($i = 0; $i < count($ref_array['keys']); $i++){
 			$order_info = isThisKeyExistsInOrder($db, $ref_array['keys'][$i]['key_id']);
 			if(!empty($order_info)){
 				$ref_array['keys'][$i]['order_id'] = $order_info[0]['order_id'];
 			}
			else{
				return $ref_array['keys'][$i]['key_id'];
			}
 		}
		
		return $ref_array;
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
 
 
 function insertCanceledKeys($db, $ref_array){
	
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
				return $ref_array['keys'][$i]['key_id'];
			}
		}
	}
	
	return true;
					
 }