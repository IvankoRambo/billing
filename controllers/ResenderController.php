<?php
Zend_Loader::loadClass('Zend_Controller_Action');

class ResenderController extends Component\BaseController {

    public function indexAction() {

        $this->_invokeArgs['noViewRenderer'] = true;
        Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
        $this->_helper->layout->disableLayout();

        $Data = new OOP\ProxyData();
        $Data_trial = new OOP\Data();
        $Key = new OOP\SecretKey();
        $Logging = new OOP\Logging('logs/refunds_response.log');
        \OOP\Resender::init();
        \OOP\Resender::runOnce();

    }


}

