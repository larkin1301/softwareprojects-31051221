-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.18-MariaDB-log - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6468
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table movies.admin_users
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `surname` varchar(50) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_admin` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table movies.admin_users: ~2 rows (approximately)
INSERT INTO `admin_users` (`id`, `name`, `surname`, `username`, `email`, `password`, `created_at`, `is_admin`) VALUES
	(1, 'admin', 'admin', 'admin', 'admin@admin.com', '$2y$10$BNBF5OK7S5UFO5ljzSUo2uoMl3uUZzSfdlU98UmQnc9Qgie8JSVDe', '2022-06-26 11:34:47', 1),
	(2, 'admin_user', 'admin_user', 'admin_user', 'admin_user@admin.com', '$2y$10$BNBF5OK7S5UFO5ljzSUo2uoMl3uUZzSfdlU98UmQnc9Qgie8JSVDe', '2022-06-26 11:34:47', 0);

-- Dumping structure for table movies.movies
CREATE TABLE IF NOT EXISTS `movies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL DEFAULT '0',
  `short_desc` varchar(50) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Dumping data for table movies.movies: ~10 rows (approximately)
INSERT INTO `movies` (`id`, `title`, `short_desc`, `status`) VALUES
	(1, 'Matrix', 'Lorem ipsum dolor', 1),
	(2, 'Matrix 2', 'Lorem ipsum dolor', 1),
	(3, 'GOAL', 'Lorem ipsum dolor', 1),
	(4, 'GOAL 2', 'Lorem ipsum dolor', 1),
	(5, 'The turnament', 'Lorem ipsum dolor', 0),
	(6, 'Legally Blonde', 'Lorem ipsum dolor', 0),
	(7, 'Legally Blonde 2', 'Lorem ipsum dolor', 0),
	(8, 'Never back down', 'Lorem ipsum dolor', 0),
	(9, 'Never back down 2', 'Lorem ipsum dolor', 0),
	(14, 'Top Gun Maveric', 'lorem ipsum dolor sit amet', 0);

-- Dumping structure for table movies.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL DEFAULT '0',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `total_price` float(6,2) NOT NULL DEFAULT 0.00,
  `order_status` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Dumping data for table movies.orders: ~2 rows (approximately)
INSERT INTO `orders` (`id`, `user_id`, `first_name`, `last_name`, `total_price`, `order_status`, `created_at`, `updated_at`) VALUES
	(6, 'Other', 'Abel', 'Tranch', 149.99, 'confirmed', '2022-06-25 20:19:48', '2022-06-25 20:19:48'),
	(7, 'Spank', 'Double', 'Trouble', 149.99, 'confirmed', '2022-06-25 20:19:48', '2022-06-25 20:19:48'),
	(8, 'Drug', 'Test', 'User', 149.99, 'confirmed', '2022-06-25 20:19:48', '2022-06-25 20:19:48');

-- Dumping structure for table movies.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `product_price` float(6,2) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `total_price` double(6,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table movies.order_details: ~3 rows (approximately)
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `product_name`, `product_price`, `qty`, `total_price`) VALUES
	(6, 6, 4, 'Unlimited devices', 149.99, 1, 149.99),
	(7, 7, 4, 'Unlimited devices', 149.99, 1, 149.99),
	(8, 8, 4, 'Unlimited devices', 149.99, 1, 149.99);

-- Dumping structure for table movies.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) DEFAULT NULL,
  `product_slug` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `full_description` text DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `is_featured` tinyint(1) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table movies.products: ~4 rows (approximately)
INSERT INTO `products` (`id`, `product_name`, `product_slug`, `short_description`, `full_description`, `price`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'One device', 'orange-tshirt', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 9.50, 0, 1, '2021-02-11 22:03:50', '2021-02-11 22:03:53'),
	(2, 'Three devices', 'maroon-tshirt', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 25.99, 0, 1, '2021-02-11 22:03:21', '2021-02-11 22:03:24'),
	(3, 'Ten devices', 'blue-tshirt', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 50.99, 0, 1, '2021-02-11 22:02:50', '2021-02-11 22:02:53'),
	(4, 'Unlimited devices', 'black-tshirt', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.\r\n\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.\r\n\r\nLorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis omnis suscipit esse ipsam officia. Quis sint nihil magnam explicabo veniam hic. Vitae nam iusto reiciendis ratione sed suscipit, aspernatur repudiandae.', 149.99, 0, 1, '2021-02-11 22:02:17', '2021-02-11 22:02:21');

-- Dumping structure for table movies.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `surname` varchar(50) NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table movies.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `surname`, `username`, `password`, `created_at`) VALUES
	(1, 'Test', 'User', 'test', '$2y$10$BNBF5OK7S5UFO5ljzSUo2uoMl3uUZzSfdlU98UmQnc9Qgie8JSVDe', '2022-06-25 12:11:50');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
