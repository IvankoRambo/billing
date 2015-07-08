<?php
/*
 * Agent class
 */

 namespace OOP;
 use \PDO;
 
 class Agent{
 	
	protected $db, $name, $password;
	
	public function __construct($db, $name, $password){
		$this->db = $db;
		$this->name = $name;
		$this->password = $password;
	}
	
	public function checkPassword(){
		
	$query = $this->db->prepare("SELECT id FROM admins WHERE name = :name");
	$query->bindParam(":name", $this->name, PDO::PARAM_STR);
	$query->execute();
	$check = $query->fetchAll(PDO::FETCH_NUM);
	

	return ( !empty($check) );
		
	}
	
	public function insert(){
		
	$query = $this->db->prepare('INSERT INTO admins (name, password) VALUES (:name, :password)');
	$query->bindParam(':name', $this->name, PDO::PARAM_STR);
	$query->bindParam(':password', $this->password, PDO::PARAM_STR);
	
	return ( $query->execute() );
		
	}	
	
 }
 
 
?>