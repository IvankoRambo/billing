<?php
require('db_work.php');

$config_path = 'config/db.ini';
$db = getConnection($config_path);

/**
 * @param pdo $db
 * @param string $name
 * @param float $price
 */
function addProduct($db, $name, $price) {
    $query = $db->prepare("INSERT INTO products(name, price)
      VALUES(:name, :price)");
    $query->execute(array(
        "name" => $name,
        "price" => $price
));
}

addProduct($db, 'windows', 100);

var_dump(getAllProducts($db));


