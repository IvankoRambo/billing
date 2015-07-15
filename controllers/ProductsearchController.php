<?php

Zend_Loader::loadClass('Zend_Controller_Action');


class ProductsearchController extends Component\BaseController{
	
	
	public function indexAction(){
	
		$this->_invokeArgs['noViewRenderer'] = true;
		Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
		$this->_helper->layout->disableLayout();
		
		$response = array(
			'data' => null,
			'success' => false
		);
		
		$data['product-search'] = ( !is_null($this->getRequest()->getPost('product-search')) ) ? Zend_Filter::filterStatic($this->getRequest()->get('product-search'), 'stripTags') : null;
		
		$products = OOP\Product::get_like($this->db, $data['product-search']);
		
		if(!empty($products)){
			$response['success'] = true;
			$response['data'] = $products;
		}
		
		echo json_encode($response);

	}
		
}


?>