-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: billing
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_products`
--

LOCK TABLES `failed_products` WRITE;
/*!40000 ALTER TABLE `failed_products` DISABLE KEYS */;
INSERT INTO `failed_products` VALUES (1,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"}]}','http://10.55.33.34/getProducts.php'),(2,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php'),(3,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"}]}','http://10.55.33.34/get_products.php'),(4,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"}]}','http://10.55.33.28/billing/GetProductsFromBilling.'),(5,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php'),(6,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"},{\"id\":\"39\",\"name\":\"rwer\",\"price\":\"124.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php'),(7,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"},{\"id\":\"39\",\"name\":\"rwer\",\"price\":\"124.0000\",\"description\":\"12\"},{\"id\":\"40\",\"name\":\"rrsr\",\"price\":\"0.0000\",\"description\":\"1242\"}]}','http://10.55.33.34/get_products.php'),(8,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"},{\"id\":\"39\",\"name\":\"rwer\",\"price\":\"124.0000\",\"description\":\"12\"},{\"id\":\"40\",\"name\":\"rrsr\",\"price\":\"0.0000\",\"description\":\"1242\"},{\"id\":\"41\",\"name\":\"Losty\",\"price\":\"141.0000\",\"description\":\"1231\"}]}','http://10.55.33.34/get_products.php'),(9,'{\"products\":[{\"id\":\"1\",\"name\":\"Product2\",\"price\":\"11.0000\",\"description\":null},{\"id\":\"9\",\"name\":\"NProd\",\"price\":\"101.0000\",\"description\":null},{\"id\":\"10\",\"name\":\"Prod\",\"price\":\"49.0000\",\"description\":null},{\"id\":\"11\",\"name\":\"Lol\",\"price\":\"123.0000\",\"description\":null},{\"id\":\"14\",\"name\":\"Prod155\",\"price\":\"124.0000\",\"description\":null},{\"id\":\"34\",\"name\":\"TestPro\",\"price\":\"12.1200\",\"description\":\"Desdc\"},{\"id\":\"35\",\"name\":\"dsf\",\"price\":\"12.0000\",\"description\":\"qw\"},{\"id\":\"36\",\"name\":\"sda\",\"price\":\"123.0000\",\"description\":\"12\"},{\"id\":\"37\",\"name\":\"Milka\",\"price\":\"525.3200\",\"description\":\"Valflepe\"},{\"id\":\"38\",\"name\":\"dasd\",\"price\":\"11.0000\",\"description\":\"12\"},{\"id\":\"39\",\"name\":\"rwer\",\"price\":\"124.0000\",\"description\":\"12\"},{\"id\":\"40\",\"name\":\"rrsr\",\"price\":\"0.0000\",\"description\":\"1242\"},{\"id\":\"41\",\"name\":\"Losty\",\"price\":\"141.0000\",\"description\":\"1231\"},{\"id\":\"42\",\"name\":\"eqwe\",\"price\":\"142.0000\",\"description\":\"12\"}]}','http://10.55.33.34/get_products.php');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_refunds`
--

LOCK TABLES `failed_refunds` WRITE;
/*!40000 ALTER TABLE `failed_refunds` DISABLE KEYS */;
INSERT INTO `failed_refunds` VALUES (1,'[\"3\",\"4\"]','http://10.55.33.34/cancelKey.php'),(2,'[\"3\",\"4\"]','http://10.55.33.34/cancelKey.php');
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
) ENGINE=InnoDB AUTO_INCREMENT=236 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_keys`
--

LOCK TABLES `order_keys` WRITE;
/*!40000 ALTER TABLE `order_keys` DISABLE KEYS */;
INSERT INTO `order_keys` VALUES (1,2,3),(2,3,4),(3,3,5),(4,95,532),(5,95,943),(6,95,302),(7,95,211),(8,762,769),(9,762,47),(10,762,731),(11,762,416),(12,410,263),(13,410,713),(14,410,378),(15,410,451),(16,961,711),(17,961,74),(18,961,836),(19,961,936),(20,939,267),(21,939,441),(22,939,354),(23,939,148),(24,840,810),(25,840,976),(26,840,274),(27,840,325),(32,833,650),(33,833,409),(34,833,838),(35,833,242),(36,470,430),(37,470,172),(38,470,862),(39,470,438),(40,283,906),(41,283,646),(42,283,505),(43,283,239),(44,430,200),(45,430,401),(46,430,477),(47,430,931),(48,88,962),(49,88,955),(50,88,665),(51,88,633),(52,964,891),(53,964,526),(54,964,38),(55,964,727),(56,273,140),(57,273,768),(58,273,757),(59,273,293),(60,922,567),(61,922,271),(62,922,897),(63,922,840),(64,39,216),(65,39,370),(66,39,568),(67,39,305),(68,714,705),(69,714,191),(70,714,763),(71,714,203),(72,428,868),(73,428,309),(74,428,334),(75,428,513),(76,307,458),(77,307,594),(78,307,599),(79,307,257),(92,763,144),(93,763,826),(94,763,256),(95,763,981),(96,384,363),(97,384,582),(98,384,56),(99,384,251),(100,852,684),(101,852,848),(102,852,161),(103,852,17),(104,600,590),(105,600,575),(106,600,248),(107,600,554),(108,361,975),(109,361,589),(110,361,607),(111,361,876),(124,278,595),(125,278,954),(126,278,872),(127,278,193),(128,401,204),(129,401,604),(130,401,522),(131,401,465),(136,81,237),(137,81,439),(138,81,262),(139,81,143),(148,828,803),(149,828,538),(150,828,676),(151,828,963),(164,813,265),(165,813,450),(166,813,253),(167,813,553),(168,62,236),(169,62,878),(170,62,612),(171,62,76),(176,845,13),(177,845,280),(178,845,449),(179,845,534),(184,744,528842),(185,744,769790),(186,744,182543),(187,744,790174),(188,609,472122),(189,609,544268),(190,609,455581),(191,609,423030),(192,912,357231),(193,912,434973),(194,912,417026),(195,912,113903),(196,399,283022),(197,399,225483),(198,399,935990),(199,399,958206),(200,136,172097),(201,136,469806),(202,136,425696),(203,136,501841),(204,189,490097),(205,189,993429),(206,189,125530),(207,189,632684),(208,636,937738),(209,636,897293),(210,636,84209),(211,636,190323),(212,734,336208),(213,734,774862),(214,734,676097),(215,734,638079),(216,451,30219),(217,451,720585),(218,451,597484),(219,451,930155),(220,986,838340),(221,986,47086),(222,986,247894),(223,986,550406),(224,123,937388),(225,123,40349),(226,123,28183),(227,123,283924),(228,425,698571),(229,425,171873),(230,425,362548),(231,425,965121),(232,987,636954),(233,987,756046),(234,987,530653),(235,987,92534);
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
) ENGINE=InnoDB AUTO_INCREMENT=988 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (39,1,4,'BR25522',100.00000,14,'2015-06-22 19:53:26'),(62,1,4,'BR25522',100.00000,0,'2015-06-22 20:05:53'),(81,1,4,'BR25522',100.00000,0,'2015-06-22 20:02:30'),(88,1,4,'BR25522',100.00000,49,'2015-06-22 19:20:50'),(95,1,4,'BR25522',100.00000,17,'2015-06-22 18:55:06'),(99,1,4,'BR25522',100.00000,0,'2015-06-22 20:00:24'),(123,1,4,'BR25522',100.00000,0,'2015-06-22 20:00:32'),(126,1,4,'BR25522',100.00000,0,'2015-06-22 20:02:38'),(136,1,4,'BR25522',100.00000,0,'2015-06-22 20:10:08'),(175,1,4,'BR25522',100.00000,0,'2015-06-22 20:03:11'),(189,1,4,'BR25522',100.00000,0,'2015-06-22 20:12:58'),(211,1,4,'BR25522',100.00000,0,'2015-06-22 20:02:27'),(273,1,4,'BR25522',100.00000,80,'2015-06-22 19:35:31'),(278,1,4,'BR25522',100.00000,0,'2015-06-22 20:00:34'),(283,1,4,'BR25522',100.00000,74,'2015-06-22 19:19:38'),(307,1,4,'BR25522',100.00000,0,'2015-06-22 19:56:25'),(340,1,4,'BR25522',100.00000,0,'2015-06-22 20:08:00'),(361,1,4,'BR25522',100.00000,0,'2015-06-22 19:59:50'),(364,1,4,'BR25522',100.00000,0,'2015-06-22 19:57:31'),(384,1,4,'BR25522',100.00000,0,'2015-06-22 19:58:08'),(398,1,4,'BR25522',100.00000,0,'2015-06-22 20:00:33'),(399,1,4,'BR25522',100.00000,0,'2015-06-22 20:09:44'),(401,1,4,'BR25522',100.00000,0,'2015-06-22 20:01:19'),(410,1,4,'BR25522',100.00000,63,'2015-06-22 18:55:26'),(425,1,4,'BR25522',100.00000,0,'2015-06-22 20:22:18'),(428,1,4,'BR25522',100.00000,0,'2015-06-22 19:56:03'),(430,1,4,'BR25522',100.00000,82,'2015-06-22 19:20:34'),(451,1,4,'BR25522',100.00000,0,'2015-06-22 20:17:42'),(470,1,4,'BR25522',100.00000,64,'2015-06-22 19:08:34'),(555,1,4,'BR25522',100.00000,0,'2015-06-22 20:04:03'),(600,1,4,'BR25522',100.00000,0,'2015-06-22 19:59:29'),(609,1,4,'BR25522',100.00000,0,'2015-06-22 20:08:51'),(633,1,4,'BR25522',100.00000,0,'2015-06-22 19:57:34'),(636,1,4,'BR25522',100.00000,0,'2015-06-22 20:15:59'),(714,1,4,'BR25522',100.00000,0,'2015-06-22 19:54:30'),(716,1,4,'BR25522',100.00000,0,'2015-06-22 19:57:35'),(734,1,4,'BR25522',100.00000,0,'2015-06-22 20:17:31'),(744,1,4,'BR25522',100.00000,0,'2015-06-22 20:08:39'),(756,1,4,'BR25522',100.00000,0,'2015-06-22 20:03:58'),(762,1,4,'BR25522',100.00000,49,'2015-06-22 18:55:20'),(763,1,4,'BR25522',100.00000,0,'2015-06-22 19:57:36'),(813,1,4,'BR25522',100.00000,0,'2015-06-22 20:04:06'),(828,1,4,'BR25522',100.00000,0,'2015-06-22 20:03:11'),(833,1,4,'BR25522',100.00000,25,'2015-06-22 19:08:13'),(840,1,4,'BR25522',100.00000,82,'2015-06-22 18:56:41'),(844,1,4,'BR25522',100.00000,0,'2015-06-22 20:04:05'),(845,1,4,'BR25522',100.00000,0,'2015-06-22 20:07:49'),(852,1,4,'BR25522',100.00000,0,'2015-06-22 19:58:35'),(866,1,4,'BR25522',100.00000,9,'2015-06-22 19:08:07'),(912,1,4,'BR25522',100.00000,0,'2015-06-22 20:09:35'),(922,1,4,'BR25522',100.00000,60,'2015-06-22 19:36:01'),(939,1,4,'BR25522',100.00000,93,'2015-06-22 18:55:59'),(947,1,4,'BR25522',100.00000,0,'2015-06-22 20:05:57'),(961,1,4,'BR25522',100.00000,89,'2015-06-22 18:55:33'),(964,1,4,'BR25522',100.00000,47,'2015-06-22 19:21:28'),(986,1,4,'BR25522',100.00000,0,'2015-06-22 20:19:50'),(987,1,4,'BR25522',100.00000,0,'2015-06-22 20:22:47');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders_log`
--

DROP TABLE IF EXISTS `orders_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_log` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `card_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `sum` decimal(20,5) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=988 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders_log`
--

LOCK TABLES `orders_log` WRITE;
/*!40000 ALTER TABLE `orders_log` DISABLE KEYS */;
INSERT INTO `orders_log` VALUES (39,1,4,'BR25522',100.00000,14,'2015-06-22 19:53:26'),(62,1,4,'BR25522',100.00000,0,'2015-06-22 20:05:53'),(81,1,4,'BR25522',100.00000,0,'2015-06-22 20:02:30'),(88,1,4,'BR25522',100.00000,49,'2015-06-22 19:20:50'),(95,1,4,'BR25522',100.00000,17,'2015-06-22 18:55:06'),(99,1,4,'BR25522',100.00000,0,'2015-06-22 20:00:24'),(123,1,4,'BR25522',100.00000,0,'2015-06-22 20:00:32'),(126,1,4,'BR25522',100.00000,0,'2015-06-22 20:02:38'),(136,1,4,'BR25522',100.00000,0,'2015-06-22 20:10:08'),(175,1,4,'BR25522',100.00000,0,'2015-06-22 20:03:11'),(189,1,4,'BR25522',100.00000,0,'2015-06-22 20:12:58'),(211,1,4,'BR25522',100.00000,0,'2015-06-22 20:02:27'),(273,1,4,'BR25522',100.00000,80,'2015-06-22 19:35:31'),(278,1,4,'BR25522',100.00000,0,'2015-06-22 20:00:34'),(283,1,4,'BR25522',100.00000,74,'2015-06-22 19:19:38'),(307,1,4,'BR25522',100.00000,0,'2015-06-22 19:56:25'),(340,1,4,'BR25522',100.00000,0,'2015-06-22 20:08:00'),(361,1,4,'BR25522',100.00000,0,'2015-06-22 19:59:50'),(364,1,4,'BR25522',100.00000,0,'2015-06-22 19:57:31'),(384,1,4,'BR25522',100.00000,0,'2015-06-22 19:58:08'),(398,1,4,'BR25522',100.00000,0,'2015-06-22 20:00:33'),(399,1,4,'BR25522',100.00000,0,'2015-06-22 20:09:44'),(401,1,4,'BR25522',100.00000,0,'2015-06-22 20:01:19'),(410,1,4,'BR25522',100.00000,63,'2015-06-22 18:55:26'),(425,1,4,'BR25522',100.00000,0,'2015-06-22 20:22:18'),(428,1,4,'BR25522',100.00000,0,'2015-06-22 19:56:03'),(430,1,4,'BR25522',100.00000,82,'2015-06-22 19:20:34'),(451,1,4,'BR25522',100.00000,0,'2015-06-22 20:17:42'),(470,1,4,'BR25522',100.00000,64,'2015-06-22 19:08:34'),(555,1,4,'BR25522',100.00000,0,'2015-06-22 20:04:03'),(600,1,4,'BR25522',100.00000,0,'2015-06-22 19:59:29'),(609,1,4,'BR25522',100.00000,0,'2015-06-22 20:08:51'),(633,1,4,'BR25522',100.00000,0,'2015-06-22 19:57:34'),(636,1,4,'BR25522',100.00000,0,'2015-06-22 20:15:59'),(714,1,4,'BR25522',100.00000,0,'2015-06-22 19:54:30'),(716,1,4,'BR25522',100.00000,0,'2015-06-22 19:57:35'),(734,1,4,'BR25522',100.00000,0,'2015-06-22 20:17:31'),(744,1,4,'BR25522',100.00000,0,'2015-06-22 20:08:39'),(756,1,4,'BR25522',100.00000,0,'2015-06-22 20:03:58'),(762,1,4,'BR25522',100.00000,49,'2015-06-22 18:55:20'),(763,1,4,'BR25522',100.00000,0,'2015-06-22 19:57:36'),(813,1,4,'BR25522',100.00000,0,'2015-06-22 20:04:06'),(828,1,4,'BR25522',100.00000,0,'2015-06-22 20:03:11'),(833,1,4,'BR25522',100.00000,25,'2015-06-22 19:08:13'),(840,1,4,'BR25522',100.00000,82,'2015-06-22 18:56:41'),(844,1,4,'BR25522',100.00000,0,'2015-06-22 20:04:05'),(845,1,4,'BR25522',100.00000,0,'2015-06-22 20:07:49'),(852,1,4,'BR25522',100.00000,0,'2015-06-22 19:58:35'),(866,1,4,'BR25522',100.00000,9,'2015-06-22 19:08:07'),(912,1,4,'BR25522',100.00000,0,'2015-06-22 20:09:35'),(922,1,4,'BR25522',100.00000,60,'2015-06-22 19:36:01'),(939,1,4,'BR25522',100.00000,93,'2015-06-22 18:55:59'),(947,1,4,'BR25522',100.00000,0,'2015-06-22 20:05:57'),(961,1,4,'BR25522',100.00000,89,'2015-06-22 18:55:33'),(964,1,4,'BR25522',100.00000,47,'2015-06-22 19:21:28'),(986,1,4,'BR25522',100.00000,0,'2015-06-22 20:19:50'),(987,1,4,'BR25522',100.00000,0,'2015-06-22 20:22:47');
/*!40000 ALTER TABLE `orders_log` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Product2',11.0000,NULL),(9,'NProd',101.0000,NULL),(10,'Prod',49.0000,NULL),(11,'Lol',123.0000,NULL),(14,'Prod155',124.0000,NULL),(34,'TestPro',12.1200,'Desdc'),(35,'dsf',12.0000,'qw'),(36,'sda',123.0000,'12'),(37,'Milka',525.3200,'Valflepe'),(38,'dasd',11.0000,'12'),(39,'rwer',124.0000,'12'),(40,'rrsr',0.0000,'1242'),(41,'Losty',141.0000,'1231'),(42,'eqwe',142.0000,'12');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_keys`
--

LOCK TABLES `refund_keys` WRITE;
/*!40000 ALTER TABLE `refund_keys` DISABLE KEYS */;
INSERT INTO `refund_keys` VALUES (1,10,3,2),(2,10,4,3);
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
  `sum` decimal(10,4) DEFAULT NULL,
  `id_refund` int(11) DEFAULT NULL,
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

-- Dump completed on 2015-06-22 20:50:47
