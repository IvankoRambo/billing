<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class IndexController extends Zend_Controller_Action{
	
	public function indexAction(){
		 
		 $config_path = 'config/db.ini';
		 $connection = OOP\ServiceLocator::getConnection($config_path);
		 $db = $connection->getDBSource();
		 $flash = $this->_helper->getHelper('flashMessenger');
		 
		 if(!is_null($this->getRequest()->getPost('add'))){
		 	
			$Product = new OOP\Product($this->getRequest()->getPost('name'), $this->getRequest()->getPost('price'), $this->getRequest()->getPost('description'), $db);
			
			if($Product->add()){
			$this->_helper->flashMessenger->addMessage('New product was added successfully');
			$products = OOP\Product::get_all($db);
			$products = $Product->filterProductsKeys($products);
			$products_json = $Product->convertProductsInJSON($products);
			$Data = new OOP\ProxyData();
			$Logging = new OOP\Logging('logs/products_response.log');
			
				if(($prod_response = $Data->sendData($db, 'products', $products_json, null, null, 'http://10.55.33.34/', 'get_products.php', 'AccountService', 'password')) && !preg_match('/not found/', $prod_response)){
					$Logging->insertIntoLogFile($prod_response, date("Y-m-d H:i:s"));
				}
				
				
				if(($prod_response = $Data->sendData($db, 'products', $products_json, null, null, 'http://10.55.33.36/', 'billing/GetProductsFromBilling.php', 'payment', '1234')) && !preg_match('/not found/', $prod_response)){
					$Logging->insertIntoLogFile($prod_response, date("Y-m-d H:i:s"));
				}
				
				
			}
			
			else $this->_helper->flashMessenger->addMessage('Product with such name already exists in the system');
				 
		 }

		if($flash->hasMessages()){
			$this->view->product_message = $flash->getMessages();
		}
		
		$this->view->products = OOP\Product::get_all($db);
		
	}
	
}

?>