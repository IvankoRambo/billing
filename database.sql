-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: 10.55.33.38    Database: billing
-- ------------------------------------------------------
-- Server version	5.5.43-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Valyk','kolaider'),(3,'Ruslanchik','*A4B6157319038724E3560894F7F932C8886EBFCF'),(6,'Asia','*19234910EE8B85CB372BEA4AEEF714187E3012A1'),(9,'Milochka','kolaider');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_orders`
--

DROP TABLE IF EXISTS `failed_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_orders`
--

LOCK TABLES `failed_orders` WRITE;
/*!40000 ALTER TABLE `failed_orders` DISABLE KEYS */;
INSERT INTO `failed_orders` VALUES (1,'{\"order_id\":843,\"keys\":[984,766,548,252]}','http://10.55.33.34/test_getOrderId.php');
/*!40000 ALTER TABLE `failed_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_products`
--

DROP TABLE IF EXISTS `failed_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
<<<<<<< HEAD
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
=======
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
>>>>>>> zeoorigin/dev
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_products`
--

LOCK TABLES `failed_products` WRITE;
/*!40000 ALTER TABLE `failed_products` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `failed_products` VALUES (1,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"}]}','http://10.55.33.34/getProducts.php'),(2,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php'),(3,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"}]}','http://10.55.33.34/get_products.php'),(4,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"}]}','http://10.55.33.28/billing/GetProductsFromBilling.'),(5,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php'),(6,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"},{\"id\":\"39\",\"name\":\"rwer\",\"price\":\"124.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php'),(7,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"},{\"id\":\"39\",\"name\":\"rwer\",\"price\":\"124.0000\",\"description\":\"12\"},{\"id\":\"40\",\"name\":\"rrsr\",\"price\":\"0.0000\",\"description\":\"1242\"}]}','http://10.55.33.34/get_products.php'),(8,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"},{\"id\":\"39\",\"name\":\"rwer\",\"price\":\"124.0000\",\"description\":\"12\"},{\"id\":\"40\",\"name\":\"rrsr\",\"price\":\"0.0000\",\"description\":\"1242\"},{\"id\":\"41\",\"name\":\"Losty\",\"price\":\"141.0000\",\"description\":\"1231\"}]}','http://10.55.33.34/get_products.php'),(9,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"},{\"id\":\"39\",\"name\":\"rwer\",\"price\":\"124.0000\",\"description\":\"12\"},{\"id\":\"40\",\"name\":\"rrsr\",\"price\":\"0.0000\",\"description\":\"1242\"},{\"id\":\"41\",\"name\":\"Losty\",\"price\":\"141.0000\",\"description\":\"1231\"},{\"id\":\"42\",\"name\":\"eqwe\",\"price\":\"142.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php');
=======
INSERT INTO `failed_products` VALUES (1,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"}]}','http://10.55.33.34/getProducts.php'),(2,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php'),(3,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"}]}','http://10.55.33.34/get_products.php'),(4,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"}]}','http://10.55.33.28/billing/GetProductsFromBilling.'),(5,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php'),(6,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"},{\"id\":\"39\",\"name\":\"rwer\",\"price\":\"124.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php');
>>>>>>> zeoorigin/dev
/*!40000 ALTER TABLE `failed_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_refunds`
--

DROP TABLE IF EXISTS `failed_refunds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_refunds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `destination` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_refunds`
--

LOCK TABLES `failed_refunds` WRITE;
/*!40000 ALTER TABLE `failed_refunds` DISABLE KEYS */;
INSERT INTO `failed_refunds` VALUES (1,'[\"3\",\"4\"]','http://10.55.33.34/cancelKey.php');
/*!40000 ALTER TABLE `failed_refunds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_keys`
--

DROP TABLE IF EXISTS `order_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `key_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_id_index` (`key_id`)
) ENGINE=InnoDB AUTO_INCREMENT=442 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_keys`
--

LOCK TABLES `order_keys` WRITE;
/*!40000 ALTER TABLE `order_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `card_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sum` decimal(20,5) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=880 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` decimal(10,4) DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_index` (`name`)
<<<<<<< HEAD
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
=======
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
>>>>>>> zeoorigin/dev
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
<<<<<<< HEAD
INSERT INTO `products` VALUES (1,'Product2',11.0000,NULL),(9,'NProd',101.0000,NULL),(10,'Prod',49.0000,NULL),(11,'Lol',123.0000,NULL),(14,'Prod155',124.0000,NULL),(34,'TestPro',12.1200,'Desdc'),(35,'dsf',12.0000,'qw'),(36,'sda',123.0000,'12'),(37,'Milka',525.3200,'Valflepe'),(38,'dasd',11.0000,'12'),(39,'rwer',124.0000,'12'),(40,'rrsr',0.0000,'1242'),(41,'Losty',141.0000,'1231'),(42,'eqwe',142.0000,'12');
=======
INSERT INTO `products` VALUES (1,'Product2',11.0000,NULL),(9,'NProd',101.0000,NULL),(10,'Prod',49.0000,NULL),(11,'Lol',123.0000,NULL),(14,'Prod155',124.0000,NULL),(34,'TestPro',12.1200,'Desdc'),(35,'dsf',12.0000,'qw'),(36,'sda',123.0000,'12'),(37,'Milka',525.3200,'Valflepe'),(38,'dasd',11.0000,'12'),(39,'rwer',124.0000,'12');
>>>>>>> zeoorigin/dev
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_keys`
--

DROP TABLE IF EXISTS `refund_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_refund` int(11) NOT NULL,
  `canceled_keys` int(11) NOT NULL,
  `id_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_keys`
--

LOCK TABLES `refund_keys` WRITE;
/*!40000 ALTER TABLE `refund_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `refund_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refunds`
--

DROP TABLE IF EXISTS `refunds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refunds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `num_keys` int(11) NOT NULL,
  `percent` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refunds`
--

LOCK TABLES `refunds` WRITE;
/*!40000 ALTER TABLE `refunds` DISABLE KEYS */;
/*!40000 ALTER TABLE `refunds` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

<<<<<<< HEAD
-- Dump completed on 2015-06-19 19:53:38
=======
-- Dump completed on 2015-06-19 19:40:48
>>>>>>> zeoorigin/dev
