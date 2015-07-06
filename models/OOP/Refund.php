<?php
require "../../vendor/autoload.php";

/**
 * Class Refund
 */
class Refund {
    private $id;
    private $order_id;
    private $product_id;
    private $product_quantity;
    private $refund_sum;
    private $date;

    private static $connection;

    function __construct($id, $order_id, $product_id, $product_quantity, $refund_sum, $date = null)
    {
        $this->id = $id;
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->product_quantity = $product_quantity;
        $this->refund_sum = $refund_sum;

        isset($date) ? $this->date = $date : $this->date = null;

        $connection = ServiceLocator::getConnection(realpath(__DIR__ . '/../../config/db.ini'));
        self::$connection = $connection->getDBSource();

    }


    //---Database---

    public static function getRefundByID($id) {
        $query = self::$connection->prepare("SELECT * FROM refunds WHERE id=:id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();

        $product = $query->fetch(PDO::FETCH_OBJ);
        return $product;
    }

    public function add(){
        $query = self::$connection->prepare("INSERT INTO refunds (id, order_id, product_id, product_quantity, refund_sum, date)
                                             VALUES (:id, :order_id, :product_id, :product_quantity, :refund_sum, :date)");

        $data = array('name' => $this->getName(),
                      'price' => $this->getPrice(),
                      'price' => $this->getPrice(),
                      'price' => $this->getPrice(),
                      'price' => $this->getPrice(),
                      'description' => $this->getDescription());
        return ($query->execute($data)) ? true : false;
    }


// TODO get and parse this data from CRM
//    refund_id
//    keys = array() ["key_id" : "status"] //status: 1 -> cancel, 0 -> not
//    percent

}




