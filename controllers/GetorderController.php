<?php
Zend_Loader::loadClass('Zend_Controller_Action');

class GetorderController extends Component\BaseController{


	public function indexAction() {
		$this->_invokeArgs['noViewRenderer'] = true;
		Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
		$this->_helper->layout->disableLayout();

		$db = $this->db;

		$request = $this->getRequest();
		$getReq = $request->getQuery();
		$postReq = $request->getPost();
		
		$logging = new OOP\Logging('logs/orders_log');


		$pr1 = isset($getReq['data']);
		$pr2 = isset($postReq['data']);

		$resFinal = array('code' => 1); 


		if ($pr1 || $pr2) {
			$getData = $pr1 ? $getReq['data'] : $postReq['data'];


			$Data = new OOP\ProxyData();
			$secret_obj = new OOP\SecretKey();
			$order = $Data->receiveData($getData, $db, $secret_obj);

			if (!$order) {
		  //       $erroring = new Logging(realpath('logs/orders_error'));
				// $erroring->insertIntoLogFile( 
    //                 'Unsuccessful adding order and keys to database table order_keys. Error message: '.
    //                 $query->errorInfo()[2], 
    //                 date('Y-m-d H:i:s', time()));
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
				$newRes = $order->sendOrder();
				// echo $newRes;
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
			// $logging->insertIntoLogFile( 
   //                   'Result:'."\n".
   //                   $res."\n", 
   //                   date('Y-m-d H:i:s', time()));
			// var_dump($order);
		} else {
			// $erroring = new Logging(realpath('logs/orders_error'));
			// 	$erroring->insertIntoLogFile( 
   //                  'Unsuccessful adding order and keys to database table order_keys. Error message: '.
   //                  $query->errorInfo()[2], 
   //                  date('Y-m-d H:i:s', time()));
			$resFinal['code'] = 3;
			$resFinal['data'] = 'Invalid data: $_GET["data"] or $_POST["data"] must be non-empty';
			echo json_encode($resFinal);
		}
	}
}
?>