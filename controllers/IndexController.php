<?php

Zend_Loader::loadClass('Zend_Controller_Action');

class IndexController extends Zend_Controller_Action{
	
	public function indexAction(){
		echo "<center><h1>HelloWorld</h1></center>";
	}
	
}

?>