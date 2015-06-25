<?php

/*
* Service locator pattern for connection to database, ought to remake for PDO module
*/


class Connection{
	
	protected $db;
	
	public function __construct($config_path){
		$config = parse_ini_file($config_path);
		try{
			$this->db = new PDO("mysql:host={$config['host']};dbname={$config['db_name']}", $config['user'], $config['password']);
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


class ServiceLocator{
	
	protected static $_connection;
	private function __construct(){ }
	
	public static function provideConnection(Connection $connection){
		self::$_connection = $connection;
	}
	
	public static function getConnection(){
		$config_path = 'db.ini';
		if(!isset(self::$_connection)){
			self::$_connection = new Connection($config_path);
		}
		return self::$_connection;
	}
		
}

$connection = ServiceLocator::getConnection();
$db = $connection->getDBSource();


?>
