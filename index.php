<?php

set_include_path(__DIR__.'/ZendFramework/library'.PATH_SEPARATOR.get_include_path());
// $lib_path = '/usr/share/php/Zend';

require_once /*$lib_path.'/*/'Zend/Loader/Autoloader.php';
require_once /*$lib_path.'/*/'Zend/Controller/Front.php';

try{
	Zend_Loader::loadClass('Zend_Controller_Front');
	Zend_Loader::loadClass('Zend_Loader_StandardAutoloader');
	Zend_Loader::loadClass('Zend_Layout');
	Zend_Loader::loadClass('Zend_Controller_Plugin_Abstract');
	Zend_Loader::loadClass('Zend_Controller_Request_Abstract');
	Zend_Loader::loadClass('Zend_Session_Namespace');
	Zend_Loader::loadClass('Zend_Controller_Router_Route');
	
	
	class HeaderLayoutPlugin extends Zend_Controller_Plugin_Abstract{
		
		public function preDispatch(Zend_Controller_Request_Abstract $request){
			$layout = Zend_Layout::getMvcInstance();
			$view = $layout->getView();
			
			$view->session = new Zend_Session_Namespace('global_data');
			$config_path = 'config/db.ini';
			$connection = OOP\ServiceLocator::getConnection($config_path);
			$db = $connection->getDBSource();
			
			$data['name'] = ( !is_null( $this->getRequest()->getPost('name') ) ) ? Zend_Filter::filterStatic($this->getRequest()->getPost('name'), 'StripTags') : null;
			$data['password'] = ( !is_null( $this->getRequest()->getPost('password') ) ) ? Zend_Filter::filterStatic($this->getRequest()->getPost('password'), 'StripTags') : null;
			
			$view->data = null;
			$view->success = false;
			
			if(!is_null($this->getRequest()->getPost('sign_in'))){
				$Agent = new OOP\Agent($db, $data['name'], $data['password']);
			    if($Agent->checkPassword()){
			        $view->session->name = $data['name'];
			        $view->session->isLogged = true;
			    } else {
			        $view->data = "<h3>Access denied!</h3>";
			    }
			}
			
		}
		
	}


    class SidebarLayoutPlugin extends Zend_Controller_Plugin_Abstract{

        public function preDispatch(Zend_Controller_Request_Abstract $request){
            $layout = Zend_Layout::getMvcInstance();
            $view = $layout->getView();


        }

    }
	
	
	$loader = new Zend_Loader_StandardAutoloader(array('autoregister_zf' => true));
	$loader->registerNamespace('Model', __DIR__.'/models');
	$loader->registerNamespace('OOP', __DIR__.'/models/OOP');
	$loader->registerNamespace('Component', __DIR__.'/component');
	$loader->setFallbackAutoloader(true);
	$loader->register();
	
	Zend_Layout::startMvc(array(
		'layoutPath' => __DIR__.'/layouts',
		'layout' => 'layout'
	));
	
	$frontController = Zend_Controller_Front::getInstance();
	$frontController->setControllerDirectory(__DIR__.'/controllers');
	$frontController->registerPlugin(new HeaderLayoutPlugin());
	$frontController->registerPlugin(new SidebarLayoutPlugin());
	$frontController->throwExceptions(true);
	$frontController->setParam('noViewRendered', false);
	$frontController->setParam('noErrorHandler', true);
	$frontController->setControllerDirectory(__DIR__.'/controllers');
	
	$routes = $frontController->getRouter();
	$routes->addRoute('key-ui', new Zend_Controller_Router_Route('key-ui', array('controller' => 'key', 'action' => 'index')));
	$routes->addRoute('get-refund', new Zend_Controller_Router_Route('get-refund', array('controller' => 'refund', 'action' => 'index')));
	$routes->addRoute('single-product', new Zend_Controller_Router_Route('single-product', array('controller' => 'singleproduct', 'action' => 'index')));
	$routes->addRoute('view-db', new Zend_Controller_Router_Route('view-db', array('controller' => 'viewdb', 'action' => 'index')));
	
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