<?php
namespace OOP;
use \PDO;

/**
 * Class Product
 */
class Product {
    private $id;
    private $name;
    private $price;
    private $description;

    private static $connection;

    function __construct($name, $price, $description = null, $db=null, $config_path = null)
    {
        $this->name = $name;
        $this->price = $price;
        isset($description) ? $this->description = $description : $this->description = null;
		
		if( !is_null($db) ){
			self::$connection = $db;
			return;
		}
		
		if($config_path){
        $connection = OOP\ServiceLocator::getConnection($config_path);
		}
		else{
		$connection = OOP\ServiceLocator::getConnection(realpath(__DIR__ . '/../../config/db.ini'));	
		}
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

    public static function getProductByID($db ,$id) {
    	self::$connection = $db;
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
	
	public static function get_all($db){
		self::$connection = $db;
		$query = self::$connection->prepare("SELECT * FROM products");
		$query->execute();
	
		return ( $query->fetchAll(PDO::FETCH_ASSOC) );
		
	}
	
	public static function get_last($db){
		self::$connection = $db;
		$query = self::$connection->prepare("SELECT * FROM products where id=(SELECT MAX(id) FROM products)");
		$query->execute();
	
		return ( $query->fetchAll(PDO::FETCH_ASSOC) );
	}
	
	
	public function filterProductsKeys($product_info){
		$keys = [];
		for($i = 0; $i<count($product_info); $i++){
			$keys[] = $product_info[$i]['id'];
		}
		
		return $keys;
	}
	
	public function convertProductsInJSON($products_keys){
		
		$products_keys_str = '';
		
		for($i = 0; $i<count($products_keys); $i++){
			if($i == count($products_keys)-1)	$products_keys_str .= $products_keys[$i];
			else $products_keys_str .= $products_keys[$i].', ';
		}
		
		$query = self::$connection->prepare("SELECT * FROM products where id IN ($products_keys_str)");
		$query->execute();
		
		$JSON_products = array("products" => array());
		$array_products = $query->fetchAll(PDO::FETCH_ASSOC);
		
		
		
		for($i = 0; $i<count($array_products); $i++) $JSON_products['products'][] = $array_products[$i];
		
		return json_encode($JSON_products);
	
	}
	
	public function updateProduct($id) {
		$query = self::$connection->prepare("UPDATE products SET name=:name, price=:price, description=:description WHERE id=:id");
		$price = $this->getPrice();
		$price = (string)$price;
		$name = $this->getName();
		$description = $this->getDescription();
		$query->bindParam(':name', $name, PDO::PARAM_STR);
		$query->bindParam(':price', $price, PDO::PARAM_STR);
		$query->bindParam(":description", $description, PDO::PARAM_STR);
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		return ($query->execute());
	}
	
	function deleteProduct($id) {
		$query = self::$connection->prepare('DELETE FROM products WHERE id=:id');
		$query->bindParam(':id', $id, PDO::PARAM_INT);
		return ($query->execute());
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

/*$product = new Product('Super product', 150, 'Best product ever');
$product2 = Product::getProductByID(5);
var_dump($product);
var_dump($product2);
$product->add();*/

// TODO encode to json and send to AS
// {"products":[{"id":"1","name":"Some Ant","price":"123"},{"id":"3","name":"Lost Good","price":"66"}]}