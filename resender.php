<?php
require "vendor/autoload.php";
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
require __DIR__ . '/db_work.php';
$db = getConnection(__DIR__.'/config/db.ini');


// URLs
$AS = 'http://dev.school-server/billing/billing/testResenderAS.php';
$PP = 'http://dev.school-server/billing/billing/testResenderPP.php';
$CRM = 'http://dev.school-server/billing/billing/testResenderCRM.php';
$destinations = array('AS' => $AS,
                      'PP' => $PP,
                      'CRM' => $CRM);

$localhost = 'http://dev.school-server/billing/billing/testResender.php';

/**
 * @param $db PDO
 * @return string name of table that has records
 */
function checkTables($db) {
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

    return $query->fetch(PDO::FETCH_OBJ);
}

// placeholder doesn't work for bind
//function deleteRow($db, $tableName) {
//    $query = $db->prepare('DELETE FROM :tableName ORDER BY id DESC LIMIT 1');
//    $query->bindParam(':tableName', $tableName, PDO::PARAM_STR);
//    return ($query->execute());
//}
/**
 * @param $db PDO
 * @param $tableName string
 * @return mixed
 */
function deleteLastRecord($db, $tableName) {
    $query = $db->prepare("DELETE FROM $tableName ORDER BY id DESC LIMIT 1");
//    $query->bindParam(':tableName', $tableName, PDO::PARAM_STR);
    return ($query->execute());
}

function generateRandomText($quantity) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $length = strlen($characters);

    $text = null;
    for ($i = 0; $i < $quantity; $i++) {
        $position = rand(0, $length);
        $text .= substr($characters, $position, 1);
    }

    return $text;
}

/**
 * @param $db PDO
 * @param $tableName string
 * @return mixed
 */
function generateRecords($db, $tableName) {
    $query = $db->prepare("INSERT INTO $tableName (data, destination) VALUE (:data, :destination)");
    $data = '{"' . $tableName . '":[{"id":"' . rand(1,30) . '","name":"' . generateRandomText(rand(4,12)) . '","price":"' . rand(100, 1000) . '"}]}';

    $destinations = ['AS', 'PP', 'CRM'];
    $destination = $destinations[rand(0, 2)];

    $query->bindParam(":data", $data, PDO::PARAM_STR);
    $query->bindParam(":destination", $destination, PDO::PARAM_STR);

    return ( $query->execute() );
}

/**
 * @param $data
 * @param $url
 * @return Response
 */
function sendRequest($data, $url) {
    $params = ['data' => $data];
//    $params = 'myParams=myParam';
    $defaults = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => $params
    );

    $ch = curl_init();
    curl_setopt_array($ch, $defaults);
    $response = curl_exec($ch);
//    echo $response;
    curl_close($ch);
    return $response;
}

/**
 * @param $db PDO
 */
function doWork($db) {
    while(checkTables($db)) {
    if (getLastRecord($db, checkTables($db))) {
        print("sending" . getLastRecord($db, checkTables($db))->data . " data to => " . getLastRecord($db, checkTables($db))->destination . "<br>");
//        sendRequest(getLastRecord($db, checkTables($db))->data, $url);
//         if response true, we delete record from db
        deleteLastRecord($db, checkTables($db));
    } else {
        echo 'There are no failed products to send!<br>';
    }
    }
}

/**
 * @param $db PDO
 */
function doWorkOnce($db) {
    $url = 'http://dev.school-server/billing/billing/testResender.php';
//    $url = 'http://10.55.33.38/billing_v1/get_test/test_gen.php';
        if (getLastRecord($db, checkTables($db))) {
            print("sending" . getLastRecord($db, checkTables($db))->data . " data to => " . getLastRecord($db, checkTables($db))->destination . "<br>");
            if (sendRequest(getLastRecord($db, checkTables($db))->data, $url) == Response::HTTP_OK) {
                deleteLastRecord($db, checkTables($db));
            }
        } else {
            echo 'There are no failed products to send!<br>';
        }
}

//var_dump(getLastRecord($db, 'failed_products'));
//var_dump(getLastRecord($db, 'failed_orders'));


function generateTables($db)
{
    $r = rand(20, 40);
    $r2 = rand(5, 20);
    $r3 = rand(10, 20);
    for ($i = 0; $i < $r; $i++) {
        generateRecords($db, 'failed_products');
    }
    for ($i = 0; $i < $r2; $i++) {
        generateRecords($db, 'failed_orders');
    }
    for ($i = 0; $i < $r3; $i++) {
        generateRecords($db, 'failed_refunds');
    }
}
//deleteLastRecord($db, 'failed_products');

//generateTables($db);

//doWork($db);
//doWorkOnce($db);


function getLastProduct2($db){
    $query = $db->prepare("SELECT * FROM products where id=(SELECT MAX(id) FROM products)");
    $query->execute();

    return ( $query->fetch(PDO::FETCH_OBJ) );
}

var_dump(getLastProduct2($db)->name);


