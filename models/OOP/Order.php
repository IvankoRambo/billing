<?php
namespace OOP;

// use OOP\ServiceLocator;

class Order {
    private $order_id;
    private $product_id;
    private $product_quantity;
    private $card_name;
    private $sum;
    private $keys;
    private $date;
    private $user_id;

    private static $connection;

    function __construct($order_id, $product_id = null, $product_quantity = null, 
        $card_name = null, $sum = null, $keys = null, $date = null, $user_id = null)
    {
        $connection = ServiceLocator::getConnection(realpath(__DIR__ . '/../../config/db.ini'));
        self::$connection = $connection->getDBSource();
        
        if (is_null($product_id)) {
            $order_obj = $order_id;
            
            $this->order_id = $order_obj->order_id;
            $this->product_id = $order_obj->product_id;
            $this->product_quantity = $order_obj->product_quantity;
            $this->card_name = $order_obj->card_name;
            $this->sum = $order_obj->sum;
            $this->user_id = $order_obj->user_id;
            $this->keys = $order_obj->keys;
            $this->date = $order_obj->date;
            return;    
        }


        $this->order_id = $order_id;
        $this->product_id = $product_id;
        $this->product_quantity = $product_quantity;
        $this->card_name = $card_name;
        $this->sum = $sum;
        $this->keys = $keys;
        $this->date = $date;
        isset($user_id) ? $this->user_id = $user_id : $this->user_id = null;

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
        $query->bindParam(":id", $id, \PDO::PARAM_INT);
        $query->execute();

        $order = $query->fetch(\PDO::FETCH_OBJ);
        return ($query->execute($data)) ? true : false;
    }

    public function postOrder() {
        $logging = new Logging(__DIR__.'/../../logs/orders_log');
        $erroring = new Logging(__DIR__.'/../../logs/orders_error');

        $db = self::$connection;
        $order_id = $this->order_id;
        $product_id = $this->product_id;
        $product_quantity = $this->product_quantity;
        $card_name = $this->card_name;
        $sum = $this->sum;
        $keys = $this->keys;
        $date = $this->date;
        $user_id = $this->user_id;
           

        $tables = array('orders', 'orders_log');
        foreach ($tables as $table) {   
            $query = $db->prepare("INSERT INTO `$table`".
                '(`order_id`, `product_id`, `product_quantity`, `card_name`, `sum`, `date`, `user_id`)'.
                'VALUES'.
                '(:order_id, :product_id, :product_quantity, :card_name, :sum, :date, :user_id)');
            $query->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
            $query->bindParam(':product_id', $product_id, \PDO::PARAM_INT);
            $query->bindParam(':product_quantity', $product_quantity, \PDO::PARAM_INT);
            $query->bindParam(':card_name', $card_name, \PDO::PARAM_STR);
            $query->bindParam(':sum', $sum, \PDO::PARAM_INT);
            $query->bindParam(':date', $date, \PDO::PARAM_STR);
            $query->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
            $res = $query->execute();
            
            if (!$res) {
                $erroring->insertIntoLogFile( 
                    'Unsuccessful adding order to database table '.$table.'. Error message:'.
                    $query->errorInfo()[2], 
                    date('Y-m-d H:i:s', time()));
                $error = $query->errorInfo();
                $res = array(
                    'code' => $error[0],
                    'data' => $error[2]);
                return json_encode($res);

            } else {
                $logging->insertIntoLogFile( 
                    'Successful adding order to database table '.$table, 
                    date('Y-m-d H:i:s', time()));
            }
        }
        // echo $res? "True" : "False";

        $query_str = 'INSERT INTO `order_keys`'.
                     '(`order_id`, `key_id`)'.
                     'VALUES';
        $keys_count = count($keys);
        for ($i = 1; $i < $keys_count; $i++) {
            $query_str = $query_str."(:order_id, :key_id$i), ";
        }
        $query_str = $query_str."(:order_id, :key_id$keys_count);";
        
        // print($query_str);

        $query = $db->prepare($query_str);
        
        $i = 1;
        $query->bindParam(':order_id', $order_id, \PDO::PARAM_INT);
        foreach ($keys as $key) {
            // echo "<br>";
            // print($i.' - '.$key);
            $query->bindValue(':key_id'.$i, $key, \PDO::PARAM_INT);
            $i++;
        }
        // echo '<br>';
        // print($query->queryString);


        $res = $query->execute();

        // echo $res? "True" : "False";
        if (!$res) {
            $erroring->insertIntoLogFile( 
                    'Unsuccessful adding order and keys to database table order_keys. Error message: '.
                    $query->errorInfo()[2], 
                    date('Y-m-d H:i:s', time()));
            $error = $query->errorInfo();
            $res = array(
                'code' => $error[0],
                'data' => $error[2]);
            return json_encode($res);
        } else {
            $logging->insertIntoLogFile( 
                    'Successful adding order and keys to database table order_keys', 
                    date('Y-m-d H:i:s', time()));
        }
        
        return json_encode(array(
            'code' => 1, 
            'data' => 'OK', 
            'order_id' => $order_id));
        
    }

    public function sendOrder() {
        $logging = new Logging(realpath(__DIR__.'/../../logs/orders_log'));
        $erroring = new Logging(realpath(__DIR__.'/../../logs/orders_error'));


        $db = self::$connection;
        $order_id = $this->order_id;
        // $product_id = $this->product_id;
        // $product_quantity = $this->product_quantity;
        // $card_name = $this->card_name;
        $sum = $this->sum;
        $keys = $this->keys;
        // $date = $this->date;
        $user_id = $this->user_id;

        $res = '';
        
        // function sendData($db, $key_info ,$info, $address, $secret_key = null) 
        // AccountService/AS/test_getOrderId.php') ; -------------------------------
        
            
        $proxyData = new ProxyData();

        $data = array(
         // 'order_id' => $order_id,
            'keys' => $keys
        );
        // $res1 = sendData($db, 'orders', json_encode($data), 'http://10.55.33.34/mark');
        $res1 = $proxyData->sendData($db, 'orders', json_encode($data), null, null, 
            'http://10.55.33.21/', 'mark', 'AccountService', 'password');
        if (!$res1 || preg_match('/not found/', $res1)) {
            $erroring->insertIntoLogFile( 
                    'Unsuccessful sending order and keys to account service: '.$res1, 
                    date('Y-m-d H:i:s', time()));
        } else {
            $logging->insertIntoLogFile( 
                    'Successful sending order and keys to account service: '.$res1, 
                    date('Y-m-d H:i:s', time()));
        }
        $res .= 'Account Service result:<br>';
        $res .= $res1;
        

        // CRM ----------------------------------------------------------------------------
        $data = array(
            'order_id' => $order_id,
            'keys' => $keys,
            'sum' => $sum,
            'user_id' => $user_id
        );
        $res1 = $proxyData->sendData($db, 'orders', json_encode($data), null, null, 
            'http://10.55.33.27/', 'order/add',
            'CRM', '1');
        // echo $res1;
        if ($res1 != 'Success' || preg_match('/not found/', $res1)) {
            $erroring->insertIntoLogFile( 
                    'Unsuccessful sending order and keys to CRM: '. $res1, 
                    date('Y-m-d H:i:s', time()));
        } else {
            $logging->insertIntoLogFile( 
                    'Successful sending order and keys to CRM: '.$res1,
                    date('Y-m-d H:i:s', time()));
        }
        $res .= 'CRM result:<br>';
        $res .= $res1;

        //----------------------------------------------------------------------------------

        return $res;
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

// {"order_id":"85","product_id":"asd12322","product_quantity":3,"card_name":"1234567887654321","sum":"254",
// "keys":"123123123123,23452345234523523452345,23452345234523421234","date":"2015-06-19 17:16:12","user_id":"1234567812345678"}



// $order = new Order(4, 2, 3, 'BR25522', 100, 5);
//var_dump($order->getOrderByID(6));
//var_dump($order);
//var_dump(array($order));
// echo $order->add2();



