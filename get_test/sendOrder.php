<pre>
<?php

//function postOrder($db, $order_id, $product_id, $product_quantity, $card_name, $sum, $keys, $user_id = NULL) {


	$params = array(
		'data' => json_encode(array(
				'order_id' => rand(1, 1000),
				'product_id' => 1,
				'product_quantity' => 4,
				'card_name' => 'BR25522',
				'sum' => 100,
				'keys' => array(rand(1, 1000), rand(1, 1000), rand(1, 1000), rand(1,1000)),
<<<<<<< HEAD
				'date' => date('Y-m-d H:i:s', time()),//'2015-06-19 17:16:12',
				'user_id' => rand(1, 100)
=======
				'user_id' => 5
>>>>>>> origin/dev
				)));
	$defaults = array(
		CURLOPT_URL => 'dev.big-exercise/get_test/testGetOrders.php',
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $params
		);


	
	$ch = curl_init();

	curl_setopt_array($ch, $defaults);
	// curl_setopt($ch, CURLOPT_URL);
	// curl_setopt($ch, CURLOPT_HEADER, 0);

	curl_exec($ch);

	curl_close($ch);
?>
</pre>