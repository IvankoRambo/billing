<?php
	require_once __DIR__.'/db_work.php';
	/*
	$db = getConnection($config_path);
	
	$info = getAllProducts($db);
	$str = convertProductsInJSON($db,[1, 3, 4]);
	var_dump($str);

	$a = ['name' => 3, 'surname' => 4];
	$a = json_encode($a);
	
	$response = sendData('products', $a, ['http://10.55.33.27/Account_Service/AS/test.php']);
	var_dump($response);
	
	*/
	// дополняем массив с данными файлами
	$db = getConnection($config_path);
	
	$info = getAllProducts($db);
	$str = convertProductsInJSON($db,[3, 1]);
	$a = ['name' => 3, 'surname' => 4];
	$b = json_encode($a);

	// создаем подключение
	$ch = curl_init('http://10.55.33.27/Account_Service/AS/test.php');
	// устанавлваем даные для отправки
	curl_setopt($ch, CURLOPT_POSTFIELDS, 'a='.$str);
	// флаг о том, что нужно получить результат
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// отправляем запрос
	$response = curl_exec($ch);
	// закрываем соединение
	curl_close($ch);
	
	var_export($response);
?>