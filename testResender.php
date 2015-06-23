<?php

//var_dump($_POST);
require('db_work.php');
$db = getConnection(__DIR__.'/config/db.ini');

function insertIntoFailedProducts($db, $data, $destination){
    $query = $db->prepare("INSERT INTO failed_products (data, destination) VALUE (:data, :destination)");
    $query->bindParam(":data", $data, PDO::PARAM_STR);
    $query->bindParam(":destination", $destination, PDO::PARAM_STR);

    return ( $query->execute() ) ? true : false;
}

//echo insertIntoFailedProducts($db, $_POST['data'], 'AS');
//var_dump($_POST['data']);
var_dump($_POST);