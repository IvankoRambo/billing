<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class RegistrationController extends Component\BaseController{
	
	
	
	public function indexAction(){
		 
		$data['user_name'] = ( !is_null($this->getRequest()->getPost('user_name')) ) ? Zend_Filter::filterStatic($this->getRequest()->getPost('user_name'), 'stripTags') : null;
		$data['password'] = ( !is_null($this->getRequest()->getPost('password')) ) ? Zend_Filter::filterStatic($this->getRequest()->getPost('password'), 'stripTags') : null;
		
		$response = array(
			'data' => null,
			'success' => false
		);
		
		if( !is_null($this->getRequest()->getPost('sign_up')) ) {
			
			$Agent = new OOP\Agent($this->db, $data['user_name'], $data['password']);
			if( !$Agent->checkPassword() ){
				$Agent->insert();
				$response['success'] = true;
				$response['data'] = 'You have been successfully registered';
			}
			else {
				$response['data'] = 'The user with such login is already exists';
			}
	
		}
		
		$this->view->r_response = $response;
		$this->view->r_POST = $this->getRequest()->getPost();		
		
	}
	
}

?>