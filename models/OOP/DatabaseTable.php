<?php
namespace OOP;
use \PDO;


class DatabaseTable {
	private $dbConnection;
	private $tableName;
	public function __construct($dbConnection, $tableName) {
		$this->dbConnection = $dbConnection;
		$this->tableName = $tableName;
	}
	public function getRecordsFromTable() {
	 	$table_name = $this->tableName;
	 	$db = $this->dbConnection->getDBSource();
	 	$query = $db->prepare('SELECT * FROM '.$table_name);
	 	
	 	$res = $query->execute();
	 	if (!$res) {
	 		return $query->errorInfo();
	 	}
	 	return $query->fetchAll(PDO::FETCH_ASSOC);
	}
}
?>