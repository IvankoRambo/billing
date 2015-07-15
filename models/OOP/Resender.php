<?php
namespace OOP;
use \PDO;
//require __DIR__ . "/../../vendor/autoload.php";
require "/../../vendor/autoload.php";
//use Symfony\Component\HttpFoundation\Response;

$localhost = 'http://dev.school-server/billing/billing/testResender.php';


class Resender {

    private $tableName;
    private $data;

    private static $destinations;
    private static $connection;

    public static function init() {
        $connection = ServiceLocator::getConnection(realpath(__DIR__ . '/../../config/db.ini'));
        self::$connection = $connection->getDBSource();

        $destinations = array(
            'AS' => array(
                'urlDomain' => 'http://10.55.33.21/',
                'urlPath' => 'getProducts.php'),
            'PP' => array(
                'urlDomain' => 'http://10.55.33.28',
                'urlPath' => 'billing/GetProductsFromBilling.php'),
            'CRM' => array(
                'urlDomain' => 'http://10.55.33.28',
                'urlPath' => 'billing/GetProductsFromBilling.php'));
    }

    /**
     * @param self::$connection PDO
     * @return string name of table that has records
     */
    public static function checkTables() {
        $products = self::$connection->prepare("SELECT id FROM failed_products");
        $products->execute();

        $orders = self::$connection->prepare("SELECT id FROM failed_orders");
        $orders->execute();

        $refunds = self::$connection->prepare("SELECT id FROM failed_refunds");
        $refunds->execute();

        if (($products->rowCount() > 0)) {
            return 'failed_products';
        } elseif (($orders->rowCount() > 0)) {
            return 'failed_orders';
        } elseif (($refunds->rowCount() > 0)) {
            return 'failed_refunds';
        } else return false;
    }

    /**
     * @param self::$connection PDO
     * @param $tableName string
     * @return object
     */
    public static function getLastRecord($tableName) {
        $sth = self::$connection->prepare("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");
        $sth->execute();

        return $sth->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param self::$connection PDO
     * @param $tableName string
     * @return mixed
     */
    public static function deleteLastRecord($tableName) {
        $query = self::$connection->prepare("DELETE FROM $tableName ORDER BY id DESC LIMIT 1");
//    $query->bindParam(':tableName', $tableName, PDO::PARAM_STR);
        return ($query->execute());
    }

    public static function generateRandomText($quantity) {
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
     * @param self::$connection PDO
     * @param $tableName string
     * @return mixed
     */
    public static function generateRecords($tableName) {
        $query = self::$connection->prepare("INSERT INTO $tableName (data, destination) VALUE (:data, :destination)");
        $data = '{"' . $tableName . '":[{"id":"' . rand(1,30) . '","name":"' . generateRandomText(rand(4,12)) . '","price":"' . rand(100, 1000) . '"}]}';

        $destinations = ['AS', 'PP', 'CRM'];
        $destination = $destinations[rand(0, 2)];

        $query->bindParam(":data", $data, PDO::PARAM_STR);
        $query->bindParam(":destination", $destination, PDO::PARAM_STR);

        return ( $query->execute() );
    }

    public static function generateTables() {
        $r = rand(20, 40);
        $r2 = rand(5, 20);
        $r3 = rand(10, 20);
        for ($i = 0; $i < $r; $i++) {
            generateRecords(self::$connection, 'failed_products');
        }
        for ($i = 0; $i < $r2; $i++) {
            generateRecords(self::$connection, 'failed_orders');
        }
        for ($i = 0; $i < $r3; $i++) {
            generateRecords(self::$connection, 'failed_refunds');
        }
    }


//    public static function send($data, $url) {
//        $params = ['data' => $data];
////    $params = 'myParams=myParam';
//        $defaults = array(
//            CURLOPT_URL => $url,
//            CURLOPT_POST => true,
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_POSTFIELDS => $params
//        );
//
//        $ch = curl_init();
//        curl_setopt_array($ch, $defaults);
//        $response = curl_exec($ch);
//        echo $response;
//        curl_close($ch);
//        return $response;
//    }

// doesn't work ??
    public static function send($data, $urlDomain, $urlPath, $destination) {
        $proxyData = new ProxyData();
        $response = $proxyData->sendData(self::$connection, null, $data, null, null,
            $urlDomain, $urlPath, $destination, 'password');
        echo "var_dump from send in Resender ->";
        var_dump($response);
        return $response;
    }




    /**
     * @param PDO self::$connection
     */
    public static function run() {
        $url = 'http://dev.school-server/testResender.php';
//    $url = 'http://10.55.33.21/without_routing/discard.php';
//        $url = 'http://10.55.33.21/view/Discard/test.php';

        while($tableName = self::checkTables()) {
            $record = self::getLastRecord($tableName);
            if ($record) {
                print("sending" . $record->data . " data to => " . $record->destination . "<br>");
                if (self::send($record->data, self::$destinations[$record->destination]['urlDomain'], self::$destinations['$record->destination']['urlPath'], $record->destination) == 200/*Response::HTTP_OK*/) {
                    self::deleteLastRecord($tableName);
                }
            } else {
                echo 'There are no failed items to send!<br>';
            }
        }
    }
    /**
     * @param PDO self::$connection
     */
    public static function runOnce() {
        $url = 'http://dev.school-server/testResender.php';
//    $url = 'http://10.55.33.21/without_routing/discard.php';
//        $url = 'http://10.55.33.21/view/Discard/test.php';
        $tableName = self::checkTables();
        $record = self::getLastRecord($tableName);
        if ($record) {
            print("sending" . $record->data . " data to => " . $record->destination . "<br>");
//            if (self::send($record->data, self::$destinations[$record->destination]['urlDomain'], self::$destinations['$record->destination']['urlPath'], $record->destination) == 200/*Response::HTTP_OK*/) {
            if (self::send($record->data, 'http://dev.school-server', 'testResender.php', $record->destination) == 200/*Response::HTTP_OK*/) {
                self::deleteLastRecord($tableName);
            } else {
                var_dump(self::send($record->data, 'http://dev.school-server', 'testResender.php', $record->destination));
            }
        } else {
            echo 'There are no failed items to send!<br>';
        }
    }

}


Resender::init();
//Resender::run();
//Resender::runOnce();

$config = parse_ini_file(__DIR__ . '../../config/urls.ini');
var_dump($config);