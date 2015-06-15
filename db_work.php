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
	
	return ( empty($check) ) ? false : true;
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


function insertIntoProducts($db, $name, $price){
	$query = $db->prepare("INSERT INTO products (name, price) VALUE (:name, :price)");
	$query->bindParam(":name", $name, PDO::PARAM_STR);
	$query->bindParam(":price", $price, PDO::PARAM_STR);
	
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
 * Sending some data in JSON for systems
 */

function sendData($key_info ,$info, $address, $secret_key = null){

				
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

	return $response;
		
}



 function insertNewAdmin($db, $name, $password){
 	$query = $db->prepare('INSERT INTO admins (name, password) VALUES (:name, :password)');
	$query->bindParam(':name', $name);
	$query->bindParam(':password', $password);
	
	return ( $query->execute() );
	
 }
 


function updateProduct($db, $id, $name, $price) {
	$query = $db->prepare("UPDATE products SET name=:name, price=:price WHERE id=:id");
	$price = (string)$price;
	$query->bindParam(':name', $name, PDO::PARAM_STR);
	$query->bindParam(':price', $price, PDO::PARAM_STR);
	$query->bindParam(':id', $id, PDO::PARAM_INT);
	return ($query->execute());
}

function deleteProduct($db, $id) {
	$query = $db->prepare('DELETE FROM products WHERE id=:id');
	$query->bindParam(':id', $id, PDO::PARAM_INT);
	return ($query->execute());
}


function getProductsViaId($db, $id){
	$query = $db->prepare("SELECT name, price FROM products WHERE id=:id");
	$query->bindParam(":id", $id, PDO::PARAM_INT);
	$query->execute();
	
	return ( $query->fetchAll(PDO::FETCH_ASSOC) );
}

/*
 * Proccessing of refund
 */
 
 function addNewRefund($db, $refund_id, $order_id, $product_id, $product_quantity, $refund_sum = 0, $date = NULL){
	
	$query = $db->prepare('INSERT INTO refund VALUE (:id, :order_id, :product_id, :product_quantity, :refund_sum, :date)');
	$query->bindParam(':id', $refund_id, PDO::PARAM_INT);
	$query->bindParam(':order_id', $order_id, PDO::PARAM_INT);
	$query->bindParam(':product_id', $product_id, PDO::PARAM_INT);
	$query->bindParam(':product_quantity', $product_quantity, PDO::PARAM_INT);
	$query->bindParam(':refund_sum', $refund_sum, PDO::PARAM_INT);
	if(!is_null($date)) $date = string($date);
	$query->bindParam(':date', $date, PDO::PARAM_STR);
	
	return ( $query->execute() );
	
 }
