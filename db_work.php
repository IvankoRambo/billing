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
	$price = (string)$price;
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

/*function sendData($key_info ,$info, $address_array, $description = null){
=======
function sendData($key ,$value, $address){
	
	$data = array(
		$key => $value,
	);
>>>>>>> zeoorigin/dev
	
	$response_array = array();
	
	for($i = 0; $i < count($address_array); $i++){
				
		$url = $address_array[$i];
		
		$fields = array(
		$key_info => $info,
		'description' => $description.' '.$url
		);
		
		$fields_str = '';
		
		foreach($fields as $key=>$value) { $fields_str .= $key.'='.$value.'&'; }
		$fields_str = trim($fields_str, '&');
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, count($fields));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_str);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Transfer-Encoding: chunked',
	    'Connection: keep-alive',
	    'Content-Length: ' . strlen($fields_str))
		);
		
		$response = curl_exec($ch);
		$response_array[] = ( !$response ) ? 'Some technical problems with sending data on '.$url : $response;
		curl_close($ch);
				
	}
	
	return $response_array[0];
		
}*/



function getAdminsList($db) {
	$query = $db->prepare('SELECT * FROM admins');
	$res = $query->execute();
	if (!$res) {
		return false;
	} 

	$admins = $query->fetchAll(PDO::FETCH_ASSOC);

	return $admins;
}

