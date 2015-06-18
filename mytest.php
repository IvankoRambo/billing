<?php
require('header.php');
//$db = getConnection(__DIR__.'/config/db.ini');

//var_dump(checkPassword($db, 'test', 'test'));

require "vendor/autoload.php";
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
//echo $request->get("x", "default");
//echo $request->getPathInfo();

$response = new Response('My super response!');
$response->send();