<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class ViewdbController extends Component\BaseController{
	
	
	public function indexAction(){
			
			$this->view->db = $this->db;
		}
		
	}


?>