<?php
Zend_Loader::loadClass('Zend_Controller_Action');

class GetorderController extends Zend_Controller_Action {
	protected $db;

	public function init() {
		$connection = OOP\ServiceLocator::getConnection();
		$this->db = $connection->getDBSource();
	}

	public function indexAction() {
		$this->_invokeArgs['noViewRenderer'] = true;
		Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
		$this->_helper->layout->disableLayout();

		$db = $this->db;

		$request = $this->getRequest();
		$getReq = $request->getQuery();
		$postReq = $request->getPost();


		$pr1 = isset($getReq['data']);
		$pr2 = isset($postReq['data']);

		$resFinal = array('code' => 1); 


		if ($pr1 || $pr2) {
			$getData = $pr1 ? $getReq['data'] : $postReq['data'];


			$Data = new OOP\ProxyData();
			$secret_obj = new OOP\SecretKey();
			$order = $Data->receiveData($getData, $db, $secret_obj);

			if (!$order) {
				$resFinal['code'] = 2;
				$resFinal['data'] = 'Invalid URL: not match!';
				echo json_encode($resFinal);
				return;
			}

			if (!isset($order->user_id)) {
				$order->user_id = NULL;
			}
			$order->keys = explode(',', $order->keys);

			$order = new OOP\Order($order);
			
			$res = $order->postOrder();
			$resDecoded = json_decode($res);
			if ($resDecoded->code == 1) {
				$order->sendOrder();
			}
			// $res = postOrder($db, 
			// 		  $order->order_id,
			// 		  $order->product_id,
			// 		  $order->product_quantity,
			// 		  $order->card_name,
			// 		  $order->sum,
			// 		  $order->keys,
			// 		  $order->date,
			// 		  $order->user_id);
			echo $res;
			// var_dump($order);
		} else {
			$resFinal['code'] = 3;
			$resFinal['data'] = 'Invalid data: $_GET["data"] or $_POST["data"] must be non-empty';
			echo json_encode($resFinal);
		}
	}
}
?>