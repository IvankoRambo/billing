<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class IndexController extends Component\BaseController{
	
	
	
	public function indexAction(){
		 
		 $flash = $this->_helper->getHelper('flashMessenger');
		 
		 if(!is_null($this->getRequest()->getPost('add'))){
		 	
			$Product = new OOP\Product($this->getRequest()->getPost('name'), $this->getRequest()->getPost('price'), $this->getRequest()->getPost('description'), $this->db);
			
			if($Product->add()){
			$this->_helper->flashMessenger->addMessage('New product was added successfully');
			$products = OOP\Product::get_all($this->db);
			$products = OOP\Product::filterProductsKeys($products);
			$products_json = OOP\Product::convertProductsInJSON($this->db, $products);
			$Data = new OOP\ProxyData();
			$Logging = new OOP\Logging('logs/products_response.log');
			
				if(($prod_response = $Data->sendData($this->db, 'products', $products_json, null, null, 'http://10.55.33.21/', 'get', 'AccountService', 'password')) && !preg_match('/not found/', $prod_response)){
					$this->view->prod_response = $prod_response;
					$Logging->insertIntoLogFile($prod_response, date("Y-m-d H:i:s"));
				}
				
				
				if(($prod_response = $Data->sendData($this->db, 'products', $products_json, null, null, 'http://10.55.33.36/', 'billing/GetProductsFromBilling.php', 'payment', '1234')) && !preg_match('/not found/', $prod_response)){
					$Logging->insertIntoLogFile($prod_response, date("Y-m-d H:i:s"));
				}
				
				
			}
			
			else $this->_helper->flashMessenger->addMessage('Product with such name already exists in the system');
				 
		 }

		if($flash->hasMessages()){
			$this->view->product_message = $flash->getMessages();
			$this->_helper->flashMessenger->clearMessages();
		}
		
		$this->view->products = OOP\Product::get_all($this->db);
		
	}
	
}

?>