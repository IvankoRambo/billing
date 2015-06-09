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


function getProducts($db){
	$query = $db->prepare("SELECT * FROM products");
	$query->execute();
	
	return ( $query->fetchAll(PDO::FETCH_ASSOC) );
}

function insertIntoProducts($db, $name, $price){
	$query = $db->prepare("INSERT INTO products (name, price) VALUE (:name, :price)");
	$query->bindParam(":name", $name, PDO::PARAM_STR);
	$price = (string)$price;
	$query->bindParam(":price", $price, PDO::PARAM_STR);
	
	return ( $query->execute() ) ? true : false;
}

/*
 * here is expected the third parameter - an array with addresses of systems we will send JSON with products (maybe :) )
 * Или можно отсылку JSON на ко всем системам не делать в функции, а возвращать JSON и отсылать его куда нужно уже вне функции
 */

function sendProductsInJSON($db, $name, $price){
	
	if(!insertIntoProducts($db, $name, $price)){
		return false;
	}
	
	$product_list = getProducts($db);
	$JSON_products_array = array('products' => array());
	
	for($i = 0; $i<count($product_list); $i++)	$JSON_array['products'][] = $product_list[$i];
	
	$JSON_products = json_encode($JSON_array);
	
	return $JSON_products;
}

