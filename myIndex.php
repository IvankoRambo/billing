<?php

set_include_path(__DIR__.'/ZendFramework/library'.PATH_SEPARATOR.get_include_path());

require_once 'Zend/Loader/Autoloader.php';
require_once 'Zend/Controller/Front.php';

try{
	Zend_Loader::loadClass('Zend_Controller_Front');	
	$frontController = Zend_Controller_Front::getInstance();
	$frontController->throwExceptions(true);
	$frontController->setParam('noViewRendered', true);
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