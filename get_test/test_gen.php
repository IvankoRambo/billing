<?php

//echo 3;
//var_dump($_POST);

require_once __DIR__.'/../db_work.php';

$db = getConnection($config_path);

$order_j = '{"order_id":"85","product_id":"asd12322","product_quantity":3,"card_name":"1234567887654321","sum":"254","keys":"123123123123,23452345234523523452345,23452345234523421234","date":"2015-06-19 17:16:12","user_id":"1234567812345678"}';
$response = sendData($db, 'orders', $order_j, 'http://10.55.33.27/dev/addOrder.php');
echo $response;

?>