<pre>
<?php

// function postOrder($db, $product_id, $product_quantity, $card_name, $sum, $user_id = NULL) {


	$params = array(
		'data' => json_encode(array(
				'product_id' => 1,
				'product_quantity' => 4,
				'card_name' => 'BR25522',
				'sum' => 100,
				'user_id' => 5
				)));
	$defaults = array(
		CURLOPT_URL => 'dev.big-exercise/testGetOrders.php',
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