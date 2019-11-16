-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table cakencookies.appuser
CREATE TABLE IF NOT EXISTS `appuser` (
  `user_id` varchar(12) NOT NULL DEFAULT '',
  `user_name` varchar(50) NOT NULL DEFAULT '',
  `user_password` varchar(40) DEFAULT NULL,
  `user_level` varchar(10) NOT NULL DEFAULT 'General' COMMENT 'Admin,Developer,General',
  `login_status` tinyint(4) DEFAULT '0' COMMENT '1=login; 0=not login;',
  `is_active` int(1) NOT NULL DEFAULT '1' COMMENT '1=Active,0=Blocked',
  `modified_by` varchar(20) DEFAULT NULL,
  `modified_time` datetime DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  KEY `con_user_created_by_fk` (`created_by`),
  KEY `con_user_modified_by_fk` (`modified_by`),
  CONSTRAINT `con_user_created_by_fk` FOREIGN KEY (`created_by`) REFERENCES `user_infos` (`emp_id`),
  CONSTRAINT `con_user_modified_by_fk` FOREIGN KEY (`modified_by`) REFERENCES `user_infos` (`emp_id`),
  CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `user_infos` (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.appuser: ~0 rows (approximately)
/*!40000 ALTER TABLE `appuser` DISABLE KEYS */;
INSERT INTO `appuser` (`user_id`, `user_name`, `user_password`, `user_level`, `login_status`, `is_active`, `modified_by`, `modified_time`, `created_by`, `created_at`) VALUES
	('1000001', 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'ROLE_USER', 0, 1, NULL, NULL, '1000001', '2018-09-13 09:32:46');
/*!40000 ALTER TABLE `appuser` ENABLE KEYS */;


-- Dumping structure for table cakencookies.banner_image
CREATE TABLE IF NOT EXISTS `banner_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `text` text,
  `photo` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1:active, 2 in-active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

-- Dumping data for table cakencookies.banner_image: ~6 rows (approximately)
/*!40000 ALTER TABLE `banner_image` DISABLE KEYS */;
INSERT INTO `banner_image` (`id`, `title`, `text`, `photo`, `status`) VALUES
	(21, 'Banner5', 'Savory/Pastry/Cake/Coffee/Cookies/Bread', 'images/banner/5.jpg', 1),
	(22, 'Banner6', 'Savory/Pastry/Cake/Coffee/Cookies/Bread', 'images/banner/6.jpg', 1),
	(23, 'Banner4', 'Savory/Pastry/Cake/Coffee/Cookies/Bread', 'images/banner/4.jpg', 1),
	(27, 'Banner1', 'Savory/Pastry/Cake/Coffee/Cookies/Bread', 'images/banner/1.jpg', 1),
	(28, 'Banner2', 'Savory/Pastry/Cake/Coffee/Cookies/Bread', 'images/banner/2.jpg', 1),
	(29, 'Banner3', 'Savory/Pastry/Cake/Coffee/Cookies/Bread', 'images/banner/3.jpg', 1);
/*!40000 ALTER TABLE `banner_image` ENABLE KEYS */;


-- Dumping structure for table cakencookies.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `photo` varchar(250) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.category: ~11 rows (approximately)
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `code`, `name`, `parent_id`, `photo`, `status`) VALUES
	(2, '001', 'Breads', NULL, 'images/category/kisspng-bakery-breadbasket-baking-and-bread-basket-5a6b76031de9f7.7922297315169920031225.png', 1),
	(9, '102', 'Buns', NULL, 'images/category/kisspng-bakery-breakfast-breadbasket-bread-basket-5a6b7536e1c508.2576371515169917989248.png', 1),
	(10, '103', 'Breakfast Pastry', NULL, 'images/category/chocolate muffin.png', 1),
	(11, '104', 'Doughnut', NULL, 'images/category/Untitled-1.png', 1),
	(12, '105', 'Danish & Croissant', NULL, 'images/category/kisspng-croissant-coffee-danish-pastry-pain-au-chocolat-vi-delicious-croissants-5a7f20f262c2a5.0789929615182809464045.png', 1),
	(13, '106', 'Loaf Cake', NULL, 'images/category/fruit cake.png', 1),
	(14, '107', 'Savory', NULL, 'images/category/miniBurger.png', 1),
	(15, '108', 'Tart', NULL, 'images/category/Lemon tart.png', 1),
	(16, '109', 'Cookie', NULL, 'images/category/cats tongue cookie.jpg', 1),
	(17, '110', 'Cake', NULL, 'images/category/malted chocolate.png', 1),
	(18, '111', 'Pastry', NULL, 'images/category/Red Velvet Pastry.png', 1);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


-- Dumping structure for table cakencookies.cupons
CREATE TABLE IF NOT EXISTS `cupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cupon_no` varchar(100) NOT NULL,
  `c_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: flat_rate; 2:percentage_rate',
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `entry_date` datetime DEFAULT NULL,
  `amount` float(10,2) DEFAULT '0.00',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Active; 0:In-Active',
  `customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.cupons: ~3 rows (approximately)
/*!40000 ALTER TABLE `cupons` DISABLE KEYS */;
INSERT INTO `cupons` (`id`, `cupon_no`, `c_type`, `start_date`, `end_date`, `entry_date`, `amount`, `status`, `customer_id`) VALUES
	(1, '1111', 1, '2017-10-02 17:30:20', '2019-10-02 17:30:24', '2018-10-02 17:30:28', 100.00, 1, NULL),
	(2, '2222', 2, '2017-10-02 17:30:20', '2019-10-02 17:30:24', '2018-10-02 17:30:28', 10.00, 1, NULL),
	(3, '444', 1, '2018-11-08 00:00:00', '2019-02-07 00:00:00', '2019-03-21 00:00:00', 33.00, 1, 1);
/*!40000 ALTER TABLE `cupons` ENABLE KEYS */;


-- Dumping structure for table cakencookies.customer_infos
CREATE TABLE IF NOT EXISTS `customer_infos` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `address` text NOT NULL,
  `age` varchar(100) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `remarks` text,
  `status` tinyint(1) DEFAULT '1' COMMENT '1:active,  0: inactive',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.customer_infos: ~4 rows (approximately)
/*!40000 ALTER TABLE `customer_infos` DISABLE KEYS */;
INSERT INTO `customer_infos` (`customer_id`, `full_name`, `username`, `password`, `address`, `age`, `photo`, `contact_no`, `email`, `remarks`, `status`) VALUES
	(1, 'Moynul Hasan Momit', 'momit', 'e10adc3949ba59abbe56e057f20f883e', 'aaaaaaaaaaa', '200', 'images/customer/momit.jpg', '012100000', 'momit.litu@gmail.com', 'aaaaaaaaaaaa', 1),
	(2, 'MUntakim Hasan', 'munif', 'e10adc3949ba59abbe56e057f20f883e', 'aaaaaaaaaaaaaaaa', '20', 'images/customer/1537339731jahed.jpg', '012554455', 'munif.litu@gmail.com', 'aaaaaaaaaaaaaaa', 1),
	(5, 'hasan', 'hasan', 'e10adc3949ba59abbe56e057f20f883e', 's sfdf,sdf ,sdfsd,dsf,', '', '', '01980340482', 'momi.df@gmaad.com', NULL, 1),
	(6, 'muntakim', 'muntakim', 'e10adc3949ba59abbe56e057f20f883e', 'sgfsf sdfdsfdfdsfs', '', '', '0198034082', 'm.k@gmail.com', NULL, 1);
/*!40000 ALTER TABLE `customer_infos` ENABLE KEYS */;


-- Dumping structure for table cakencookies.custom_cake
CREATE TABLE IF NOT EXISTS `custom_cake` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cc_cake_weight` tinyint(1) DEFAULT NULL,
  `cc_cake_tyre` tinyint(1) DEFAULT NULL,
  `cc_delevery_date` datetime DEFAULT NULL,
  `cc_details` text NOT NULL,
  `cc_name` varchar(200) NOT NULL,
  `cc_email` varchar(200) NOT NULL,
  `cc_mobile` varchar(20) NOT NULL,
  `cc_image` varchar(200) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1:not seen, 2:seen, 3:varified',
  `varified_by` varchar(20) DEFAULT NULL,
  `varified_time` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `remarks` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.custom_cake: ~2 rows (approximately)
/*!40000 ALTER TABLE `custom_cake` DISABLE KEYS */;
INSERT INTO `custom_cake` (`id`, `cc_cake_weight`, `cc_cake_tyre`, `cc_delevery_date`, `cc_details`, `cc_name`, `cc_email`, `cc_mobile`, `cc_image`, `status`, `varified_by`, `varified_time`, `remarks`) VALUES
	(1, 1, 1, '0000-00-00 00:00:00', 'dfgdfg', 'ddfg', 'dfgdfg', '46456', 'momit_singara.jpg', 1, NULL, NULL, NULL),
	(2, 0, 0, '0000-00-00 00:00:00', 'sfsdf', 'sdf', 'fggfdsf', '456456', '', 1, NULL, NULL, NULL),
	(3, 0, 0, '2018-11-13 12:00:00', 'sdfsdf', 'sdff', 'fsfsdf', '465+', 'cigarat.jpg', 1, NULL, NULL, NULL),
	(4, 0, 0, '2018-11-13 12:00:00', 'fgsf', 'sdf', 'dfgdg', '435', '', 1, NULL, NULL, NULL),
	(5, 0, 0, '2018-11-13 12:00:00', 'dfghdg', 'ddfgf', 'ffghh', '456', '', 1, NULL, NULL, NULL);
/*!40000 ALTER TABLE `custom_cake` ENABLE KEYS */;


-- Dumping structure for table cakencookies.delivery_charge
CREATE TABLE IF NOT EXISTS `delivery_charge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(200) NOT NULL,
  `rate` float(8,2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:active, 0: inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.delivery_charge: ~2 rows (approximately)
/*!40000 ALTER TABLE `delivery_charge` DISABLE KEYS */;
INSERT INTO `delivery_charge` (`id`, `type`, `rate`, `status`) VALUES
	(1, 'Inside  Dhaka', 100.00, 1),
	(2, 'Outside Dhaka', 250.00, 1);
/*!40000 ALTER TABLE `delivery_charge` ENABLE KEYS */;


-- Dumping structure for table cakencookies.external_contact
CREATE TABLE IF NOT EXISTS `external_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `organization` varchar(50) NOT NULL DEFAULT '0',
  `designation` varchar(50) NOT NULL DEFAULT '0',
  `email` varchar(50) NOT NULL DEFAULT '0',
  `mobile_no` varchar(50) NOT NULL DEFAULT '0',
  `created_by` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.external_contact: ~2 rows (approximately)
/*!40000 ALTER TABLE `external_contact` DISABLE KEYS */;
INSERT INTO `external_contact` (`id`, `name`, `organization`, `designation`, `email`, `mobile_no`, `created_by`) VALUES
	(2, 'Rony Talukdar', 'ABC', 'ABC', 'fdsgsdfg', '454235345', '1000001'),
	(3, 'ABC', 'ewgvsdagdf', 'btgfewft', 'wrewtgfvdv', '32424', '1000001');
/*!40000 ALTER TABLE `external_contact` ENABLE KEYS */;


-- Dumping structure for table cakencookies.gallary_images
CREATE TABLE IF NOT EXISTS `gallary_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `album_id` int(11) NOT NULL DEFAULT '0',
  `attachment` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_gallary_images_image_group` (`album_id`),
  CONSTRAINT `FK_gallary_images_image_album` FOREIGN KEY (`album_id`) REFERENCES `image_album` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.gallary_images: ~6 rows (approximately)
/*!40000 ALTER TABLE `gallary_images` DISABLE KEYS */;
INSERT INTO `gallary_images` (`id`, `title`, `album_id`, `attachment`) VALUES
	(35, 'title1', 21, '2.JPG'),
	(37, 'title4', 21, '4.JPG'),
	(38, 'title5', 21, '6.JPG'),
	(39, 'title6', 21, '9.JPG'),
	(42, 'title1', 21, 'momit_singara.jpg');
/*!40000 ALTER TABLE `gallary_images` ENABLE KEYS */;


-- Dumping structure for table cakencookies.image_album
CREATE TABLE IF NOT EXISTS `image_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `album_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.image_album: ~2 rows (approximately)
/*!40000 ALTER TABLE `image_album` DISABLE KEYS */;
INSERT INTO `image_album` (`id`, `album_name`) VALUES
	(21, 'Food'),
	(22, 'Outlet');
/*!40000 ALTER TABLE `image_album` ENABLE KEYS */;


-- Dumping structure for table cakencookies.ingredient
CREATE TABLE IF NOT EXISTS `ingredient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  `photo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.ingredient: ~24 rows (approximately)
/*!40000 ALTER TABLE `ingredient` DISABLE KEYS */;
INSERT INTO `ingredient` (`id`, `code`, `name`, `photo`) VALUES
	(4, '10002', 'Eggs', 'images/no_image.png'),
	(5, '10003', 'Salt', 'images/no_image.png'),
	(6, '10004', 'Sweetener', 'images/no_image.png'),
	(7, '10005', 'Milk', 'images/no_image.png'),
	(8, '10007', 'Suger', 'images/no_image.png'),
	(9, '10006', 'Marzarine', 'images/no_image.png'),
	(10, '10008', 'Yeast', 'images/no_image.png'),
	(11, '10009', 'Butter', 'images/no_image.png'),
	(12, '10010', 'Fondante', 'images/no_image.png'),
	(13, '10011', 'Fresh Cream', 'images/no_image.png'),
	(14, '10012', 'Flour', 'images/no_image.png'),
	(15, '10013', 'Cheese', 'images/no_image.png'),
	(16, '10014', 'Chocolate', 'images/no_image.png'),
	(17, '10015', 'Dark Chocolate', 'images/no_image.png'),
	(18, '10016', 'Suger Syrup', 'images/no_image.png'),
	(19, '10017', 'Cherry Pie', 'images/no_image.png'),
	(20, '10018', 'Food Colour', 'images/no_image.png'),
	(21, '10019', 'Icing Suger', 'images/no_image.png'),
	(22, '10020', 'Baking Powder', 'images/no_image.png'),
	(23, '10021', 'Strawberry', 'images/no_image.png'),
	(24, '10022', 'Chicken', 'images/no_image.png'),
	(25, '10023', 'Spice', 'images/no_image.png'),
	(26, '10024', 'Vegetable', 'images/no_image.png'),
	(27, '10025', 'Sausage', 'images/no_image.png');
/*!40000 ALTER TABLE `ingredient` ENABLE KEYS */;


-- Dumping structure for table cakencookies.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_rate_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_rate` double(12,4) NOT NULL,
  `status` tinyint(1) DEFAULT '1' COMMENT '1:active,  2: canceled ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.order_details: ~9 rows (approximately)
/*!40000 ALTER TABLE `order_details` DISABLE KEYS */;
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `size_rate_id`, `quantity`, `product_rate`, `status`) VALUES
	(1, 1, 55, 121, 3, 1200.0000, 1),
	(3, 3, 56, 122, 1, 1600.0000, 1),
	(4, 4, 55, 121, 1, 1200.0000, 1),
	(5, 5, 56, 122, 1, 1600.0000, 1),
	(6, 6, 56, 122, 1, 1600.0000, 1),
	(7, 7, 101, 173, 2, 550.0000, 1),
	(10, 9, 102, 175, 1, 650.0000, 1),
	(11, 10, 66, 161, 2, 55.0000, 1),
	(12, 11, 102, 175, 1, 650.0000, 1),
	(13, 12, 102, 175, 1, 650.0000, 1),
	(14, 13, 102, 175, 1, 650.0000, 1),
	(15, 14, 101, 173, 2, 550.0000, 1),
	(16, 1, 102, 500, 2, 650.0000, 1),
	(17, 9, 101, 500, 1, 550.0000, 1),
	(18, 9, 102, 500, 1, 650.0000, 1),
	(19, 9, 102, 500, 1, 650.0000, 1),
	(20, 9, 102, 500, 1, 650.0000, 1),
	(21, 9, 102, 500, 1, 650.0000, 1),
	(22, 9, 102, 500, 1, 650.0000, 1),
	(23, 9, 85, 182, 1, 50.0000, 1),
	(24, 9, 102, 500, 1, 650.0000, 1),
	(25, 9, 102, 500, 1, 650.0000, 1),
	(26, 9, 85, 0, 1, 50.0000, 1),
	(27, 9, 102, 500, 1, 650.0000, 1),
	(28, 9, 85, 0, 1, 50.0000, 1),
	(29, 9, 102, 500, 1, 650.0000, 1),
	(30, 9, 85, 0, 1, 50.0000, 1),
	(31, 9, 102, 500, 1, 650.0000, 1),
	(32, 9, 85, 0, 1, 50.0000, 1),
	(33, 9, 102, 500, 1, 650.0000, 1),
	(34, 9, 85, 0, 1, 50.0000, 1);
/*!40000 ALTER TABLE `order_details` ENABLE KEYS */;


-- Dumping structure for table cakencookies.order_master
CREATE TABLE IF NOT EXISTS `order_master` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `delivery_date` datetime DEFAULT NULL,
  `delivery_type` tinyint(1) DEFAULT '1' COMMENT '1:takeout, 2: delivery',
  `outlet_id` int(11) DEFAULT NULL,
  `delivery_charge_id` int(11) DEFAULT NULL,
  `cupon_id` int(11) DEFAULT NULL,
  `discount_amount` float(12,2) DEFAULT '0.00',
  `delivery_charge` float(12,2) DEFAULT '0.00',
  `total_order_amt` float(12,2) DEFAULT '0.00',
  `total_paid_amount` float(12,2) DEFAULT '0.00',
  `tax_amount` float(12,2) DEFAULT '0.00',
  `address` text NOT NULL,
  `remarks` text,
  `order_status` tinyint(1) DEFAULT '1' COMMENT '1:ordered,  2: ready ,  3: picked',
  `order_noticed` tinyint(1) DEFAULT '1' COMMENT '1:not seen, 2:seen',
  `order_noticed_time` timestamp NULL DEFAULT NULL,
  `payment_time` timestamp NULL DEFAULT NULL,
  `payment_status` tinyint(1) DEFAULT '1' COMMENT '1:not paid,  2: paid ',
  `payment_method` tinyint(1) DEFAULT NULL COMMENT '1:bkash,  2: rocket , 3:Cash on delevery',
  `payment_reference_no` varchar(20) DEFAULT NULL,
  `invoice_no` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.order_master: ~7 rows (approximately)
/*!40000 ALTER TABLE `order_master` DISABLE KEYS */;
INSERT INTO `order_master` (`order_id`, `customer_id`, `order_date`, `delivery_date`, `delivery_type`, `outlet_id`, `delivery_charge_id`, `cupon_id`, `discount_amount`, `delivery_charge`, `total_order_amt`, `total_paid_amount`, `tax_amount`, `address`, `remarks`, `order_status`, `order_noticed`, `order_noticed_time`, `payment_time`, `payment_status`, `payment_method`, `payment_reference_no`, `invoice_no`) VALUES
	(1, 1, '2018-10-08 09:42:35', '2018-10-08 12:00:00', 2, NULL, 1, 2222, 360.00, 100.00, 3340.00, 0.00, 0.00, '', 'sdfsdf ', 1, 2, '2018-10-08 01:26:45', NULL, 2, 1, '3340', 'CnC101800001'),
	(3, 1, '2018-10-08 09:57:40', '2018-10-04 12:00:00', 1, 1, NULL, 2222, 360.00, 0.00, 1240.00, 0.00, 0.00, '', 'dgd gdfgdfg', 1, 2, '2018-10-14 05:30:21', NULL, 2, 1, '1240', 'CnC101800002'),
	(4, 1, '2018-10-08 10:02:20', '2018-11-08 12:00:00', 1, 1, NULL, 2222, 360.00, 0.00, 840.00, 0.00, 0.00, '', 'zdfsd fsf', 1, 1, NULL, NULL, 1, NULL, NULL, 'CnC101800003'),
	(5, 1, '2018-10-08 10:03:18', '2018-10-11 12:00:00', 1, 1, NULL, 0, 0.00, 0.00, 1600.00, 0.00, 0.00, '', 'dfgg', 1, 2, '2018-10-14 05:27:43', NULL, 1, NULL, NULL, 'CnC101800004'),
	(6, 1, '2018-10-09 09:57:39', '2018-10-09 12:00:00', 2, NULL, 1, 2222, 160.00, 100.00, 1540.00, 0.00, 0.00, '', 'sdfs dfsf', 1, 2, '2018-10-09 00:21:07', NULL, 2, 1, '1540', 'CnC101800005'),
	(7, 1, '2018-11-11 11:17:33', '2018-11-12 12:00:00', 1, 1, NULL, NULL, 0.00, 0.00, 1100.00, 1100.00, 0.00, '', '', 1, 2, '2018-11-11 08:08:08', NULL, 2, 1, '1100', 'CnC111800006'),
	(9, 1, '2018-11-11 11:33:43', '2018-11-17 12:00:00', 2, 1, 1, NULL, 0.00, 100.00, 700.00, 1200.00, 0.00, '', 'sdf sdfdsfd fdff', 1, 2, '2018-11-11 09:11:56', '2018-11-14 08:18:23', 2, 1, '111', 'CnC111800008'),
	(10, 1, '2018-11-13 14:03:26', '2018-11-13 12:00:00', 1, 1, NULL, NULL, 0.00, 0.00, 110.00, 0.00, 0.00, '', 'sff', 1, 2, '2018-11-13 09:03:52', NULL, 1, NULL, NULL, 'CnC111800009'),
	(11, 1, '2018-11-13 14:31:29', '2018-11-15 12:00:00', 1, 1, NULL, NULL, 0.00, 0.00, 650.00, 0.00, 0.00, '', '', 1, 2, '2018-11-13 11:35:44', NULL, 1, NULL, NULL, 'CnC111800010'),
	(12, 1, '2018-11-13 14:37:30', '2018-11-16 12:00:00', 1, 1, NULL, NULL, 0.00, 0.00, 650.00, 0.00, 0.00, '', '', 1, 1, NULL, NULL, 1, NULL, NULL, 'CnC111800011'),
	(13, 1, '2018-11-13 14:39:04', '2018-11-15 12:00:00', 1, 1, NULL, NULL, 0.00, 0.00, 650.00, 0.00, 0.00, '', '', 1, 2, '2018-11-13 11:36:12', NULL, 1, NULL, NULL, 'CnC111800012'),
	(14, 1, '2018-11-13 14:40:02', '2018-11-23 12:00:00', 1, 1, NULL, NULL, 0.00, 0.00, 1100.00, 0.00, 0.00, '', '', 2, 2, '2018-11-13 10:47:19', NULL, 1, NULL, NULL, 'CnC111800013');
/*!40000 ALTER TABLE `order_master` ENABLE KEYS */;


-- Dumping structure for table cakencookies.outlets
CREATE TABLE IF NOT EXISTS `outlets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(500) NOT NULL,
  `outlet_name` varchar(200) DEFAULT NULL,
  `longitud` varchar(50) NOT NULL,
  `incharge_name` varchar(200) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `mobile` int(11) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: Active; 0:In-Active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.outlets: ~4 rows (approximately)
/*!40000 ALTER TABLE `outlets` DISABLE KEYS */;
INSERT INTO `outlets` (`id`, `address`, `outlet_name`, `longitud`, `incharge_name`, `image`, `mobile`, `latitude`, `status`) VALUES
	(1, '4/1 Salimullah Road, Mohammadpur, Dhaka', 'Mohammodpur ', '90.363841', '', 'images/outlets/outlate1.jpg', 1613313677, '23.759467', 1),
	(2, 'Shaplar More, Kamarpara, Uttara, Dhaka', 'Uttara', '', '', 'images/outlets/outlate2.jpg', 1613313676, '', 1),
	(3, 'H # 41, R # 04, B # 6, South Banasree, Dhaka', 'Banasree # 1', '', '', 'images/outlets/outlate3.jpg', 0, '', 1),
	(4, 'H # 227, R # 16, B # K, South Banasree, Dhaka', 'Banasree # 2', '', '', 'images/outlets/outlate4.jpg', 1, '', 1);
/*!40000 ALTER TABLE `outlets` ENABLE KEYS */;


-- Dumping structure for table cakencookies.products
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `code` varchar(200) NOT NULL,
  `tags` varchar(200) NOT NULL,
  `details` text,
  `short_description` text,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `availability` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1: available, 0: not avalable',
  `feature_image` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.products: ~36 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`product_id`, `name`, `code`, `tags`, `details`, `short_description`, `category_id`, `brand_id`, `availability`, `feature_image`) VALUES
	(65, 'Milk Bread', '101', 'Milk , Bread , Slice ', 'No one wants a crusty loaf every day, and that\'s when these beauties step up to the plate.', NULL, 2, 0, 1, '1.jpg'),
	(66, 'Sandwich Bread', '102', 'Bread, Sandwich, Slice', 'No one wants a crusty loaf every day, and that\'s when these beauties step up to the plate.', NULL, 2, 0, 1, '15416720762.jpg'),
	(67, 'Regular White Bread', '103', 'White, Bread, Slice', 'No one wants a crusty loaf every day, and that\'s when these beauties step up to the plate.', NULL, 2, 0, 1, ''),
	(68, 'Burger Bun', '201', 'Bun', '', NULL, 9, 0, 1, ''),
	(69, 'Burger Bun (Medium)', '201.1', 'Bun', '', NULL, 9, 0, 1, ''),
	(70, 'Dinner Roll', '202', 'Bun', '', NULL, 9, 0, 1, ''),
	(71, 'Hot Dog Bun', '203', 'Bun', '', NULL, 9, 0, 1, ''),
	(72, 'Sub Bun', '204', 'Bun', '', NULL, 9, 0, 1, ''),
	(73, 'Plain Muffin', '301', 'Pastry', 'a small domed spongy cake made with eggs and baking powder.', NULL, 10, 0, 1, ''),
	(74, 'Fruit Muffin', '302', 'Pastry', 'a small domed spongy cake made with eggs and baking powder & fruits inside,', NULL, 10, 0, 1, ''),
	(75, 'Chocolate Muffin', '303', 'Pastry', 'a small domed spongy cake made with eggs, chocolate and baking powder', NULL, 10, 0, 1, ''),
	(76, 'Chocolate Doughnut', '401', 'Pastry, Chocolate', 'A small fried cake of sweetened dough, typically in the shape of a ring topped with chocolate sauce.', NULL, 11, 0, 1, ''),
	(77, 'Strawberry Doughnut', '402', 'Pastry, Strawberry', 'A small fried cake of sweetened dough, typically in the shape of a ring topped with strawberry sauce.', NULL, 11, 0, 1, ''),
	(79, 'BlueberryDoughnut', '403', 'Pastry', 'A small fried cake of sweetened dough, typically in the shape of a ring topped with strawberry sauce.', NULL, 11, 0, 1, ''),
	(80, 'Plain Croissant', '501', '', 'a French crescent-shaped roll made of sweet flaky yeast dough, eaten for breakfast.', NULL, 12, 0, 1, ''),
	(81, 'Chocolate Croissant', '502', 'Pastry', 'a French crescent-shaped roll made of sweet flaky yeast dough filling with, eaten for breakfast.', NULL, 12, 0, 1, ''),
	(82, 'Pinwheel Danish', '503', 'Pastry', 'a French crescent-shaped roll made of sweet flaky yeast dough, eaten for breakfast.', NULL, 12, 0, 1, ''),
	(83, 'Plain Cake', '601', 'Cake', 'Sponge cake is a cake based on flour (usually wheat flour), sugar, butter and eggs, and is sometimes leavened with baking powder.', NULL, 13, 0, 1, ''),
	(84, 'Fruit Cake', '602', 'Cake', 'Sponge cake is a cake based on flour (usually wheat flour), sugar, butter and eggs, fruits and is sometimes leavened with baking powder', NULL, 13, 0, 1, ''),
	(85, 'Chicken Sausage Roll (Large)', '701', 'Chicken, Fast food, Sausage, Spicy', '', NULL, 14, 0, 1, ''),
	(86, 'Chicken Sausage Roll (Small)', '702', 'Chicken, Fast food, Sausage, Spicy', '', NULL, 14, 0, 1, ''),
	(87, 'Pizza Bun', '703', 'Chicken, Fast food, Sausage, Spicy', '', NULL, 14, 0, 1, ''),
	(88, 'Chicken Sausage Delight', '705', 'Chicken, Fast food, Sausage, Spicy', 'Sausage Filling Savory with mayo tomato topping.', NULL, 14, 0, 1, ''),
	(89, 'Chicken Puff', '708', 'Chicken, Fast food, Sausage, Spicy', 'Puff sheet filling with saute chicken chili onion then baked.', NULL, 14, 0, 1, ''),
	(90, 'Chicken Samosa', '709', 'Chicken, Fast food, Sausage, Spicy', '', NULL, 14, 0, 1, ''),
	(91, 'Vegetable Singara', '710', 'Vegetable, Fast food, Spicy', 'Black cumin infused singara dough filling with mixed tawa vegetable then deep fry.', NULL, 14, 0, 1, ''),
	(93, 'Chicken Cold Sandwich', '711', 'Chicken, Fast food, Sausage, Spicy', '', NULL, 14, 0, 1, ''),
	(94, 'Mini Chicken Burger', '712', 'Chicken, Fast food, Spicy', '', NULL, 14, 0, 1, ''),
	(96, 'Chicken Spring Roll', '713', 'Chicken, Fast food, Spicy', '', NULL, 14, 0, 1, ''),
	(97, 'Vegetable Roll', '714', 'Fast food,Vegetable,Spicy', '', NULL, 14, 0, 1, ''),
	(98, 'Lemon Tart', '801', 'Lemon, Pastry', 'A pastry shell with a lemon flavored filling.', NULL, 15, 0, 1, ''),
	(99, 'Almond Tart', '802', 'Pastry', 'a pastry shell with a almond flavored filling.', NULL, 15, 0, 1, ''),
	(100, 'Test product Momit', '78979', 'momit', 'fhfhg', NULL, 2, 0, 0, '15416732741.jpg'),
	(101, 'Vanilla Cake', '1001', '', 'Vanilla sponge layered by butter cream and topping by pure whipped cream.', NULL, 17, 0, 1, '15416734301.jpg'),
	(102, 'Black Forest', '1002', 'Chocolate, Cake, Black, ', 'Soft chocolate sponge layered by Cherry pie filling & butter cream and topping by chocolate Ganache or Butter Cream or Chocolate Shavings.', NULL, 17, 0, 1, '15416739802.jpg');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;


-- Dumping structure for table cakencookies.product_image
CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_image` varchar(55) NOT NULL,
  `is_featured` tinyint(1) DEFAULT '0' COMMENT '1:featured, 0 not ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.product_image: ~36 rows (approximately)
/*!40000 ALTER TABLE `product_image` DISABLE KEYS */;
INSERT INTO `product_image` (`id`, `product_id`, `product_image`, `is_featured`) VALUES
	(79, 66, '2.jpg', 0),
	(80, 67, '3.jpg', 0),
	(81, 68, '15416655711.jpg', 0),
	(82, 69, '15416656801.jpg', 0),
	(83, 70, '15416657302.jpg', 0),
	(84, 71, '15416657723.jpg', 0),
	(85, 72, '4.jpg', 0),
	(86, 73, '15416659791.jpg', 0),
	(87, 74, '15416660552.jpg', 0),
	(88, 75, '15416661643.jpg', 0),
	(89, 76, '15416664311.jpg', 0),
	(90, 77, '15416665252.jpg', 0),
	(92, 79, '15416693243.jpg', 0),
	(93, 80, '15416694381.jpg', 0),
	(94, 81, '15416696032.jpg', 0),
	(95, 82, '15416697143.jpg', 0),
	(96, 83, '15416698441.jpg', 0),
	(97, 84, '15416699412.jpg', 0),
	(98, 85, '15416703491.jpg', 0),
	(99, 86, '15416704341.jpg', 0),
	(100, 87, '15416705842.jpg', 0),
	(101, 88, '15416706573.jpg', 0),
	(102, 89, '15416709114.jpg', 0),
	(104, 65, '1.jpg', 0),
	(105, 66, '15416720762.jpg', 0),
	(106, 90, '5.jpg', 0),
	(107, 91, '6.jpg', 0),
	(109, 93, '7.jpg', 0),
	(110, 94, '8.jpg', 0),
	(112, 96, '9.jpg', 0),
	(113, 97, '10.jpg', 0),
	(114, 98, '15416729791.jpg', 0),
	(115, 99, '15416730692.jpg', 0),
	(116, 100, 'cigarat.jpg', 0),
	(117, 101, '15416734301.jpg', 0),
	(118, 102, '15416739802.jpg', 0);
/*!40000 ALTER TABLE `product_image` ENABLE KEYS */;


-- Dumping structure for table cakencookies.product_ingredient
CREATE TABLE IF NOT EXISTS `product_ingredient` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=492 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.product_ingredient: ~137 rows (approximately)
/*!40000 ALTER TABLE `product_ingredient` DISABLE KEYS */;
INSERT INTO `product_ingredient` (`id`, `product_id`, `ingredient_id`) VALUES
	(316, 67, 10),
	(317, 67, 14),
	(318, 68, 5),
	(319, 68, 10),
	(320, 68, 14),
	(321, 69, 5),
	(322, 69, 10),
	(323, 69, 14),
	(324, 70, 5),
	(325, 70, 10),
	(326, 70, 14),
	(327, 71, 5),
	(328, 71, 10),
	(329, 71, 14),
	(330, 72, 5),
	(331, 72, 10),
	(332, 72, 14),
	(333, 73, 8),
	(334, 73, 10),
	(335, 73, 11),
	(336, 73, 14),
	(337, 74, 4),
	(338, 74, 5),
	(339, 74, 7),
	(340, 74, 8),
	(341, 74, 10),
	(342, 74, 14),
	(343, 75, 4),
	(344, 75, 8),
	(345, 75, 11),
	(346, 75, 14),
	(347, 75, 16),
	(348, 76, 5),
	(349, 76, 6),
	(350, 76, 8),
	(351, 76, 11),
	(352, 76, 14),
	(353, 76, 16),
	(354, 77, 4),
	(355, 77, 6),
	(356, 77, 8),
	(357, 77, 14),
	(360, 79, 6),
	(361, 79, 8),
	(362, 79, 10),
	(363, 79, 14),
	(364, 80, 4),
	(365, 80, 6),
	(366, 80, 8),
	(367, 80, 14),
	(368, 81, 8),
	(369, 81, 10),
	(370, 81, 14),
	(371, 81, 16),
	(372, 82, 4),
	(373, 82, 8),
	(374, 82, 10),
	(375, 82, 14),
	(376, 83, 4),
	(377, 83, 5),
	(378, 83, 7),
	(379, 83, 8),
	(380, 83, 14),
	(381, 83, 22),
	(382, 84, 4),
	(383, 84, 8),
	(384, 84, 14),
	(385, 84, 22),
	(394, 86, 4),
	(395, 86, 14),
	(396, 86, 25),
	(397, 86, 27),
	(398, 87, 4),
	(399, 87, 14),
	(400, 87, 24),
	(401, 87, 25),
	(417, 66, 5),
	(418, 66, 10),
	(419, 66, 14),
	(420, 90, 5),
	(421, 90, 14),
	(422, 90, 24),
	(423, 90, 25),
	(432, 93, 4),
	(433, 93, 14),
	(434, 93, 24),
	(435, 94, 5),
	(436, 94, 14),
	(437, 94, 24),
	(438, 94, 25),
	(441, 96, 14),
	(442, 96, 24),
	(443, 97, 5),
	(444, 97, 14),
	(445, 97, 26),
	(446, 98, 6),
	(447, 98, 8),
	(448, 98, 14),
	(449, 99, 8),
	(450, 99, 14),
	(452, 101, 4),
	(453, 101, 6),
	(454, 101, 8),
	(455, 101, 11),
	(456, 101, 13),
	(457, 101, 14),
	(458, 101, 21),
	(459, 101, 22),
	(460, 100, 4),
	(461, 102, 4),
	(462, 102, 6),
	(463, 102, 11),
	(464, 102, 13),
	(465, 102, 14),
	(466, 102, 19),
	(467, 102, 21),
	(468, 102, 22),
	(469, 88, 4),
	(470, 88, 10),
	(471, 88, 14),
	(472, 88, 24),
	(473, 88, 25),
	(474, 88, 27),
	(475, 89, 4),
	(476, 89, 14),
	(477, 89, 24),
	(478, 91, 14),
	(479, 91, 25),
	(480, 91, 26),
	(481, 65, 7),
	(482, 65, 10),
	(483, 65, 14),
	(484, 103, 4),
	(485, 104, 4),
	(486, 104, 12),
	(487, 104, 20),
	(488, 85, 4),
	(489, 85, 14),
	(490, 85, 25),
	(491, 85, 27);
/*!40000 ALTER TABLE `product_ingredient` ENABLE KEYS */;


-- Dumping structure for table cakencookies.product_rate
CREATE TABLE IF NOT EXISTS `product_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `rate` float(10,2) NOT NULL,
  `discounted_rate` float(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.product_rate: ~36 rows (approximately)
/*!40000 ALTER TABLE `product_rate` DISABLE KEYS */;
INSERT INTO `product_rate` (`id`, `product_id`, `size_id`, `rate`, `discounted_rate`) VALUES
	(135, 67, 5, 55.00, 55.00),
	(136, 68, 7, 12.00, 12.00),
	(137, 69, 8, 9.00, 9.00),
	(138, 70, 9, 6.00, 6.00),
	(139, 71, 7, 12.00, 12.00),
	(140, 72, 10, 22.00, 22.00),
	(141, 73, 11, 50.00, 50.00),
	(142, 74, 11, 55.00, 55.00),
	(143, 75, 11, 55.00, 55.00),
	(144, 76, 11, 45.00, 45.00),
	(145, 77, 11, 45.00, 45.00),
	(147, 79, 11, 45.00, 45.00),
	(148, 80, 11, 20.00, 20.00),
	(149, 81, 11, 45.00, 45.00),
	(150, 82, 11, 60.00, 60.00),
	(151, 83, 5, 210.00, 210.00),
	(152, 84, 5, 250.00, 250.00),
	(155, 86, 1, 30.00, 30.00),
	(156, 87, 17, 70.00, 70.00),
	(161, 66, 5, 55.00, 55.00),
	(162, 90, 6, 25.00, 25.00),
	(165, 93, 17, 50.00, 50.00),
	(166, 94, 3, 50.00, 50.00),
	(168, 96, 6, 30.00, 30.00),
	(169, 97, 17, 30.00, 30.00),
	(170, 98, 17, 40.00, 40.00),
	(171, 99, 17, 40.00, 40.00),
	(173, 101, 13, 550.00, 550.00),
	(174, 100, 10, 0.00, 120.00),
	(175, 102, 13, 650.00, 650.00),
	(176, 88, 17, 70.00, 70.00),
	(177, 89, 17, 60.00, 60.00),
	(178, 91, 6, 15.00, 15.00),
	(179, 65, 5, 55.00, 55.00),
	(182, 85, 4, 50.00, 50.00);
/*!40000 ALTER TABLE `product_rate` ENABLE KEYS */;


-- Dumping structure for table cakencookies.product_review
CREATE TABLE IF NOT EXISTS `product_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `review_details` text,
  `review_point` int(1) NOT NULL,
  `review_by_name` varchar(200) NOT NULL,
  `review_by_email` varchar(200) NOT NULL,
  `review_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.product_review: ~0 rows (approximately)
/*!40000 ALTER TABLE `product_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_review` ENABLE KEYS */;


-- Dumping structure for table cakencookies.size
CREATE TABLE IF NOT EXISTS `size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(55) NOT NULL,
  `name` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.size: ~16 rows (approximately)
/*!40000 ALTER TABLE `size` DISABLE KEYS */;
INSERT INTO `size` (`id`, `code`, `name`) VALUES
	(1, '10001', 'Small'),
	(3, '10002', 'Mini'),
	(4, '10003', 'Large'),
	(5, '10004', '400 gm'),
	(6, '10005', 'Per Piece'),
	(7, '10006', '65 gm'),
	(8, '10007', '45 gm'),
	(9, '10008', '25 gm'),
	(10, '10009', '120 gm'),
	(11, '10010', '50 gm'),
	(12, '10011', '250 gm'),
	(13, '10012', '500 gm'),
	(14, '10013', '80 gm'),
	(15, '10014', '60 gm'),
	(16, '10015', 'Structued'),
	(17, '100016', 'Regular');
/*!40000 ALTER TABLE `size` ENABLE KEYS */;


-- Dumping structure for table cakencookies.user_group
CREATE TABLE IF NOT EXISTS `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL COMMENT '0:active, 1:inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.user_group: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` (`id`, `group_name`, `status`) VALUES
	(21, 'Admin', 0);
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;


-- Dumping structure for table cakencookies.user_group_member
CREATE TABLE IF NOT EXISTS `user_group_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT '0',
  `emp_id` varchar(20) NOT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0: no access ; 1:access',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`group_id`,`emp_id`),
  KEY `FK_emp_infos` (`emp_id`),
  CONSTRAINT `FK__user_group` FOREIGN KEY (`group_id`) REFERENCES `user_group` (`id`),
  CONSTRAINT `FK_emp_infos` FOREIGN KEY (`emp_id`) REFERENCES `user_infos` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.user_group_member: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_group_member` DISABLE KEYS */;
INSERT INTO `user_group_member` (`id`, `group_id`, `emp_id`, `status`) VALUES
	(2, 21, '1000001', 1);
/*!40000 ALTER TABLE `user_group_member` ENABLE KEYS */;


-- Dumping structure for table cakencookies.user_group_permission
CREATE TABLE IF NOT EXISTS `user_group_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT '0',
  `action_id` int(11) DEFAULT '0',
  `status` tinyint(1) NOT NULL COMMENT '0: Not Permit, 1: Permit',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Index 2` (`group_id`,`action_id`),
  KEY `FK__activity_actions` (`action_id`),
  CONSTRAINT `FK__activity_actions` FOREIGN KEY (`action_id`) REFERENCES `web_actions` (`id`),
  CONSTRAINT `FK__user_group_id` FOREIGN KEY (`group_id`) REFERENCES `user_group` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=626 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.user_group_permission: ~48 rows (approximately)
/*!40000 ALTER TABLE `user_group_permission` DISABLE KEYS */;
INSERT INTO `user_group_permission` (`id`, `group_id`, `action_id`, `status`) VALUES
	(251, 21, 11, 1),
	(252, 21, 12, 1),
	(253, 21, 13, 1),
	(254, 21, 14, 1),
	(255, 21, 15, 1),
	(256, 21, 16, 1),
	(257, 21, 43, 1),
	(258, 21, 44, 1),
	(260, 21, 45, 1),
	(583, 21, 10, 1),
	(588, 21, 50, 1),
	(589, 21, 51, 1),
	(590, 21, 52, 1),
	(591, 21, 53, 1),
	(592, 21, 54, 1),
	(593, 21, 55, 1),
	(594, 21, 56, 1),
	(595, 21, 57, 1),
	(596, 21, 58, 1),
	(597, 21, 59, 1),
	(598, 21, 60, 1),
	(599, 21, 61, 1),
	(600, 21, 62, 1),
	(601, 21, 63, 1),
	(602, 21, 64, 1),
	(603, 21, 65, 1),
	(604, 21, 66, 1),
	(605, 21, 67, 1),
	(606, 21, 68, 1),
	(607, 21, 69, 1),
	(608, 21, 70, 1),
	(609, 21, 71, 1),
	(610, 21, 72, 1),
	(611, 21, 73, 1),
	(612, 21, 74, 1),
	(613, 21, 75, 1),
	(614, 21, 76, 1),
	(615, 21, 77, 1),
	(616, 21, 78, 1),
	(617, 21, 79, 1),
	(618, 21, 80, 1),
	(619, 21, 81, 1),
	(620, 21, 82, 1),
	(621, 21, 83, 1),
	(622, 21, 84, 1),
	(623, 21, 85, 1),
	(624, 21, 86, 1),
	(625, 21, 87, 1);
/*!40000 ALTER TABLE `user_group_permission` ENABLE KEYS */;


-- Dumping structure for table cakencookies.user_infos
CREATE TABLE IF NOT EXISTS `user_infos` (
  `emp_id` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `designation_name` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `age` varchar(100) NOT NULL,
  `nid_no` varchar(50) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `blood_group` varchar(50) DEFAULT NULL,
  `health_card_no` varchar(50) DEFAULT NULL,
  `is_active_home_page` tinyint(1) NOT NULL DEFAULT '0',
  `remarks` text,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.user_infos: ~0 rows (approximately)
/*!40000 ALTER TABLE `user_infos` DISABLE KEYS */;
INSERT INTO `user_infos` (`emp_id`, `full_name`, `designation_name`, `address`, `age`, `nid_no`, `photo`, `contact_no`, `email`, `blood_group`, `health_card_no`, `is_active_home_page`, `remarks`) VALUES
	('1000001', 'Momit', 'Software Engineer', '', '', '', 'images/employee/momit.jpg', '01737151125', 'shofiqueshahin@gmail.com', 'B+', '201800001', 0, 'aaaaaaaaaa');
/*!40000 ALTER TABLE `user_infos` ENABLE KEYS */;


-- Dumping structure for table cakencookies.web_actions
CREATE TABLE IF NOT EXISTS `web_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_name` varchar(50) NOT NULL,
  `module_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:active, 1:inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.web_actions: ~48 rows (approximately)
/*!40000 ALTER TABLE `web_actions` DISABLE KEYS */;
INSERT INTO `web_actions` (`id`, `activity_name`, `module_id`, `status`) VALUES
	(10, 'Employee enrty', 1, 0),
	(11, 'employee permission', 1, 0),
	(12, 'employee update', 1, 0),
	(13, 'employee delete', 1, 0),
	(14, 'control panel', 6, 0),
	(15, 'employee List', 1, 0),
	(16, 'permission grid', 1, 0),
	(43, 'activity action access', 1, 0),
	(44, 'group permission', 1, 0),
	(45, 'website permission', 1, 0),
	(50, 'Category Entry', 3, 0),
	(51, 'Category Delete', 3, 0),
	(52, 'Category Update', 3, 0),
	(53, 'Category Grid', 3, 0),
	(54, 'Ingredient Entry', 3, 0),
	(55, 'Ingredient Delete', 3, 0),
	(56, 'Ingredient Update', 3, 0),
	(57, 'Ingredient Grid', 3, 0),
	(58, 'Size Entry', 3, 0),
	(59, 'Size Delete', 3, 0),
	(60, 'Size Update', 3, 0),
	(61, 'Size Grid', 3, 0),
	(62, 'Product Entry', 3, 0),
	(63, 'Product Delete', 3, 0),
	(64, 'Product Update', 3, 0),
	(65, 'Product Grid', 3, 0),
	(66, 'Customer Entry', 5, 0),
	(67, 'Customer Delete', 5, 0),
	(68, 'Customer Update', 5, 0),
	(69, 'Customer Grid', 5, 0),
	(70, 'Outlet Entry', 6, 0),
	(71, 'Outlet Update', 6, 0),
	(72, 'Outlet Delete', 6, 0),
	(73, 'Outlet Grid', 6, 0),
	(74, 'Order Entry', 4, 0),
	(75, 'Order Delete', 4, 0),
	(76, 'Order Update', 4, 0),
	(77, 'Order Grid', 4, 0),
	(78, 'cupon entry', 6, 0),
	(79, 'cupon delete', 6, 0),
	(80, 'cupon update', 6, 0),
	(81, 'cupon grid', 6, 0),
	(82, 'Customer Report', 2, 0),
	(83, 'Order Summary Report', 2, 0),
	(84, 'Order Details Report', 2, 0),
	(85, 'Product Report', 2, 0),
	(86, 'Order VS Payment Report', 2, 0),
	(87, 'Product sell report', 2, 0);
/*!40000 ALTER TABLE `web_actions` ENABLE KEYS */;


-- Dumping structure for table cakencookies.web_login
CREATE TABLE IF NOT EXISTS `web_login` (
  `emp_id` varchar(10) NOT NULL,
  `is_login` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:not logged, 1: logged in',
  `chat_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT ' 1:available,2:meeting,3:busy',
  PRIMARY KEY (`emp_id`),
  CONSTRAINT `emp_id_fk` FOREIGN KEY (`emp_id`) REFERENCES `user_infos` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.web_login: ~0 rows (approximately)
/*!40000 ALTER TABLE `web_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `web_login` ENABLE KEYS */;


-- Dumping structure for table cakencookies.web_menu
CREATE TABLE IF NOT EXISTS `web_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_menu_id` int(11) DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `menu` varchar(50) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_web_menu_web_menu` (`parent_menu_id`),
  CONSTRAINT `FK_web_menu_web_menu` FOREIGN KEY (`parent_menu_id`) REFERENCES `web_menu` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.web_menu: ~33 rows (approximately)
/*!40000 ALTER TABLE `web_menu` DISABLE KEYS */;
INSERT INTO `web_menu` (`id`, `parent_menu_id`, `title`, `menu`, `description`) VALUES
	(16, 16, 'Services', 'services', '<p>Shastho Shikkha ( Ss), &nbsp;&nbsp; <span style="background-color:transparent; color:rgb(51, 51, 51); font-family:sans-serif,arial,verdana,trebuchet ms; font-size:13px">Medical Services&nbsp; ( Ms) , </span>&nbsp;<span style="background-color:transparent; color:rgb(51, 51, 51); font-family:sans-serif,arial,verdana,trebuchet ms; font-size:13px">&nbsp; Law Awarness &amp; Services ( Las)</span> , &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\r\n\r\n<p>&nbsp;</p>\r\n'),
	(28, 28, 'ABOUT US', 'about-us', '<p>We are extremely proud to inform you our new concept, <span style="color:#3b2413"><strong>Cakencookie</strong></span>. Yes it&rsquo;s a new brand of Bakery &amp; Pastry. It&rsquo;s a sophisticated brand of Nafisa Food &amp; Beverage Ltd. The inhabitants of Dhaka City are getting accustomed to Western and European culture , at the same time huge number of expats are travelling to Bangladesh especially Dhaka due to business . Consequently hospitality industry is growing so fast. Restaurant, Cafe, Club, Bar are increasing dramatically to accomplish the need of locals and expats.</p>\r\n\r\n<p>This logical evolutionary change has drawn our attention and the thirst of people towards variety of food items drive us to shape our business concept regarding the brand, <span style="color:#3b2413"><strong>Cakencookie</strong></span>.</p>\r\n'),
	(29, 16, 'Helth Awarness', 'Helth Awarness', '<p>We awar people about some dangarous disease like Cancer, Diabetic, Strock, Adolescent Nutrition, Reproductive Health etc.</p>\r\n'),
	(30, 16, 'Diagnosis Services', 'Diagnosis Services', '<p>We provide &quot;Diagnosis Card&quot; thus people get discount on diagonisis in several Diagnostic Center For Primary Disease identifying.</p>\r\n'),
	(31, 16, 'Doctors Consultancy', 'Doctors Consultancy', '<p>We will provide/suggest Specialist&nbsp; doctor and best treatment process for a specific disease . Services holder will&nbsp; get Specialist Doctors Consultancy From Self Service Center <span style="background-color:transparent; color:rgb(51, 51, 51); font-family:sans-serif,arial,verdana,trebuchet ms; font-size:13px">w</span><span style="background-color:transparent; color:rgb(51, 51, 51); font-family:sans-serif,arial,verdana,trebuchet ms; font-size:13px">ith w</span><span style="background-color:transparent; color:rgb(51, 51, 51); font-family:sans-serif,arial,verdana,trebuchet ms; font-size:13px">eb Camera.</span></p>\r\n'),
	(32, 16, 'Medicin Care', 'Medicin Care', '<p>One of the Main target is to provide people medicine for cheap rate and free(Special cases) From Selective Medicin Shop With internet Health Card.</p>\r\n'),
	(33, 16, 'Doctors Serial', 'Doctors Serial', '<p>We will arrange doctor&#39;s serial, because it is very difficult to manage a serial for a rural people</p>\r\n'),
	(34, 16, 'Law Services', 'Law Services', '<p>Grow awarness &amp; law support against tourture, childMarige,evetiging, dowry, terorisom, intoxicating &amp; militancy</p>\r\n'),
	(35, 28, 'OUR MISSION', 'mission', '<p>Our competent team members are the main strength point of this sophisticated food brand whose are committed to provide superior quality of bakery, pastries, savories, cakes &amp; ice creams. Our motto is to achieve customers satisfaction through implementing total quality management (TQM) . We are highly committed to collect fresh &amp; purest raw materials, process them in a very systematic and hygienic way for making the fine tuned product by our talented chefs. We do focus on our customer feedback &amp; work on it to provide them wow experience that makes them repeat customers.</p>\r\n'),
	(36, 28, 'OUR VISSION', 'vission', 'Be the leader of the bakery market through ensuring quality, service, innovation & affordable prices to fulfill the needs of our precious customer & consumer.'),
	(37, 28, 'PRODUCTS WE OFFER', 'service', '<p>We believe that the most promising cafes are those which have firm determination to meet guest expectations through their quality of product &amp; Service. This belief has lead us to flourish the brand <span style="color:#3b2413"><strong>Cakencookie </strong></span>that will offer quality of Bakery, Pastry, Hot Savoury, accompanied of varieties coffee and different flavoured Ice-Cream. In short, it&rsquo;s a one stop service offer for the guest convenient only.</p>\r\n'),
	(38, 38, 'Contact', 'contact', '<p>Contact address here</p>\r\n'),
	(39, 38, 'Address', 'address', '<p>Mohammadpur, Dhaka, Bangladesh 1207,</p><br />\r\n<p>Tongi, Gazipur, Bangladesh 1207,</p>\r\n\r\n'),
	(40, 38, 'Mobile', 'mobile', '<p>01980340482</p>\r\n'),
	(41, 38, 'Email', 'email', '<p>support@cakencookie.net</p>\r\n'),
	(42, 38, 'Office Time', ' Office Time', '<p>&nbsp;8:45 AM&nbsp; to 5:00 PM</p>\r\n'),
	(43, 43, 'Terms & Conditions', 'Terms & Conditions', '<p>OVERVIEW</p>\r\n\r\n<p>This website is operated by Cakencookies. Throughout the site, the terms &ldquo;we&rdquo;, &ldquo;us&rdquo; and &ldquo;our&rdquo; refer to Cakencookies. Cakencookies offers this website, including all information, tools and services available from this site to you, the user, conditioned upon your acceptance of all terms, conditions, policies and notices stated here.</p>\r\n\r\n<p>By visiting our site and/ or purchasing something from us, you engage in our &ldquo;Service&rdquo; and agree to be bound by the following terms and conditions (&ldquo;Terms of Service&rdquo;, &ldquo;Terms&rdquo;), including those additional terms and conditions and policies referenced herein and/or available by hyperlink. These Terms of Service apply to all users of the site, including without limitation users who are browsers, vendors, customers, merchants, and/ or contributors of content.</p>\r\n\r\n<p>Please read these Terms of Service carefully before accessing or using our website. By accessing or using any part of the site, you agree to be bound by these Terms of Service. If you do not agree to all the terms and conditions of this agreement, then you may not access the website or use any services. If these Terms of Service are considered an offer, acceptance is expressly limited to these Terms of Service.</p>\r\n\r\n<p>Any new features or tools which are added to the current store shall also be subject to the Terms of Service. You can review the most current version of the Terms of Service at any time on this page. We reserve the right to update, change or replace any part of these Terms of Service by posting updates and/or changes to our website. It is your responsibility to check this page periodically for changes. Your continued use of or access to the website following the posting of any changes constitutes acceptance of those changes.</p>\r\n\r\n<p>Our store is hosted on EyHost Hosting Service and 2Checkout provides us with the online e-commerce platform that allows us to sell our products and services to you.</p>\r\n\r\n<p>SECTION 1 &ndash; ONLINE STORE TERMS</p>\r\n\r\n<p>By agreeing to these Terms of Service, you represent that you are at least the age of majority in your state or province of residence, or that you are the age of majority in your state or province of residence and you have given us your consent to allow any of your minor dependents to use this site.</p>\r\n\r\n<p>You may not use our products for any illegal or unauthorized purpose nor may you, in the use of the Service, violate any laws in your jurisdiction (including but not limited to copyright laws).</p>\r\n\r\n<p>You must not transmit any worms or viruses or any code of a destructive nature.</p>\r\n\r\n<p>A breach or violation of any of the Terms will result in an immediate termination of your Services.</p>\r\n\r\n<p>SECTION 2 &ndash; GENERAL CONDITIONS</p>\r\n\r\n<p>We reserve the right to refuse service to anyone for any reason at any time.</p>\r\n\r\n<p>You understand that your content (not including credit card information), may be transferred unencrypted and involve (a) transmissions over various networks; and (b) changes to conform and adapt to technical requirements of connecting networks or devices. Credit card information is always encrypted during transfer over networks.</p>\r\n\r\n<p>You agree not to reproduce, duplicate, copy, sell, resell or exploit any portion of the Service, use of the Service, or access to the Service or any contact on the website through which the service is provided, without express written permission by us.</p>\r\n\r\n<p>The headings used in this agreement are included for convenience only and will not limit or otherwise affect these Terms.</p>\r\n\r\n<p>SECTION 3 &ndash; ACCURACY, COMPLETENESS AND TIMELINESS OF INFORMATION</p>\r\n\r\n<p>We are not responsible if information made available on this site is not accurate, complete or current. The material on this site is provided for general information only and should not be relied upon or used as the sole basis for making decisions without consulting primary, more accurate, more complete or more timely sources of information. Any reliance on the material on this site is at your own risk.</p>\r\n\r\n<p>This site may contain certain historical information. Historical information, necessarily, is not current and is provided for your reference only. We reserve the right to modify the contents of this site at any time, but we have no obligation to update any information on our site. You agree that it is your responsibility to monitor changes to our site.</p>\r\n\r\n<p>SECTION 4 &ndash; MODIFICATIONS TO THE SERVICE AND PRICES</p>\r\n\r\n<p>Prices for our products are subject to change without notice.</p>\r\n\r\n<p>We reserve the right at any time to modify or discontinue the Service (or any part or content thereof) without notice at any time.</p>\r\n\r\n<p>We shall not be liable to you or to any third-party for any modification, price change, suspension or discontinuance of the Service.</p>\r\n\r\n<p>SECTION 5 &ndash; PRODUCTS OR SERVICES (if applicable)</p>\r\n\r\n<p>Certain products or services may be available exclusively online through the website. These products or services may have limited quantities and are subject to return or exchange only according to our Return Policy.</p>\r\n\r\n<p>We have made every effort to display as accurately as possible the colors and images of our products that appear at the store. We cannot guarantee that your computer monitor&rsquo;s display of any color will be accurate.</p>\r\n\r\n<p>We reserve the right, but are not obligated, to limit the sales of our products or Services to any person, geographic region or jurisdiction. We may exercise this right on a case-by-case basis. We reserve the right to limit the quantities of any products or services that we offer. All descriptions of products or product pricing are subject to change at anytime without notice, at the sole discretion of us. We reserve the right to discontinue any product at any time. Any offer for any product or service made on this site is void where prohibited.</p>\r\n\r\n<p>We do not warrant that the quality of any products, services, information, or other material purchased or obtained by you will meet your expectations, or that any errors in the Service will be corrected.</p>\r\n\r\n<p>SECTION 6 &ndash; ACCURACY OF BILLING AND ACCOUNT INFORMATION</p>\r\n\r\n<p>We reserve the right to refuse any order you place with us. We may, in our sole discretion, limit or cancel quantities purchased per person, per household or per order. These restrictions may include orders placed by or under the same customer account, the same credit card, and/or orders that use the same billing and/or shipping address. In the event that we make a change to or cancel an order, we may attempt to notify you by contacting the e-mail and/or billing address/phone number provided at the time the order was made. We reserve the right to limit or prohibit orders that, in our sole judgment, appear to be placed by dealers, resellers or distributors.</p>\r\n\r\n<p>You agree to provide current, complete and accurate purchase and account information for all purchases made at our store. You agree to promptly update your account and other information, including your email address and credit card numbers and expiration dates, so that we can complete your transactions and contact you as needed.</p>\r\n\r\n<p>For more detail, please review our Returns Policy.</p>\r\n\r\n<p>SECTION 7 &ndash; OPTIONAL TOOLS</p>\r\n\r\n<p>We may provide you with access to third-party tools over which we neither monitor nor have any control nor input.</p>\r\n\r\n<p>You acknowledge and agree that we provide access to such tools &rdquo;as is&rdquo; and &ldquo;as available&rdquo; without any warranties, representations or conditions of any kind and without any endorsement. We shall have no liability whatsoever arising from or relating to your use of optional third-party tools.</p>\r\n\r\n<p>Any use by you of optional tools offered through the site is entirely at your own risk and discretion and you should ensure that you are familiar with and approve of the terms on which tools are provided by the relevant third-party provider(s).</p>\r\n\r\n<p>We may also, in the future, offer new services and/or features through the website (including, the release of new tools and resources). Such new features and/or services shall also be subject to these Terms of Service.</p>\r\n\r\n<p>SECTION 8 &ndash; THIRD-PARTY LINKS</p>\r\n\r\n<p>Certain content, products and services available via our Service may include materials from third-parties.</p>\r\n\r\n<p>Third-party links on this site may direct you to third-party websites that are not affiliated with us. We are not responsible for examining or evaluating the content or accuracy and we do not warrant and will not have any liability or responsibility for any third-party materials or websites, or for any other materials, products, or services of third-parties.</p>\r\n\r\n<p>We are not liable for any harm or damages related to the purchase or use of goods, services, resources, content, or any other transactions made in connection with any third-party websites. Please review carefully the third-party&rsquo;s policies and practices and make sure you understand them before you engage in any transaction. Complaints, claims, concerns, or questions regarding third-party products should be directed to the third-party.</p>\r\n\r\n<p>SECTION 9 &ndash; USER COMMENTS, FEEDBACK AND OTHER SUBMISSIONS</p>\r\n\r\n<p>If, at our request, you send certain specific submissions (for example contest entries) or without a request from us you send creative ideas, suggestions, proposals, plans, or other materials, whether online, by email, by postal mail, or otherwise (collectively, &lsquo;comments&rsquo;), you agree that we may, at any time, without restriction, edit, copy, publish, distribute, translate and otherwise use in any medium any comments that you forward to us. We are and shall be under no obligation (1) to maintain any comments in confidence; (2) to pay compensation for any comments; or (3) to respond to any comments.</p>\r\n\r\n<p>We may, but have no obligation to, monitor, edit or remove content that we determine in our sole discretion are unlawful, offensive, threatening, libelous, defamatory, pornographic, obscene or otherwise objectionable or violates any party&rsquo;s intellectual property or these Terms of Service.</p>\r\n\r\n<p>You agree that your comments will not violate any right of any third-party, including copyright, trademark, privacy, personality or other personal or proprietary right. You further agree that your comments will not contain libelous or otherwise unlawful, abusive or obscene material, or contain any computer virus or other malware that could in any way affect the operation of the Service or any related website. You may not use a false e-mail address, pretend to be someone other than yourself, or otherwise mislead us or third-parties as to the origin of any comments. You are solely responsible for any comments you make and their accuracy. We take no responsibility and assume no liability for any comments posted by you or any third-party.</p>\r\n\r\n<p>SECTION 10 &ndash; PERSONAL INFORMATION</p>\r\n\r\n<p>Your submission of personal information through the store is governed by our Privacy Policy. To view our Privacy Policy.</p>\r\n\r\n<p>SECTION 11 &ndash; ERRORS, INACCURACIES AND OMISSIONS</p>\r\n\r\n<p>Occasionally there may be information on our site or in the Service that contains typographical errors, inaccuracies or omissions that may relate to product descriptions, pricing, promotions, offers, product shipping charges, transit times and availability. We reserve the right to correct any errors, inaccuracies or omissions, and to change or update information or cancel orders if any information in the Service or on any related website is inaccurate at any time without prior notice (including after you have submitted your order).</p>\r\n\r\n<p>We undertake no obligation to update, amend or clarify information in the Service or on any related website, including without limitation, pricing information, except as required by law. No specified update or refresh date applied in the Service or on any related website, should be taken to indicate that all information in the Service or on any related website has been modified or updated.</p>\r\n\r\n<p>SECTION 12 &ndash; PROHIBITED USES</p>\r\n\r\n<p>In addition to other prohibitions as set forth in the Terms of Service, you are prohibited from using the site or its content: (a) for any unlawful purpose; (b) to solicit others to perform or participate in any unlawful acts; (c) to violate any international, federal, provincial or state regulations, rules, laws, or local ordinances; (d) to infringe upon or violate our intellectual property rights or the intellectual property rights of others; (e) to harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate based on gender, sexual orientation, religion, ethnicity, race, age, national origin, or disability; (f) to submit false or misleading information; (g) to upload or transmit viruses or any other type of malicious code that will or may be used in any way that will affect the functionality or operation of the Service or of any related website, other websites, or the Internet; (h) to collect or track the personal information of others; (i) to spam, phish, pharm, pretext, spider, crawl, or scrape; (j) for any obscene or immoral purpose; or (k) to interfere with or circumvent the security features of the Service or any related website, other websites, or the Internet. We reserve the right to terminate your use of the Service or any related website for violating any of the prohibited uses.</p>\r\n\r\n<p>SECTION 13 &ndash; DISCLAIMER OF WARRANTIES; LIMITATION OF LIABILITY</p>\r\n\r\n<p>We do not guarantee, represent or warrant that your use of our service will be uninterrupted, timely, secure or error-free.</p>\r\n\r\n<p>We do not warrant that the results that may be obtained from the use of the service will be accurate or reliable.</p>\r\n\r\n<p>You agree that from time to time we may remove the service for indefinite periods of time or cancel the service at any time, without notice to you.</p>\r\n\r\n<p>You expressly agree that your use of, or inability to use, the service is at your sole risk. The service and all products and services delivered to you through the service are (except as expressly stated by us) provided &lsquo;as is&rsquo; and &lsquo;as available&rsquo; for your use, without any representation, warranties or conditions of any kind, either express or implied, including all implied warranties or conditions of merchantability, merchantable quality, fitness for a particular purpose, durability, title, and non-infringement.</p>\r\n\r\n<p>In no case shall Cakencookies, our directors, officers, employees, affiliates, agents, contractors, interns, suppliers, service providers or licensors be liable for any injury, loss, claim, or any direct, indirect, incidental, punitive, special, or consequential damages of any kind, including, without limitation lost profits, lost revenue, lost savings, loss of data, replacement costs, or any similar damages, whether based in contract, tort (including negligence), strict liability or otherwise, arising from your use of any of the service or any products procured using the service, or for any other claim related in any way to your use of the service or any product, including, but not limited to, any errors or omissions in any content, or any loss or damage of any kind incurred as a result of the use of the service or any content (or product) posted, transmitted, or otherwise made available via the service, even if advised of their possibility. Because some states or jurisdictions do not allow the exclusion or the limitation of liability for consequential or incidental damages, in such states or jurisdictions, our liability shall be limited to the maximum extent permitted by law.</p>\r\n\r\n<p>SECTION 14 &ndash; INDEMNIFICATION</p>\r\n\r\n<p>You agree to indemnify, defend and hold harmless King&rsquo;s Confectionery (Bangladesh) Pte. Ltd. and our parent, subsidiaries, affiliates, partners, officers, directors, agents, contractors, licensors, service providers, subcontractors, suppliers, interns and employees, harmless from any claim or demand, including reasonable attorneys&rsquo; fees, made by any third-party due to or arising out of your breach of these Terms of Service or the documents they incorporate by reference, or your violation of any law or the rights of a third-party.</p>\r\n\r\n<p>SECTION 15 &ndash; SEVERABILITY</p>\r\n\r\n<p>In the event that any provision of these Terms of Service is determined to be unlawful, void or unenforceable, such provision shall nonetheless be enforceable to the fullest extent permitted by applicable law, and the unenforceable portion shall be deemed to be severed from these Terms of Service, such determination shall not affect the validity and enforceability of any other remaining provisions.</p>\r\n\r\n<p>SECTION 16 &ndash; TERMINATION</p>\r\n\r\n<p>The obligations and liabilities of the parties incurred prior to the termination date shall survive the termination of this agreement for all purposes.</p>\r\n\r\n<p>These Terms of Service are effective unless and until terminated by either you or us. You may terminate these Terms of Service at any time by notifying us that you no longer wish to use our Services, or when you cease using our site.</p>\r\n\r\n<p>If in our sole judgment you fail, or we suspect that you have failed, to comply with any term or provision of these Terms of Service, we also may terminate this agreement at any time without notice and you will remain liable for all amounts due up to and including the date of termination; and/or accordingly may deny you access to our Services (or any part thereof).</p>\r\n\r\n<p>SECTION 17 &ndash; ENTIRE AGREEMENT</p>\r\n\r\n<p>The failure of us to exercise or enforce any right or provision of these Terms of Service shall not constitute a waiver of such right or provision.</p>\r\n\r\n<p>These Terms of Service and any policies or operating rules posted by us on this site or in respect to The Service constitutes the entire agreement and understanding between you and us and govern your use of the Service, superseding any prior or contemporaneous agreements, communications and proposals, whether oral or written, between you and us (including, but not limited to, any prior versions of the Terms of Service).</p>\r\n\r\n<p>Any ambiguities in the interpretation of these Terms of Service shall not be construed against the drafting party.</p>\r\n\r\n<p>SECTION 18 &ndash; JURISDICTION AND RESTRICTION</p>\r\n\r\n<p>Cakencookies controls and maintains this Web Site from Bangladesh. The materials and information contained in this section of this Web Site, relating to Bangladesh, is directed at and restricted to individuals resident in or entities having a place of business in Bangladesh ONLY. The Cakencookies makes no representation that the materials and information contained herein is appropriate or available for use in other locations / jurisdictions.</p>\r\n\r\n<p>These Terms and Conditions are governed by and construed in accordance with the laws of Bangladesh and any dispute relating thereto shall be subject to the non-exclusive jurisdiction of the courts of Bangladesh.</p>\r\n\r\n<p>SECTION 19 &ndash; CHANGES TO TERMS OF SERVICE</p>\r\n\r\n<p>You can review the most current version of the Terms of Service at any time at this page.</p>\r\n\r\n<p>We reserve the right, at our sole discretion, to update, change or replace any part of these Terms of Service by posting updates and changes to our website. It is your responsibility to check our website periodically for changes. Your continued use of or access to our website or the Service following the posting of any changes to these Terms of Service constitutes acceptance of those changes.</p>\r\n\r\n<p>SECTION 20 &ndash; CONTACT INFORMATION</p>\r\n'),
	(45, NULL, 'Privacy Policy', 'Privacy', '<p>SECTION 1 &ndash; WHAT DO WE DO WITH YOUR INFORMATION?</p>\r\n\r\n<p>When you purchase something from our store, as part of the buying and selling process, we collect the personal information you give us such as your name, address and email address.</p>\r\n\r\n<p>When you browse our store, we also automatically receive your computer&rsquo;s internet protocol (IP) address in order to provide us with information that helps us learn about your browser and operating system.</p>\r\n\r\n<p>Email marketing (if applicable): With your permission, we may send you emails about our store, new products and other updates.</p>\r\n\r\n<p>SECTION 2 &ndash; CONSENT</p>\r\n\r\n<p>How do you get my consent?</p>\r\n\r\n<p>When you provide us with personal information to complete a transaction, verify your credit card, place an order, arrange for a delivery or return a purchase, we imply that you consent to our collecting it and using it for that specific reason only.</p>\r\n\r\n<p>If we ask for your personal information for a secondary reason, like marketing, we will either ask you directly for your expressed consent, or provide you with an opportunity to say no.</p>\r\n\r\n<p>How do I withdraw my consent?</p>\r\n\r\n<p>If after you opt-in, you change your mind, you may withdrawing your consent for us to contact you, for the continued collection, use or disclosure of your information, at anytime, by contacting us at info@kingsbd.com or mailing us at:</p>\r\n\r\n<p>Cakencookies</p>\r\n\r\n<p>House No. 17, Road No. 11, Block G, Banani, Dhaka-1213, Bangladesh</p>\r\n\r\n<p>SECTION 3 &ndash; DISCLOSURE</p>\r\n\r\n<p>We may disclose your personal information if we are required by law to do so or if you violate our Terms of Service.</p>\r\n\r\n<p>SECTION 4 &ndash; EyHOST HOSTING SERVICE &amp; 2CHECKOUT</p>\r\n\r\n<p>Our store is hosted on EyHost Hosting Service and our direct payment gateway is provided by 2Checkout. They provide us with the online e-commerce platform that allows us to sell our products and services to you.</p>\r\n\r\n<p>Your data is stored through EyHost Hosting Service&rsquo;s and 2Checkout&rsquo;s data storage, databases and the general 2Checkout application. They store your data on a secure server behind a firewall.</p>\r\n\r\n<p>Payment:</p>\r\n\r\n<p>If you choose a direct payment gateway to complete your purchase, then 2Checkout stores your credit card data. It is encrypted through the Payment Card Industry Data Security Standard (PCI-DSS). Your purchase transaction data is stored only as long as is necessary to complete your purchase transaction. After that is complete, your purchase transaction information is deleted.</p>\r\n\r\n<p>All direct payment gateways adhere to the standards set by PCI-DSS as managed by the PCI Security Standards Council, which is a joint effort of brands like Visa, MasterCard, American Express and Discover.</p>\r\n\r\n<p>PCI-DSS requirements help ensure the secure handling of credit card information by our store and its service providers.</p>\r\n\r\n<p>For more insight, you may also want to read 2Checkout&rsquo;s Terms of Service here https://www.2checkout.com/policies/terms-of-use or Privacy Statement here https://www.2checkout.com/policies/privacy-policy.</p>\r\n\r\n<p>SECTION 5 &ndash; THIRD-PARTY SERVICES</p>\r\n\r\n<p>In general, the third-party providers used by us will only collect, use and disclose your information to the extent necessary to allow them to perform the services they provide to us.</p>\r\n\r\n<p>However, certain third-party service providers, such as payment gateways and other payment transaction processors, have their own privacy policies in respect to the information we are required to provide to them for your purchase-related transactions.</p>\r\n\r\n<p>For these providers, we recommend that you read their privacy policies so you can understand the manner in which your personal information will be handled by these providers.</p>\r\n\r\n<p>In particular, remember that certain providers may be located in or have facilities that are located a different jurisdiction than either you or us. So if you elect to proceed with a transaction that involves the services of a third-party service provider, then your information may become subject to the laws of the jurisdiction(s) in which that service provider or its facilities are located.</p>\r\n\r\n<p>Once you leave our store&rsquo;s website or are redirected to a third-party website or application, you are no longer governed by this Privacy Policy or our website&rsquo;s Terms of Service.</p>\r\n\r\n<p>Links</p>\r\n\r\n<p>When you click on links on our store, they may direct you away from our site. We are not responsible for the privacy practices of other sites and encourage you to read their privacy statements.</p>\r\n\r\n<p>Google analytics:</p>\r\n\r\n<p>Our store uses Google Analytics to help us learn about who visits our site and what pages are being looked at.</p>\r\n\r\n<p>SECTION 6 &ndash; SECURITY</p>\r\n\r\n<p>To protect your personal information, we take reasonable precautions and follow industry best practices to make sure it is not inappropriately lost, misused, accessed, disclosed, altered or destroyed.</p>\r\n\r\n<p>If you provide us with your credit card information, the information is encrypted using secure socket layer technology (SSL) and stored with a AES-256 encryption.&nbsp; Although no method of transmission over the Internet or electronic storage is 100% secure, we follow all PCI-DSS requirements and implement additional generally accepted industry standards.</p>\r\n\r\n<p>SECTION 7 &ndash; COOKIES</p>\r\n\r\n<p>In order to improve our Internet service to you, we will occasionally use a &ldquo;cookie&rdquo; and/or other similar files or programs which may place certain information on your computer&rsquo;s hard drive when you visit an Cakencookies&rsquo;s web site. A cookie is a small amount of data that our web server sends to your web browser when you visit certain parts of our site. We may use cookies to:</p>\r\n\r\n<p>&nbsp;&nbsp;&nbsp; allow us to recognise the PC you are using when you return to our web site so that we can understand your interest in our web site and tailor its content and advertisements to match your interests (This type of cookie may be stored permanently on your PC but does not contain any information that can identify you personally.);<br />\r\n&nbsp;&nbsp;&nbsp; identify you after you have logged in by storing a temporary reference number in the cookie so that our web server can conduct a dialogue with you while simultaneously dealing with other customers. (Your browser keeps this type of cookie until you log off or close down your browser when these types of cookie are normally deleted. No other information is stored in this type of cookie.);<br />\r\n&nbsp;&nbsp;&nbsp; allow you to carry information across pages of our site and avoid having to re-enter that information;<br />\r\n&nbsp;&nbsp;&nbsp; allow you access to stored information if you register for any of our on-line services;<br />\r\n&nbsp;&nbsp;&nbsp; enable us to produce statistical information (anonymous) which helps us to improve the structure and content of our web site;<br />\r\n&nbsp;&nbsp;&nbsp; enable us to evaluate the effectiveness of our advertising and promotions.</p>\r\n\r\n<p>Cookies do not enable us to gather personal information about you unless you give the information to our server. Most Internet browser software allows the blocking of all cookies or enables you to receive a warning before a cookie is stored. For further information, please refer to your Internet browser software instructions or help screen.</p>\r\n\r\n<p>SECTION 8 &ndash; INTERNET COMMUNICATIONS</p>\r\n\r\n<p>In order to maintain the security of our systems, protect our staff, record transactions, and, in certain circumstances, to prevent and detect crime or unauthorized activities, Cakencookies reserves the right to monitor all internet communications including web and email traffic into and out of its domains.</p>\r\n\r\n<p>SECTION 9 &ndash; AGE OF CONSENT</p>\r\n\r\n<p>By using this site, you represent that you are at least the age of majority in your state or province of residence, or that you are the age of majority in your state or province of residence and you have given us your consent to allow any of your minor dependents to use this site.</p>\r\n\r\n<p>SECTION 10 &ndash; CHANGES TO THIS PRIVACY POLICY</p>\r\n\r\n<p>We reserve the right to modify this privacy policy at any time, so please review it frequently. Changes and clarifications will take effect immediately upon their posting on the website. If we make material changes to this policy, we will notify you here that it has been updated, so that you are aware of what information we collect, how we use it, and under what circumstances, if any, we use and/or disclose it.</p>\r\n\r\n<p>If our store is acquired or merged with another company, your information may be transferred to the new owners so that we may continue to sell products to you.</p>\r\n\r\n<p>QUESTIONS AND CONTACT INFORMATION</p>\r\n\r\n<p>If you would like to: access, correct, amend or delete any personal information we have about you, register a complaint, or simply want more information contact our Privacy Compliance Officer at info@kingsbd.com or by mail at</p>\r\n'),
	(46, NULL, 'Refund Policy', 'Refund Policy', '<p>Any changes or cancellations to your order must be placed at least 48 hours in advance of the scheduled delivery or pick up time of your order.&nbsp; If a cancellation is placed at least 48 hours in advance, we are able to issue a 100% refund for your order.&nbsp; Any cancellations or changes made within 48 hours of the scheduled delivery or pick up time of your order are completely non-refundable.</p>\r\n\r\n<p>If you are unsatisfied with your purchase for any reason after delivery of the product has been accepted, please give us a call at</p>\r\n\r\n<p>1. Manager Operation : +8801755455-666546562932 or<br />\r\n2. Assistant Manager Operation : +88017554545-66+645+652933</p>\r\n\r\n<p>&nbsp;so we can remedy the situation.</p>\r\n'),
	(47, 28, 'Speciality', 'Speciality', '<p>A Concern of Nafisa Group<br />\r\nWe believe that the most promising cafes are those which have firm determination to meet guest expectations through their quality of product &amp; Service.</p>\r\n'),
	(48, 55, 'Special Menu', 'Special Menu', '<p>The role of a good cook ware in the preparation of a sumptuous meal cannot be over emphasized then one consider white bread</p>\r\n'),
	(49, 55, 'Welcome Subtitle', 'Welcome Subtitle', '<h6>Savory/Pastry/Cake/Coffee/Cookies/Bread</h6>\r\n'),
	(50, 55, 'We Are Best', 'We Are Best', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\r\n'),
	(51, 55, 'Fresh Dishes', 'Fresh Dishes', 'Fresh Dishes Details'),
	(52, 55, 'Verious Items', 'Verious Items', 'Verious Items details'),
	(53, 55, 'Well Service', 'Well Service', 'Well Service details'),
	(54, 55, 'Fast Delivery', 'Fast Delivery', 'Fast Delivery Details'),
	(55, NULL, 'Home', 'Home', 'details no need to edit. this is only for development reason'),
	(56, NULL, 'Social Network', 'Social Network', 'dont edit this , only for development'),
	(57, 56, 'facebook link', 'facebook link', 'https://www.facebook.com/Cakencookiee/'),
	(58, 56, 'twitter link', 'twitter link', 'https://www.twitter.com/Cakencookiee/'),
	(59, 56, 'instagram link', 'instagram  link', 'https://www.instagram.com/Cakencookiee/'),
	(60, 56, 'googleplus  link', 'googleplus  link', 'https://www.googleplus.com/Cakencookiee/');
/*!40000 ALTER TABLE `web_menu` ENABLE KEYS */;


-- Dumping structure for table cakencookies.web_module
CREATE TABLE IF NOT EXISTS `web_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:active, 1:inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.web_module: ~6 rows (approximately)
/*!40000 ALTER TABLE `web_module` DISABLE KEYS */;
INSERT INTO `web_module` (`id`, `module_name`, `status`) VALUES
	(1, 'HRM', 0),
	(2, 'Report', 0),
	(3, 'Product', 0),
	(4, 'Order', 0),
	(5, 'Customer', 0),
	(6, 'Control Panel', 0);
/*!40000 ALTER TABLE `web_module` ENABLE KEYS */;


-- Dumping structure for table cakencookies.web_notice
CREATE TABLE IF NOT EXISTS `web_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `details` text NOT NULL,
  `attachment` varchar(200) DEFAULT NULL,
  `banner_img` varchar(100) DEFAULT NULL,
  `expire_date` date DEFAULT NULL,
  `posted_by` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1:Pending, 2:Approved, 3: Deleted',
  `remarks` varchar(50) DEFAULT NULL,
  `post_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 News, 2: Events',
  `is_pinned` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Default, 1: Pinned_Post',
  PRIMARY KEY (`id`),
  KEY `FK1_poosted_by` (`posted_by`),
  CONSTRAINT `FK1_poosted_by` FOREIGN KEY (`posted_by`) REFERENCES `user_infos` (`emp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table cakencookies.web_notice: ~3 rows (approximately)
/*!40000 ALTER TABLE `web_notice` DISABLE KEYS */;
INSERT INTO `web_notice` (`id`, `title`, `details`, `attachment`, `banner_img`, `expire_date`, `posted_by`, `status`, `remarks`, `post_date`, `type`, `is_pinned`) VALUES
	(6, 'Notice Event', '<p>Up Coming</p>\r\n', 'Jellyfish.jpg,Penguins.jpg,Lighthouse.jpg', '', '2017-12-06', '1000001', 1, NULL, '2017-11-29 11:52:30', 2, 0),
	(7, 'Notice Test', '<p>Up Coming</p>\r\n', '', '', '0000-00-00', '1000001', 1, NULL, '2017-11-29 12:10:54', 1, 0),
	(12, 'Diagnosis Services Center', '<p>Popular Diagnostic Center, Thanthania Bogra.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'Untitled-1.jpg ', '', '2018-03-23', '1000001', 1, NULL, '2018-03-23 06:36:07', 2, 0);
/*!40000 ALTER TABLE `web_notice` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
