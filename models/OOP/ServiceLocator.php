<?php

namespace OOP;

class ServiceLocator{
	
	protected static $_connection;
	private function __construct(){ }
	
	public static function provideConnection(Connection $connection){
		self::$_connection = $connection;
	}
	
	public static function getConnection($config_path = 'db.ini'){
		self::$_connection = new Connection($config_path);
		return self::$_connection;
	}

}


/**
*Now, when autoloading added can make 
$connection = OOP\ServiceLocator::getConnection();
$db = $connection->getDBSource();
 * in any other file
*/

?>