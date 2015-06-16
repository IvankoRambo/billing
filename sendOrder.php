<pre>
<?php

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'dev.big-exercise/testGetOrders.php');
	curl_setopt($ch, CURLOPT_HEADER, 0);

	curl_exec($ch);

	curl_close($ch);
?>
</pre>