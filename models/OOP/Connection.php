<?php
namespace OOP;
use \PDO;
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
	public function getTable($table_name) {
		// var_dump($allTables);
		$allTables = $this->getTablesList();
		for ($i = 0; $i < count($allTables); $i++) {
			if ($allTables[$i] == $table_name) {
				return new DatabaseTable($this, $table_name);
			}
		}
		return null;
	}
	public function getTablesList() {
		$query   = $this->db->prepare('SHOW TABLES');
		$query->execute();
		$allTables = $query->fetchAll();
		$allTablesInArray = array();
		for ($i = 0; $i < count($allTables); $i++) {
			$allTablesInArray[] = $allTables[$i][0];
		}
		return $allTablesInArray;
	}
	
}
?>
