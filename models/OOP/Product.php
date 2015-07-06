<?php
require "../../vendor/autoload.php";

/**
 * Class Product
 */
class Product {
    private $id;
    private $name;
    private $price;
    private $description;

    private static $connection;

    function __construct($name, $price, $description = null)
    {
        $this->name = $name;
        $this->price = $price;
        isset($description) ? $this->description = $description : $this->description = null;

        $connection = OOP\ServiceLocator::getConnection(realpath(__DIR__ . '/../../config/db.ini'));
        self::$connection = $connection->getDBSource();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    //---Database---

    public static function getProductByID($id) {
        $query = self::$connection->prepare("SELECT * FROM products WHERE id=:id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();

        $product = $query->fetch(PDO::FETCH_OBJ);
        return $product;
    }

    public function add(){
        $query = self::$connection->prepare("INSERT INTO products (name, price, description) VALUES (:name, :price, :description)");

        $data = array('name' => $this->getName(),
                      'price' => $this->getPrice(),
                      'description' => $this->getDescription());
        return ($query->execute($data)) ? true : false;
    }

//    public function add2(){
//        $query = self::$connection->prepare("INSERT INTO products (name, price, description) VALUES (?, ? ,?)");
//
//        $data = array($this->getName(), $this->getPrice(), $this->getDescription());
//        return ($query->execute($data)) ? true : false;
//    }
//
//    public function add3(){
//        $query = self::$connection->prepare("INSERT INTO products (name, price, description) VALUES (:name, :price, :description)");
//        $query->bindParam(":name", $name, PDO::PARAM_STR);
//        $query->bindParam(":price", $price, PDO::PARAM_INT);
//        $query->bindParam(":description", $description, PDO::PARAM_STR);
//
//        return ( $query->execute() ) ? true : false;
//    }

}

$product = new Product('Super product', 150, 'Best product ever');
$product2 = Product::getProductByID(5);
var_dump($product);
var_dump($product2);
$product->add();

// TODO encode to json and send to AS
// {"products":[{"id":"1","name":"Some Ant","price":"123"},{"id":"3","name":"Lost Good","price":"66"}]}