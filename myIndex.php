<?php
include __DIR__.'/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMaster;
use Symfony\Component\Routing\Matcher\RequestContext;
use Symfony\Component\Routing\Matcher\RouteCollection;
use Symfony\Component\Routing\Matcher\Route;

$request = Request::createFromGlobals();

$routes = new RouteCollection();
$routes->add('getOrder', new Route('/getOrder', array('controller' => 'Order', 'action' => 'getOrder')));


?>