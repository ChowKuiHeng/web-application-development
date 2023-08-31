-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 31, 2023 at 05:27 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chowkuiheng`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categories_name`, `description`) VALUES
(1, 'Beverage and Food ', 'Beverage and Food is a diverse collection of products that satisfy hunger and quench thirst.'),
(2, 'Laundry Detergents', 'Laundry detergents are special cleaners for clothes. They help get rid of dirt, stains, and smells on your clothes.'),
(3, 'Snacks', 'Snacks are tasty and convenient bites of food that you can enjoy between meals.'),
(4, 'Personal Care Products', 'Personal care products encompass a wide range of items that help individuals maintain their hygiene');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

DROP TABLE IF EXISTS `contact`;
CREATE TABLE IF NOT EXISTS `contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` text NOT NULL,
  `phonenumber` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(256) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `firstname` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lastname` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `gender` enum('Male','Female') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `registration_datetime` datetime NOT NULL,
  `account_status` enum('Active','Inactive') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Active',
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `password`, `firstname`, `lastname`, `email`, `gender`, `date_of_birth`, `registration_datetime`, `account_status`, `image`) VALUES
(1, 'liu123', '$2y$10$2wMinFl3hsFSDTrf0wtf.emkVsql2k6Ui8V5iMRYH5WSpR.9MCXO2', 'kaiheng', 'liu', 'liu123@gmail.com', 'Male', '2000-06-05', '2023-08-31 11:26:08', 'Active', 'uploads/073f64a08893bb1ff1415ff5f613669e1ce02e3b-kaiheng.png'),
(2, 'chen123', '$2y$10$Aiz61Km6Zow1N8WTRmtP.u98zAOuoE8pfCVURqo9kxlpS8Fsxrh5u', 'ruihui', 'chen', 'chen12@gmail.com', 'Male', '2002-06-05', '2023-08-31 11:26:46', 'Active', 'uploads/dc05cf39a493b665e3605f95b877209e54b621ac-ruihui.png'),
(3, 'lee123', '$2y$10$uTfAp5rgZzQ9JP5AQmZDP.cpA.FTuSBdNwOif174b2INTqG0miUnm', 'junhong', 'lee', 'lee123@gmail.com', 'Male', '2000-03-04', '2023-08-31 11:27:19', 'Active', 'uploads/478549601f3c634e40b2e58b6f0c6648ae6b7bd9-junhong.png'),
(4, 'kuang123', '$2y$10$2v7TurnQA7BaJpZaDRnxfu2aECnuXxo.6Wgg6jx1TTk/Ar4Gi/EcW', 'minghao', 'kuang', 'kuang123@gmail.com', 'Male', '2002-03-27', '2023-08-31 11:27:55', 'Active', 'uploads/7d9797fe848863b121850836fb7d90e05fd6f004-minghao.png'),
(5, 'wong123', '$2y$10$P/Mq7Npt8rPsZpbdaaiSnun9kHUc235rJZF0W2BtmPP/MYGkURLX.', 'xiaojun', 'wong', 'wong123@gmail.com', 'Female', '2004-08-08', '2023-08-31 11:28:28', 'Active', 'uploads/2e555a8a2448312576ffe69e6d47279a7e7e2cb4-xiaojun.png'),
(6, 'khun123', '$2y$10$GS4pIT/LykTvyZ0zRRnI1ex9ykg9lIH4SrOm.KqncVSCEyHgLH7Ry', 'jiayie', 'khun', 'khun123@gmail.com', 'Female', '2002-08-06', '2023-08-31 11:29:02', 'Active', 'uploads/598b7b5ff066bd3cd061c955758a580b7c6e8469-jiayie.png'),
(7, 'lor123', '$2y$10$oVixov9846RAIeC4LvImuOVfYGYwjsMU49HbftKt6bNM29vD36MCe', 'jining', 'lor', 'lor123@gmail.com', 'Female', '2002-03-06', '2023-08-31 11:29:39', 'Inactive', 'uploads/ba0d2bbbaf98ad9097278f291857797d4a6321de-jining.png');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `detail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`detail_id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 12, 1),
(2, 1, 11, 1),
(3, 1, 10, 1),
(9, 2, 3, 1),
(8, 2, 2, 1),
(7, 2, 1, 1),
(11, 3, 1, 1),
(17, 4, 8, 1),
(16, 4, 5, 1),
(15, 4, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_summary`
--

DROP TABLE IF EXISTS `order_summary`;
CREATE TABLE IF NOT EXISTS `order_summary` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `order_date` datetime NOT NULL,
  `total_amount` double NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_summary`
--

INSERT INTO `order_summary` (`order_id`, `customer_id`, `order_date`, `total_amount`) VALUES
(1, 1, '2023-08-31 11:41:54', 66),
(2, 2, '2023-08-31 11:42:52', 44.3),
(3, 5, '2023-08-31 11:47:37', 23),
(4, 4, '2023-08-31 11:51:48', 13.6);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `promotion_price` double NOT NULL,
  `manufacture_date` date DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `categories_name` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created`, `modified`, `promotion_price`, `manufacture_date`, `expired_date`, `categories_name`, `image`) VALUES
(1, 'Nestle Milo Softpack', 'A popular chocolate and malt powdered drink.', 23, '2015-08-02 12:16:08', '2023-08-31 03:40:59', 0, '2012-06-12', '2014-06-12', 'Beverage and Food ', 'uploads/ca949a152f0555415d0979c824558b67ca8fa2bc-milo.png'),
(2, 'Hup Seng Cream Crackers', 'Hup Seng Cream Crackers are a popular type of biscuit known for their crisp texture and versatile taste.', 5.3, '2015-08-02 12:17:58', '2023-08-31 03:40:45', 0, '2012-05-12', '2014-05-12', 'Beverage and Food ', 'uploads/4812a761d5fa33ae2c403c20650ae2a90dcf86eb-hupseng_cracker.png'),
(3, 'Nestle Nestum 3 in 1 Original', 'Enjoy a fuller morning with Nestum 3 in 1 packed with benefits of whole grains, corn and rice.', 16, '2015-08-02 12:18:21', '2023-08-31 03:40:35', 0, '2012-04-12', '2014-04-12', 'Beverage and Food ', 'uploads/e01e7963ca96264d910f987cdb2c04fa8b37192f-nestum.png'),
(4, 'Maggi Kari', 'Maggi Kari is a popular instant noodle dish known for its rich and flavorful curry seasoning.', 4.8, '2023-06-26 06:11:52', '2023-08-31 03:37:23', 0, '2012-02-12', '2014-02-12', 'Beverage and Food ', 'uploads/f051d51e0542d68d26c39c34f3fdb1fe37ed5a6a-maggikari.png'),
(5, 'Maggi Ayam', 'Maggi Ayam is a popular instant noodle dish known for its savory chicken flavor.', 4.8, '2023-06-26 06:51:38', '2023-08-31 03:37:17', 0, '2012-03-12', '2014-03-12', 'Beverage and Food ', 'uploads/9114e22c7c1b1d8363bf2ed631fd09656a7ed85e-maggiayam.png'),
(6, 'Top Liquid Detergent Stain Buster', 'It is a powerful laundry detergent designed to tackle tough stains effectively.', 30, '2023-06-26 07:41:41', '2023-08-31 03:37:03', 25, '2012-05-12', '2016-05-12', 'Laundry Detergents', 'uploads/5cf094d6fa0314d02eed469ad16f123d8005fe2c-topblue.png'),
(7, 'Top Liquid Detergent Brilliant Clean', 'It is a high-performance laundry detergent designed to give your clothes a remarkable level of cleanliness.', 30, '2023-06-26 07:41:53', '2023-08-31 03:36:55', 25, '2012-06-12', '2016-06-12', 'Laundry Detergents', 'uploads/5dea43dbd6cfe8ee4cb297812aae0652b3f92e50-topred.png'),
(8, 'Mister Potato Snack (Original)', 'It is a delicious and popular snack option loved for its classic taste.', 4, '2023-06-26 07:56:31', '2023-08-31 03:34:53', 0, '2012-07-12', '2014-07-12', 'Snacks', 'uploads/5292b5be915e0ace9dc91a6e61098f870d908a91-potatoori.png'),
(9, 'Mister Potato Snack (BBQ)', 'It is a delightful and popular snack choice known for its savory and smoky taste.', 4, '2023-06-26 08:08:59', '2023-08-31 03:35:02', 0, '2012-08-12', '2014-08-12', 'Snacks', 'uploads/10787f395f4c08822e539f9c1f9ae4e4d4186d0c-potatobbq.png'),
(10, 'Dettol Shower Gel Body Wash(Orignal)', 'It is a cleansing and refreshing product designed to promote personal hygiene during showers.', 25, '2023-07-01 15:52:50', '2023-08-31 03:34:40', 22, '2012-09-12', '2014-09-12', 'Laundry Detergents', 'uploads/5c4d6ba769509e29b54085ebff862cca237dc56d-detolori.png'),
(11, 'Dettol Shower Gel Body Wash(Cool)', 'This exceptional formula offers a revitalizing cleanse with a cool and invigorating twist.', 25, '2023-07-01 15:52:50', '2023-08-31 03:34:29', 22, '2012-09-12', '2014-09-12', 'Laundry Detergents', 'uploads/0ac7214b39820cabf3ac295125738d3abcf25327-detolcool.png'),
(12, 'Dettol Shower Gel Body Wash(Fresh)', 'This invigorating formula is designed to cleanse and refresh, promoting a heightened sense of hygiene.', 25, '2023-07-01 15:52:50', '2023-08-31 03:35:37', 22, '2012-09-12', '2014-09-12', 'Laundry Detergents', 'uploads/2a66123df667fef34ed308042a9669ac254fc98c-detolfresh.png');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
