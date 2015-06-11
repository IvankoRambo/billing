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

<<<<<<< HEAD

function sendData($key ,$value, $address){
	
	$data = array(
		$key => $value,
	);
	
	$options = array(
		'http' => array(
			'header' => "Content-type: application/x-www-form-urlencoded\r\n",
			'method' => 'POST',
			'content' => http_build_query($data)
		),
	);
	
	$context = stream_context_create($options);
	
	$fp = fopen($address, 'r', false, $context);
	fpassthru($fp);
	fclose($fp);
	
}



=======
function getAdminsList($db) {
	$query = $db->prepare('SELECT * FROM admins');
	$res = $query->execute();
	if (!$res) {
		return false;
	} 

	$admins = $query->fetchAll(PDO::FETCH_ASSOC);

	return $admins;
}
>>>>>>> zeoorigin/dev
