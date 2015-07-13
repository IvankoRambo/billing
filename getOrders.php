<?php
	require_once(__DIR__.'/../vendor/autoload.php');

	// require_once(__DIR__.'/../db_work.php');
	// $db = getConnection($config_path);
	$connection = OOP\ServiceLocator::getConnection();
	$db = $connection->getDBSource();

	//function postOrder($db, $order_id, $product_id, $product_quantity, $card_name, $sum, $keys, $user_id = NULL) {

	//testing without sendOrder.php
	// srand(time());
	// postOrder($db, rand(1, 1000), rand(1, 1000), rand(1, 1000), "RD".rand(1, 1000000),
	// 	rand(1, 1000), 
	// 	array(4, 6, 2, 1 ,5 , 9), 
	// 	rand(1, 1000));

	// var_dump($_GET);
	// var_dump($_POST);
	$pr1 = isset($_GET) && isset($_GET['data']);
	$pr2 = isset($_POST) && isset($_POST['data']);

	$resFinal = array('code' => 1); 

	if ($pr1 || $pr2) {
		$getData = $pr1 ? $_GET['data'] : $_POST['data'];


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
	// echo "Vladka-Marmeladka";
	// echo "YEAH";
?>