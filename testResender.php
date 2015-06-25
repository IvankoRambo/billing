<?php

//var_dump($_POST);

require "vendor/autoload.php";
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//
//
//require('db_work.php');
//$db = getConnection(__DIR__.'/config/db.ini');
//
//function insertIntoFailedProducts($db, $data, $destination){
//    $query = $db->prepare("INSERT INTO failed_products (data, destination) VALUE (:data, :destination)");
//    $query->bindParam(":data", $data, PDO::PARAM_STR);
//    $query->bindParam(":destination", $destination, PDO::PARAM_STR);
//
//    return ( $query->execute() ) ? true : false;
//}

if (isset($_POST)) {
    echo Response::HTTP_OK;
}