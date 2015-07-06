<?php

/*
* Connection to db
*/

namespace OOP;

class Connection{
	
	protected $db;
	
	public function __construct($config_path){
		$config = parse_ini_file($config_path);
		try{
			$this->db = new \PDO("mysql:host={$config['host']};dbname={$config['db_name']}", $config['user'], $config['password']);
		}
		catch(PDOException $e){
			echo 'Connection is failed: '.$e->getMessage();
		}
	}
	
	
	public function getDBSource(){
		if(!isset($this->db)){
			echo 'There was no connnection to database';
			return;
		}
		else{
			return $this->db;
		}
	}
	
}

?>
