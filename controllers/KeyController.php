<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class KeyController extends Zend_Controller_Action{
	
	protected $db;
	
	public function init(){
		 $config_path = 'config/db.ini';
		 $connection = OOP\ServiceLocator::getConnection($config_path);
		 $this->db = $connection->getDBSource();
	}
	
	public function indexAction(){
		
		$data['partner'] = ( !is_null($this->getRequest()->getPost('partner')) ) ? Zend_Filter::filterStatic($this->getRequest()->getPost('partner'), 'stripTags') : null;
		$data['secret_key'] = ( !is_null($this->getRequest()->getPost('secret_key')) ) ? Zend_Filter::filterStatic($this->getRequest()->getPost('secret_key'), 'stripTags') : null;
		
		$response = array(
		'data' => null
		);
		
		if( !is_null($this->getRequest()->getPost('b_k')) ){
		
		if(!$data['partner'] || !$data['secret_key']){
			$response['data'] = 'All fields are required';
		}
		else{
			if(!OOP\SecretKey::addSecretKey($this->db, $data['partner'], $data['secret_key'])){
				$response['data'] = 'Can\'t add your key';
			}
			else{
				$response['data'] = 'Key was addded successfully';
			}
		}
		
	}
		
		$this->view->k_response = $response;
		
	}
	
}

?>