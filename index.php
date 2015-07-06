<?php

$lib_path = '/usr/share/php/Zend';

require_once $lib_path.'/Loader/Autoloader.php';
require_once $lib_path.'/Controller/Front.php';
require_once $lib_path.'/Loader/StandardAutoloader.php';
require_once $lib_path.'/Layout.php';
require_once $lib_path.'/Controller/Plugin/Abstract.php';
require_once $lib_path.'/Controller/Request/Abstract.php';

try{
	Zend_Loader::loadClass('Zend_Controller_Front');
	Zend_Loader::loadClass('Zend_Loader_StandardAutoloader');
	Zend_Loader::loadClass('Zend_Layout');
	Zend_Loader::loadClass('Zend_Controller_Plugin_Abstract');
	Zend_Loader::loadClass('Zend_Controller_Request_Abstract');
	
	
	class HeaderLayoutPlugin extends Zend_Controller_Plugin_Abstract{
		
		public function preDispatch(Zend_Controller_Request_Abstract $request){
			$layout = Zend_Layout::getMvcInstance();
			$view = $layout->getView();
			
			$view->whatever = 'whatever';
		}
		
	}
	
	
	$loader = new Zend_Loader_StandardAutoloader(array('autoregister_zf' => true));
	$loader->registerNamespace('Model', __DIR__.'/models');
	$loader->registerNamespace('OOP', __DIR__.'/models/OOP');
	$loader->setFallbackAutoloader(true);
	$loader->register();
	
	Zend_Layout::startMvc(array(
		'layoutPath' => __DIR__.'/layouts',
		'layout' => 'layout'
	));
	
	$frontController = Zend_Controller_Front::getInstance();
	$frontController->registerPlugin(new HeaderLayoutPlugin());
	$frontController->throwExceptions(true);
	$frontController->setParam('noViewRendered', false);
	$frontController->setParam('noErrorHandler', true);
	$frontController->setControllerDirectory(__DIR__.'/controllers');
	$frontController->dispatch();
	

	
}
catch(Exception $exp){
	$contentType = 'text/html';
	
	header("Content-Type: $contentType; charset=utf-8");
	echo "An unexpected error occured.";
	echo "<br />";
	echo "<h2>Unexpected Exception: {$exp->getMessage()} </h2><br /><pre>";
	echo $exp->getTraceString();
}

?>