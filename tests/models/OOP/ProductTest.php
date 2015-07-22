<?php
require __DIR__ . "/../../../models/OOP/Product.php";
require __DIR__ . "/../../../models/OOP/ServiceLocator.php";
require __DIR__ . "/../../../models/OOP/Connection.php";

class ProductTest extends PHPUnit_Framework_TestCase {
    public function testGetAllProducts() {

    }

    public function testSum() {
        assertEquals(4, sum(2, 2));
    }

    public function setUp() {

    }

    public function tearDown() {

    }
}