<?php
require __DIR__ . '/db_work.php';
$db = getConnection(__DIR__.'/config/db.ini');

///**
// * @param $db PDO
// * @param $tableName string
// * @return bool
// */
//function checkForFailed($db, $tableName) {
//    $query = $db->prepare("SELECT id FROM $tableName");
//    $query->execute();
//
//    $isFailed = $query->fetchAll(PDO::FETCH_ASSOC);
//
////    return (isset($failedOrders) ? $failedOrders : null);
//    return !empty($isFailed);
//}


/**
 * @param $db PDO
 * @return string
 */
function checkForFailed($db) {
    $products = $db->prepare("SELECT id FROM failed_products");
    $products->execute();

    $orders = $db->prepare("SELECT id FROM failed_orders");
    $orders->execute();

    $refunds = $db->prepare("SELECT id FROM failed_refunds");
    $refunds->execute();

//    if (($products->rowCount() > 0) || ($orders->rowCount() > 0) || ($refunds->rowCount() > 0)) {
//        return true;
//    }

    if (($products->rowCount() > 0)) {
        return 'failed_products';
    } elseif (($orders->rowCount() > 0)) {
        return 'failed_orders';
    } elseif (($refunds->rowCount() > 0)) {
        return 'failed_refunds';
    } else return false;
}


/**
 * @param $db PDO
 * @param $tableName string
 * @return object
 */
function getLastRecord($db, $tableName) {
    $query = $db->prepare("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");
    $query->execute();

    return $query->fetchAll(PDO::FETCH_OBJ);
}

//function deleteLastRecord

//var_dump(getLastRecord($db, 'failed_products'));
//var_dump(getLastRecord($db, 'failed_orders'));

//while(checkForFailed($db)) {
//    if (getLastRecord($db, 'failed_products')) {
//        // insert here function to send data to destination
//        print("sending data to => " . getLastRecord($db, 'failed_products')->destination . "<br>");
//    } else {
//        echo 'There are no failed products to send!<br>';
//    }
//
//    if (getLastRecord($db, 'failed_orders')) {
//        // insert here function to send data to destination
//        print("sending data to => " . getLastRecord($db, 'failed_orders')->destination . "<br>");
//    } else {
//        echo "There are no failed orders to send!<br>";
//    }
//
//    if (getLastRecord($db, 'failed_refunds')) {
//        // insert here function to send data to destination
//        print("sending data to => " . getLastRecord($db, 'failed_refunds')->destination . "<br>");
//    } else {
//        echo 'There are no failed refunds to send!<br>';
//    }
//}

var_dump(checkForFailed($db));
//
//while(checkForFailed($db)) {
//    if (getLastRecord($db, checkForFailed($db))) {
//        // insert here function to send data to destination
//        print("sending data to => " . getLastRecord($db, checkForFailed($db))->destination . "<br>");
//    } else {
//        echo 'There are no failed products to send!<br>';
//    }
//}

//var_dump(getLastRecord($db, 'failed_products'));


$myProducts = 4;
$myOrders = 5;

function getMy($myProducts, $myOrders) {
    while (check($myProducts, $myOrders)) {
        if (check($myProducts, $myOrders) == 'products') {
            echo $myProducts--;
        } elseif (check($myProducts, $myOrders) == 'orders') {
            echo $myOrders--;
        }
    }
}

function check($myProducts, $myOrders) {
    if ($myProducts > 0) {
        return 'products';
    } elseif ($myOrders > 0) {
        return 'orders';
    } else return false;
}

getMy($myProducts, $myOrders);


