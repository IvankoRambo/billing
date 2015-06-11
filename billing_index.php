<?php
	require_once __DIR__.'/db_work.php';


	$db = getConnection($config_path);
	
	$info = getAllProducts($db);
	$info = filterProductsKeys($info);
	$str = convertProductsInJSON($db, $info);
	var_dump($str);

	

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
