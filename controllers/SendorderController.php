<?php
Zend_Loader::loadClass('Zend_Controller_Action');

class SendorderController extends Component\BaseController{


	function indexAction() {
		$this->_invokeArgs['noViewRenderer'] = true;
		Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
		$this->_helper->layout->disableLayout();
		$order_id = rand(1, 1000);
		echo $order_id.'<br>';
		$order = array(
					'order_id' => $order_id,
					'product_id' => 1,
					'product_quantity' => 4,
					'card_name' => 'BR25522',
					'sum' => 100,
					'keys' => implode(",",array(rand(1,1000000), rand(1, 1000000), rand(1, 1000000), rand(1,1000000))),
					'date' => date('Y-m-d H:i:s', time()),//'2015-06-19 17:16:12',
					'user_id' => rand(1, 100)
					);
		$params = $order;
		// $params = array(
		// 	'data' => json_encode($order));
		// // echo $order_id.'<br>';
		// // $params = array(
		// // 	'data' => '{"order_id":"85","product_id":"12322","product_quantity":3,"card_name":"1234567887654321","sum":"254","keys":"1231231,23452345,421234","date":"2015-06-19 17:16:12","user_id":"345678"}');
		// // var_dump(explode(',', '123123123123,23452345234523523452345,23452345234523421234'));
		// $defaults = array(					
		// 	CURLOPT_URL => 'dev.big-exercise/getOrder',
		// 	CURLOPT_POST => true,
		// 	CURLOPT_POSTFIELDS => $params
		// 	);


		
		// $ch = curl_init();

		// curl_setopt_array($ch, $defaults);
		// // curl_setopt($ch, CURLOPT_URL);
		// // curl_setopt($ch, CURLOPT_HEADER, 0);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		// $res = curl_exec($ch);

		// print_r($res);

		// curl_close($ch);



		// public function sendData($db, $key_info, $info, $address = null, $secret_key = null, $urlDomain = null, $urlPath = null, $partner = null, $key = null){

		
		$proxyData = new OOP\ProxyData();
		$res1 = $proxyData->sendData($this->db, 'data', json_encode($params), null, null, 
			'dev.big-exercise/', 'getOrder', '1231239900', '0908');

		echo $res1;

		// $res = postOrder($db, 
		// 		  $order['order_id'],
		// 		  $order['product_id'],
		// 		  $order['product_quantity'],
		// 		  $order['card_name'],
		// 		  $order['sum'],
		// 		  $order['keys'],
		// 		  $order['date'],
		// 		  $order['user_id']);
		// echo  $res;

	}
}