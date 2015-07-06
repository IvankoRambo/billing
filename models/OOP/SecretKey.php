<?php

namespace OOP;
use \PDO;

class SecretKey{

	public function __construct(){}
	
	private static function insertSecretKey($db, $partner, $key){
  	
  	$query = $db->prepare('INSERT INTO secret_keys (partner, secret_key) VALUE (:partner, :key)');
	$query->bindParam(':partner', $partner, PDO::PARAM_STR);
	$query->bindParam(':key', $key, PDO::PARAM_STR);
	
	return ( $query->execute() );
	
  }
	
	private static function updateSecretKey($db, $partner, $key){
 	 	
		$query = $db->prepare("UPDATE secret_keys SET secret_key = :key WHERE partner=:partner");
		$query->bindParam(':partner', $partner, PDO::PARAM_STR);
		$query->bindParam(':key', $key, PDO::PARAM_STR);
		
		return ($query->execute());
  	}
	
	
  	public static function selectSecretKey($db, $partner){
	  	
		$query = $db->prepare('SELECT * FROM secret_keys WHERE partner = :partner');
		$query->bindParam(':partner', $partner, PDO::PARAM_STR);
		$query->execute();
		
		return ( $query->fetchAll(PDO::FETCH_ASSOC) );
  	}
	
	
	
	public static function addSecretKey($db, $partner, $key){
  	
	if(empty(self::selectSecretKey($db, $partner))){
		$result = self::insertSecretKey($db, $partner, $key);
	}
	else{
		$result = self::updateSecretKey($db, $partner, $key);
	}
	
	return $result;
	
  }
	

}

?>