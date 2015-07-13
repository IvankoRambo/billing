<?php
namespace Component;
use \Zend_Loader;
use \Zend_Controller_Action;
use \PDO;
Zend_Loader::loadClass('Zend_Controller_Action');


class BaseController extends Zend_Controller_Action{
	
		protected $db;
		protected $connection;
		
		public function init(){
			 $config_path = 'config/db.ini';
			 $this->connection = \OOP\ServiceLocator::getConnection($config_path);
			 $this->db = $this->connection->getDBSource();
		}
		
	}


?>