/*
SQLyog Enterprise - MySQL GUI v8.18 
MySQL - 5.5.5-10.4.32-MariaDB : Database - sale
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`sale` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `sale`;

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(50) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `categories` */

insert  into `categories`(`id`,`cate_name`,`create_at`,`update_at`) values (1,'ទឹកសុទ្ធ','2025-05-21 18:04:32','2025-05-21 18:04:32'),(59,'ម្ហូប','2025-05-21 18:11:10','2025-05-21 18:11:10'),(68,'ភេសជ្ជៈ','2025-05-21 18:24:49','2025-05-21 18:24:49'),(69,'បាយ','2025-05-21 18:25:59','2025-05-21 18:25:59');

/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cus_name` varchar(100) NOT NULL,
  `cus_phone` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `customer` */

insert  into `customer`(`id`,`cus_name`,`cus_phone`,`address`,`create_at`,`update_at`) values (5,'Sor Sann','048468486','Battambang','2025-05-21 20:54:35','2025-05-21 20:54:35');

/*Table structure for table `payment` */

DROP TABLE IF EXISTS `payment`;

CREATE TABLE `payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) unsigned NOT NULL,
  `payment` decimal(10,2) DEFAULT NULL,
  `discount` int(11) NOT NULL,
  `method` varchar(100) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`),
  CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sale` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=234 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `payment` */

insert  into `payment`(`id`,`sale_id`,`payment`,`discount`,`method`,`create_at`,`update_at`) values (232,498,'0.90',0,'2','2025-05-22 08:05:48','2025-05-22 13:05:48'),(233,499,'1.00',50,'Cash','2025-05-22 08:09:28','2025-05-22 13:09:28');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sub_id` int(11) unsigned DEFAULT NULL,
  `pro_name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(100) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`sub_id`),
  KEY `sub_id` (`sub_id`)
) ENGINE=InnoDB AUTO_INCREMENT=375 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `products` */

insert  into `products`(`id`,`sub_id`,`pro_name`,`price`,`image`,`create_at`,`update_at`) values (364,48,'វិតាល','1.00','682ebcd98490d.png','2025-05-22 06:48:04','2025-05-22 06:48:04'),(365,48,'ដាសានី','2.00','682e66562a47d.jpg','2025-05-22 06:48:38','2025-05-22 06:48:38'),(366,51,'BBQ Fork','5.00','682ead378fdfd.jpg','2025-05-22 11:51:03','2025-05-22 11:51:03'),(367,52,'សម្លរកកូរ','3.00','682ee5b29f93a.jpg','2025-05-22 15:52:02','2025-05-22 15:52:02'),(368,53,'បាយឆាក្ដៅ','2.00','682ee706b246b.jpg','2025-05-22 15:57:42','2025-05-22 15:57:42'),(369,53,'បាយបង្គាមឹក','7.00','682ee8bac774b.jpg','2025-05-22 16:04:58','2025-05-22 16:04:58'),(370,52,'សម្លរម្ជូរព្រលឹត','3.00','682ee9a86b1da.jpg','2025-05-22 16:08:56','2025-05-22 16:08:56'),(371,54,'កូកា','3.00','682eea8d2abf5.jpg','2025-05-22 16:11:41','2025-05-22 16:11:41'),(372,54,'ស្ទីង','2.00','682eeb3d5d501.jpg','2025-05-22 16:15:41','2025-05-22 16:15:41'),(373,52,'ឆាសាច់គោដើមខាត់ណា','7.00','682eec72b6bf9.jpg','2025-05-22 16:20:50','2025-05-22 16:20:50'),(374,52,'ម្ជូរគ្រឿងត្រគួនសាច់គោ','4.00','682eed0f33dc8.jpg','2025-05-22 16:23:27','2025-05-22 16:23:27');

/*Table structure for table `sale` */

DROP TABLE IF EXISTS `sale`;

CREATE TABLE `sale` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sale_date` date DEFAULT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `customer_id` int(11) unsigned DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`customer_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=500 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `sale` */

insert  into `sale`(`id`,`sale_date`,`user_id`,`customer_id`,`create_at`,`update_at`) values (498,'2025-05-22',98,5,'2025-05-22 13:05:48','2025-05-22 13:05:48'),(499,'2025-05-22',98,5,'2025-05-22 13:09:28','2025-05-22 13:09:28');

/*Table structure for table `saleproduct` */

DROP TABLE IF EXISTS `saleproduct`;

CREATE TABLE `saleproduct` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sale_id` int(11) unsigned NOT NULL,
  `pro_id` int(11) unsigned NOT NULL,
  `price` float(10,2) NOT NULL,
  `qty` int(11) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `sale_id` (`sale_id`,`pro_id`),
  KEY `pro_id` (`pro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=690 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `saleproduct` */

insert  into `saleproduct`(`id`,`sale_id`,`pro_id`,`price`,`qty`,`create_at`,`update_at`) values (688,498,364,1.00,1,'2025-05-22 13:05:48','2025-05-22 13:05:48'),(689,499,365,2.00,1,'2025-05-22 13:09:28','2025-05-22 13:09:28');

/*Table structure for table `sub_categories` */

DROP TABLE IF EXISTS `sub_categories`;

CREATE TABLE `sub_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) unsigned NOT NULL,
  `sub_cate` varchar(100) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `sub_categories` */

insert  into `sub_categories`(`id`,`category_id`,`sub_cate`,`create_at`,`update_at`) values (48,1,'មិនមាន','2025-05-21 19:48:31','2025-05-21 19:48:31'),(51,59,'ម្ហូបបរទេស','2025-05-22 11:49:30','2025-05-22 11:49:30'),(52,59,'ម្ហូបខ្មែរ','2025-05-22 15:48:44','2025-05-22 15:48:44'),(53,69,'បាយឆា','2025-05-22 15:54:59','2025-05-22 15:54:59'),(54,68,'កំប៉ុង','2025-05-22 16:10:45','2025-05-22 16:10:45');

/*Table structure for table `type` */

DROP TABLE IF EXISTS `type`;

CREATE TABLE `type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  `create_at` datetime NOT NULL,
  `update_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `type` */

insert  into `type`(`id`,`type`,`create_at`,`update_at`) values (1,'admin','2023-12-16 08:55:59','2023-12-16 08:55:59'),(2,'sale','2023-12-16 08:56:12','2023-12-16 08:56:12');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `dob` date NOT NULL,
  `address` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `type` int(11) unsigned NOT NULL,
  `image` varchar(100) NOT NULL,
  `code` int(6) NOT NULL DEFAULT 0,
  `create_at` datetime NOT NULL DEFAULT current_timestamp(),
  `update_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `type_id` (`type`)
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`full_name`,`gender`,`dob`,`address`,`phone_number`,`username`,`password`,`type`,`image`,`code`,`create_at`,`update_at`) values (98,'Admin','Male','2000-01-01','Battambang','086842415','admin@gmail.com','81dc9bdb52d04dc20036dbd8313ed055',1,'6667b05adefd0.png',0,'2024-04-26 19:53:38','2024-04-26 19:53:38'),(107,'Sale 01','Female','2001-01-01','Battambang','098765432','sale01@gmail.com','81dc9bdb52d04dc20036dbd8313ed055',2,'6667b0a569383.png',0,'2024-06-10 09:51:00','2024-06-10 09:51:00');

/* Procedure structure for procedure `countCategories` */

/*!50003 DROP PROCEDURE IF EXISTS  `countCategories` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `countCategories`()
BEGIN
	SELECT COUNT(id) AS p_Total  FROM categories;
END */$$
DELIMITER ;

/* Procedure structure for procedure `countProducts` */

/*!50003 DROP PROCEDURE IF EXISTS  `countProducts` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `countProducts`()
BEGIN 
	SELECT COUNT(id) AS Total  FROM products;
END */$$
DELIMITER ;

/* Procedure structure for procedure `getAllProducts` */

/*!50003 DROP PROCEDURE IF EXISTS  `getAllProducts` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllProducts`()
BEGIN
	SELECT products.id,image, cate_name, sub_cate, pro_name, products.price ,products.create_at, products.update_at 
    FROM products
    INNER JOIN categories ON products.category_id = categories.id
    LEFT JOIN sub_categories ON products.sub_id = sub_categories.id;
	END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
