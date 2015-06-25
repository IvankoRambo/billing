<?php

require __DIR__ . '/Connection.php';

/**
 * Class Product
 */
class Product {
    private static $id;
    private static $name;
    private static $price;
    private static $description;

    private static $connection;

    /**
     * @param int $id
     * @param string $name
     * @param int $price
     * @param string $description
     */
    public static function create($id, $name, $price, $description = null) {
        self::$id = $id;
        self::$name = $name;
        self::$price = $price;
        if (isset($description)) {
            self::$description = $description;
        }

        self::$connection = Connection::getDBSource();
    }


    /**
     * @return int
     */
    public static function getId()
    {
        return self::$id;
    }

    /**
     * @param int $id
     */
    public static function setId($id)
    {
        self::$id = $id;
    }

    /**
     * @return string
     */
    public static function getName()
    {
        return self::$name;
    }

    /**
     * @param string $name
     */
    public static function setName($name)
    {
        self::$name = $name;
    }

    /**
     * @return int
     */
    public static function getPrice()
    {
        return self::$price;
    }

    /**
     * @param int $price
     */
    public static function setPrice($price)
    {
        self::$price = $price;
    }

    /**
     * @return null
     */
    public static function getDescription()
    {
        return self::$description;
    }

    /**
     * @param null $description
     */
    public static function setDescription($description)
    {
        self::$description = $description;
    }

    //---Database---

    public static function getProductByID($id){

        $connection = ServiceLocator::getConnection();
        $db = $connection->getDBSource();

        self::$connection = $db;
        $query = self::$connection->prepare("SELECT * FROM products WHERE id=:id");
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();

        $product = $query->fetch(PDO::FETCH_OBJ);
        self::$id = $product->id;
        self::$name = $product->name;
        self::$price = $product->price;
        if (isset($product->description)) {
            self::$description = $product->desription;
        }
    }



}

var_dump(Product::getProductByID(3));


