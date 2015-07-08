<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class SingleProductController extends Zend_Controller_Action{
	
	protected $db;
	
	public function init(){
		 $config_path = 'config/db.ini';
		 $connection = OOP\ServiceLocator::getConnection($config_path);
		 $this->db = $connection->getDBSource();
	}
	
	public function indexAction(){
		
		$this->view->pause = 2;
		
		$product_id = $this->getRequest()->getParam('product_id');
		$product_info = OOP\Product::getProductByID($this->db ,$product_id);
		$this->view->product_info = $product_info;
		
		if(!$product_info){
			header("Location: index");
		}
		
		$Data = new OOP\ProxyData();
		$response = array(
			'success' => false,
			'deleted' => false,
		);
		$this->view->s_data = null;

if(!is_null( $this->getRequest()->getPost('update') )){
	
	$data['name'] = ( !is_null($this->getRequest()->getPost('name')) ) ? Zend_Filter::filterStatic($this->getRequest()->getPost('name'), 'stripTags') : null;
	$data['price'] = ( !is_null($this->getRequest()->getPost('price')) ) ? Zend_Filter::filterStatic($this->getRequest()->getPost('price'), 'stripTags') : null;
	$data['description'] = ( !is_null($this->getRequest()->getPost('description')) ) ? Zend_Filter::filterStatic($this->getRequest()->getPost('description'), 'stripTags') : null;
	$this->view->name = $data['name'];
	$this->view->price = $data['price'];
	$this->view->description = $data['description'];
	
	if(!$data['name'] || !$data['price'] || !$data['description']){
		$this->view->s_data = 'All fields are required to be filled';
	}
	else{
		
		if(($data['name'] == $product_info[0]['name']) && ($data['price'] == $product_info[0]['price']) && ($data['description'] == $product_info[0]['description'])){
			$this->view->s_data = 'You didn\'t arrange any changes';	
		}
		else{
			$Product = new OOP\Product($data['name'], $data['price'], $data['description'], $this->db);
			if( $Product->updateProduct($product_id) ){
				$response['success'] = true;
				$this->view->s_data = 'You have been successfully update product info';
				
				$products = OOP\Product::get_all($this->db);
				$products = OOP\Product::filterProductsKeys($products);
				$products_json = OOP\Product::convertProductsInJSON($this->db, $products);
			
			
				$Logging = new OOP\Logging('logs/products_response.log');
			
				if(($prod_response = $Data->sendData($this->db, 'products', $products_json, null, null, 'http://10.55.33.34/', 'get', 'AccountService', 'password')) && !preg_match('/not found/', $prod_response)){
					$Logging->insertIntoLogFile($prod_response, date("Y-m-d H:i:s"));
				}
				
				
				if(($prod_response = $Data->sendData($this->db, 'products', $products_json, null, null, 'http://10.55.33.36/', 'billing/GetProductsFromBilling.php', 'payment', '1234')) && !preg_match('/not found/', $prod_response)){
					$Logging->insertIntoLogFile($prod_response, date("Y-m-d H:i:s"));
				}
							
			}
			else{
				$this->view->s_data = 'Product with such name already exists in the system';
			}
		}
		
	}
	
}

if(!is_null( $this->getRequest()->getPost('delete') )){
	
	if(OOP\Product::deleteProduct($this->db, $product_id)){
		$this->view->s_data = 'You have been successfully deleted product';
		$response['deleted'] = true;
		$response['success'] = true;
		
		$products = OOP\Product::get_all($this->db);
		$products = OOP\Product::filterProductsKeys($products);
		$products_json = OOP\Product::convertProductsInJSON($this->db, $products);
			
		$Logging = new OOP\Logging('logs/products_response.log');
			
		if(($prod_response = $Data->sendData($this->db, 'products', $products_json, null, null, 'http://10.55.33.34/', 'get', 'AccountService', 'password')) && !preg_match('/not found/', $prod_response)){
			$Logging->insertIntoLogFile($prod_response, date("Y-m-d H:i:s"));
		}
				
				
		if(($prod_response = $Data->sendData($this->db, 'products', $products_json, null, null, 'http://10.55.33.36/', 'billing/GetProductsFromBilling.php', 'payment', '1234')) && !preg_match('/not found/', $prod_response)){
			$Logging->insertIntoLogFile($prod_response, date("Y-m-d H:i:s"));
		}
		
	}
	else{
		$this->view->s_data = 'Probably, the product was deleted by other agent before you';
		}
	
	  }
		
		$this->view->response = $response;
		
	}
	
}

?>