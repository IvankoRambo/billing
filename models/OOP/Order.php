<?php
require "../../vendor/autoload.php";

class Order {
    private $order_id;
    private $product_id;
    private $product_quantity;
    private $card_name;
    private $sum;
    private $user_id;

    private static $connection;

    function __construct($order_id, $product_id, $product_quantity, $card_name, $sum, $user_id = null)
    {
        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->product_quantity = $product_quantity;
        $this->card_name = $card_name;
        $this->sum = $sum;
        isset($user_id) ? $this->user_id = $user_id : $this->user_id = null;

        $connection = ServiceLocator::getConnection(realpath(__DIR__ . '/../../config/db.ini'));
        self::$connection = $connection->getDBSource();
    }


    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->order_id;
    }

    /**
     * @param mixed $order_id
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->product_id;
    }

    /**
     * @param mixed $product_id
     */
    public function setProductId($product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return mixed
     */
    public function getProductQuantity()
    {
        return $this->product_quantity;
    }

    /**
     * @param mixed $product_quantity
     */
    public function setProductQuantity($product_quantity)
    {
        $this->product_quantity = $product_quantity;
    }

    /**
     * @return mixed
     */
    public function getCardName()
    {
        return $this->card_name;
    }

    /**
     * @param mixed $card_name
     */
    public function setCardName($card_name)
    {
        $this->card_name = $card_name;
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param mixed $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }


    public function add(){
        $query = self::$connection->prepare("INSERT INTO orders (order_id, product_id, product_quantity, card_name, sum, user_id)
                                             VALUES (:order_id, :product_id, :product_quantity, :card_name, :sum, :user_id)");
        $data = array('order_id' => $this->getOrderId(),
                      'product_id' => $this->getProductId(),
                      'product_quantity' => $this->getProductQuantity(),
                      'card_name' => $this->getCardName(),
                      'sum' => $this->getSum(),
                      'user_id' => $this->getUserId());
        return ($query->execute($data)) ? true : false;
    }

    public function getOrderByID($id) {
        $query = self::$connection->prepare("SELECT * FROM orders WHERE id=:id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();

        $order = $query->fetch(PDO::FETCH_OBJ);
        return ($query->execute($data)) ? true : false;
    }

}


// TODO Get and parse this data from PP
//$bdata = array('order_id' => $data['id'],
//    'product_id' => $data['product_id'],
//    'product_quantity' => count(explode(',',$data['product_keys_id'])),
//    'card_name' => $data['from_card_number'],
//    'sum' => $data['amount'],
//    'keys' => $data['product_keys_id'],
//    'date' => $data['bank_transaction_date'],
//    'user_id' => $data['client_as_id']);



$order = new Order(4, 2, 3, 'BR25522', 100, 5);
//var_dump($order->getOrderByID(6));
//var_dump($order);
//var_dump(array($order));
echo $order->add2();



