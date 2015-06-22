<?php
require __DIR__ . '/db_work.php';
$db = getConnection(__DIR__.'/config/db.ini');


// URLs
$AS = 'localhost';
$PP = 'localhost';
$CRM = 'localhost';
$destinations = array('AS' => 'AccountService',
                      'PP' => 'Payment Processor');

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

function generateRecords($db, $tableName) {
    $query = $db->prepare("INSERT INTO $tableName (data, destination) VALUE (:data, :destination)");
    $data = '{"products":[{"id":"' . rand(1,30) . '","name":"' . generateRandomText(rand(4,12)) . '","price":"' . rand(100, 1000) . '"}]}';

    $destinations = ['AS', 'PP', 'CRM'];
    $destination = $destinations[rand(0, 2)];

    $query->bindParam(":data", $data, PDO::PARAM_STR);
    $query->bindParam(":destination", $destination, PDO::PARAM_STR);

    return ( $query->execute() );
}

/**
 * @param $data
 * @param $url
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
    echo $response;
    curl_close($ch);
}

/**
 * @param $db PDO
 */
function doWork($db) {
    while(checkTables($db)) {
    if (getLastRecord($db, checkTables($db))) {
        print("sending data to => " . getLastRecord($db, checkTables($db))->destination . "<br>");
//        sendRequest(getLastRecord($db, checkTables($db))->data, $localhost);
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
    $localhost = 'http://dev.school-server/billing/billing/testResender.php';
//    while(checkTables($db)) {
        if (getLastRecord($db, checkTables($db))) {
            print("sending data to => " . getLastRecord($db, checkTables($db))->destination . "<br>");
            sendRequest(getLastRecord($db, checkTables($db))->data, $localhost);
//         if response true, we delete record from db
            deleteLastRecord($db, checkTables($db));
        } else {
            echo 'There are no failed products to send!<br>';
        }
//    }
}

//var_dump(getLastRecord($db, 'failed_products'));
//var_dump(getLastRecord($db, 'failed_orders'));

//generateRecords($db, 'failed_products');
//deleteLastRecord($db, 'failed_products');

//doWork($db);
//doWorkOnce($db);
