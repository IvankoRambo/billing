<?php

Zend_Loader::loadClass('Zend_Controller_Action');
Zend_Loader::loadClass('Zend_Session_Namespace');

class LogoutController extends Zend_Controller_Action{
	
	public function indexAction(){
		
		$globalSession = new Zend_Session_Namespace('global_data');
		
		if($globalSession->isLogged === true){
			unset($globalSession->isLogged);
		}
		
		header("Location: index");
		
	}
	
}

?>