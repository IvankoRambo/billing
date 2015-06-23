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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (10,'Milochka','kolaider');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_orders`
--

LOCK TABLES `failed_orders` WRITE;
/*!40000 ALTER TABLE `failed_orders` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_products`
--

LOCK TABLES `failed_products` WRITE;
/*!40000 ALTER TABLE `failed_products` DISABLE KEYS */;
INSERT INTO `failed_products` VALUES (2,'{\"products\":[{\"id\":\"1\",\"name\":\"Super Key Avarum Antivirus\",\"price\":\"12.12\"},{\"id\":\"2\",\"name\":\"Professional\",\"price\":\"12\"},{\"id\":\"10\",\"name\":\"test\",\"price\":\"12\"}]}','http://127.0.0.1/billing/get_test/test_get_producs'),(3,'{\"products\":[{\"id\":\"1\",\"name\":\"Super Key Avarum Antivirus\",\"price\":\"12.12\"},{\"id\":\"2\",\"name\":\"Professional\",\"price\":\"12\"}]}','http://127.0.0.1/billing/get_test/test_get_producs'),(4,'{\"products\":[{\"id\":\"1\",\"name\":\"Super Key Avarum Antivirus\",\"price\":\"12.12\",\"description\":null},{\"id\":\"2\",\"name\":\"Professional\",\"price\":\"123\",\"description\":null},{\"id\":\"12\",\"name\":\"Lol\",\"price\":\"12\",\"description\":\"LolProd\"}]}','http://127.0.0.1/billing_v1/get_test/test_get_prod'),(5,'{\"products\":[{\"id\":\"1\",\"name\":\"Super Key Avarum Antivirus\",\"price\":\"12.12\",\"description\":null},{\"id\":\"2\",\"name\":\"Professional\",\"price\":\"123\",\"description\":null},{\"id\":\"11\",\"name\":\"test\",\"price\":\"123\",\"description\":null},{\"id\":\"12\",\"name\":\"Lol\",\"price\":\"12\",\"description\":\"LolProd\"}]}','http://10.55.33.34/get_products.php'),(6,'{\"products\":[{\"id\":\"1\",\"name\":\"Super Key Avarum Antivirus\",\"price\":\"12.12\",\"description\":null},{\"id\":\"2\",\"name\":\"Professional\",\"price\":\"123\",\"description\":null},{\"id\":\"11\",\"name\":\"test\",\"price\":\"123\",\"description\":null},{\"id\":\"12\",\"name\":\"Lol\",\"price\":\"12\",\"description\":\"LolProd\"}]}','http://10.55.33.28/billing/GetProductsFromBilling.');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_refunds`
--

LOCK TABLES `failed_refunds` WRITE;
/*!40000 ALTER TABLE `failed_refunds` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=239 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_keys`
--

LOCK TABLES `order_keys` WRITE;
/*!40000 ALTER TABLE `order_keys` DISABLE KEYS */;
INSERT INTO `order_keys` VALUES (236,2,3),(237,3,4),(238,3,5);
/*!40000 ALTER TABLE `order_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_price`
--

DROP TABLE IF EXISTS `order_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_order` int(11) NOT NULL,
  `price` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_price`
--

LOCK TABLES `order_price` WRITE;
/*!40000 ALTER TABLE `order_price` DISABLE KEYS */;
INSERT INTO `order_price` VALUES (1,2,200.0000),(2,3,250.0000);
/*!40000 ALTER TABLE `order_price` ENABLE KEYS */;
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
INSERT INTO `orders` VALUES (2,3,0,'bla-bla',186.00000,1,'2015-06-23 12:37:52'),(3,4,1,'bla-bla2',465.00000,2,'2015-06-23 12:38:39');
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
  `name` varchar(255) NOT NULL,
  `price` float NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_index` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Super Key Avarum Antivirus',12.12,NULL),(2,'Professional',123,NULL),(12,'Lol',12,'LolProd');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_keys`
--

LOCK TABLES `refund_keys` WRITE;
/*!40000 ALTER TABLE `refund_keys` DISABLE KEYS */;
INSERT INTO `refund_keys` VALUES (9,10,3,2),(10,10,4,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refunds`
--

LOCK TABLES `refunds` WRITE;
/*!40000 ALTER TABLE `refunds` DISABLE KEYS */;
INSERT INTO `refunds` VALUES (1,2,1,14.0000,10),(2,2,1,14.0000,10),(3,3,2,35.0000,10),(4,2,1,14.0000,10),(5,3,2,35.0000,10),(6,2,1,14.0000,10),(7,3,2,35.0000,10);
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

-- Dump completed on 2015-06-23 14:30:49
