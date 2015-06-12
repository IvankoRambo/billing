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

/*
	Getting all admins as array;

	returns array of admins
	returns 1, if there is problem with query.
	returns 2, if there is problem with database. 
*/

function getAdminsList($db) {
	$query = $db->prepare('SELECT * FROM admins');
	
	if (!$query) {
		return 1;
	}

	$res = $query->execute();
	if (!$res) {
		return 2;
	} 

	$admins = $query->fetchAll(PDO::FETCH_ASSOC);

	return $admins;
}

/*
	Return does admin exist as bool value

	returns true if admin exists
	returns false if admin does not exist
	returns 1, if there is problem with query.
	returns 2, if there is problem with database. 
*/

function isAdminExist($db, $name) {
	$admins = getAdminsList($db);
	
	if ($admins === 1 || $admins === 2) {
		return $admins;
	}

	foreach ($admins as $admin) {
		if ($admin['name'] == $name) {
			return true;
		}
	}
	return false;
}

/*
	Add new admin to table

	return true if success
	returns 1, if there is problem with query.
	returns 2, if there is problem with database. 
*/


function addAdmin($db, $name, $password) {
	$query = $db->prepare('INSERT INTO admins (`name`, `password`) VALUES (:name, PASSWORD(:password))');
	
	if (!$query) {
		return 1;
	}

	$query->bindParam(':name', $name);
	$query->bindParam(':password', $password);
	
	$res = $query->execute();

	if (!$res) {
		return 2;
	}

	return true;
}

/*
	Add new Admin if not exist before

	return true if success
	returns 1, if there is problem with query.
	returns 2, if there is problem with database. 
	
*/

function addAdminIfNotExist($db, $name, $password) {
	$res = isAdminExist($db, $name);
	switch ($res) {
		case 1: {
			return 1;
		} break;
		case 2: {
			return 2;
		} break;
		case true: {
			return false;
		} break;
		default: {

		}
	}

	$res = addAdmin($db, $name, $password);

	switch ($res) {
		case 1: {
			return 1;
		} break;
		case 2: {
			return 2;
		} break;
		default: {

		}
	}

	return true;
}

function updateProduct($db, $id, $name, $price) {
	$query = $db->prepare("UPDATE products SET name='$name', price=:price WHERE id=:id");
	// $query->bindParam(':name', $name);
	$query->bindParam(':price', $price);
	$query->bindParam(':id', $id);
	return ($query->execute());
}

function deleteProduct($db, $id) {
	$query = $db->prepare('DELETE FROM products WHERE id=:id');
	$query->bindParam(':id', $id);
	return ($query->execute());
}