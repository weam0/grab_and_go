-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 21, 2025 at 03:41 PM
-- Server version: 8.0.30
-- PHP Version: 8.2.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grap_and_go`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `accountId` int NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `accountType` enum('Admin','Customer','Employee') NOT NULL,
  `rewardPoints` int DEFAULT '0',
  `lockerNumber` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`accountId`, `fullName`, `email`, `phoneNumber`, `password`, `accountType`, `rewardPoints`, `lockerNumber`) VALUES
(1, 'admin', 'admin@grabandgo.com', '0510101010', '$2y$10$H3wniKIV6Iu.4HHbZnd3fe.A72xjlxUT3LVPP0OqUwNMgdHSZ41P2', 'Admin', 0, NULL),
(2, 'alanoud', 'alanoud@mailinator.com', '0525145254', '$2y$10$H3wniKIV6Iu.4HHbZnd3fe.A72xjlxUT3LVPP0OqUwNMgdHSZ41P2', 'Admin', 83, '15'),
(3, 'Reem', 'reem@mailinator.com', '0512451474', '$2y$10$H3wniKIV6Iu.4HHbZnd3fe.A72xjlxUT3LVPP0OqUwNMgdHSZ41P2', 'Admin', 96, '313'),
(4, 'shahdd', 'shahd@customer.com', '0512547444', '$2y$10$H3wniKIV6Iu.4HHbZnd3fe.A72xjlxUT3LVPP0OqUwNMgdHSZ41P2', 'Customer', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `cartItemId` int NOT NULL,
  `quantity` int NOT NULL,
  `subtotalPrice` decimal(10,2) NOT NULL,
  `orderId` int NOT NULL,
  `inventoryId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryId` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryId`, `name`, `description`) VALUES
(2, 'Alden Carver', 'Dolorem nobis et do'),
(3, 'Leila James', 'Ullamco facilis ut c'),
(4, 'Rudyard Terrell', 'Quas sint sequi ips'),
(5, 'Jasper Wilson', 'Ea nihil qui dolore'),
(6, 'Donovan Dawson', 'Enim ea error eos du');

-- --------------------------------------------------------

--
-- Table structure for table `complaint`
--

CREATE TABLE `complaint` (
  `complaintId` int NOT NULL,
  `accountId` int NOT NULL,
  `orderId` int DEFAULT NULL,
  `description` text NOT NULL,
  `complaintDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('Pending','Resolved','Dismissed') DEFAULT 'Pending',
  `reply` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `complaint`
--

INSERT INTO `complaint` (`complaintId`, `accountId`, `orderId`, `description`, `complaintDate`, `status`, `reply`) VALUES
(1, 4, 1, 'ثصبصثبصثبث', '2025-03-21 23:53:01', 'Resolved', 'csdcsdc');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `inventoryId` int NOT NULL,
  `productId` int NOT NULL,
  `barcode` varchar(50) NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `weight` decimal(10,2) DEFAULT NULL,
  `expiryDate` date DEFAULT NULL,
  `batchNumber` varchar(50) DEFAULT NULL,
  `lastUpdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `shelfLocation` varchar(255) DEFAULT NULL,
  `imageUrl` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`inventoryId`, `productId`, `barcode`, `quantity`, `price`, `size`, `weight`, `expiryDate`, `batchNumber`, `lastUpdate`, `shelfLocation`, `imageUrl`) VALUES
(1, 2, '2526522', 824, '576.00', 'Consequatur non iste', '16.00', '2023-05-28', '618', '2025-03-18 02:33:35', 'Laudantium dolorem', '/uploads/inventories/ut-labore-autem-ea-e-2025-03-17-67d8b38c96c68.jpg'),
(2, 1, '541515', 619, '953.00', 'Quidem sint cupidita', '57.00', '2024-11-07', '883', '2025-03-18 02:34:30', 'Consequuntur corrupt', '/uploads/inventories/aspernatur-corporis-2025-03-17-67d8b3f25ba5f.jpg'),
(4, 1, '2625', 619, '953.00', 'Quidem sint cupidita', '57.00', '2024-11-07', '883', '2025-03-18 02:34:26', 'Consequuntur corrupt', '/uploads/inventories/aspernatur-corporis-2025-03-17-67d8b3f25ba5f.jpg'),
(5, 3, '5626', 619, '953.00', 'Quidem sint cupidita', '57.00', '2024-11-07', '883', '2025-03-18 02:33:39', 'Consequuntur corrupt', '/uploads/inventories/aspernatur-corporis-2025-03-17-67d8b3f25ba5f.jpg'),
(6, 3, '562652', 619, '953.00', 'Quidem sint cupidita', '57.00', '2024-11-07', '883', '2025-03-18 02:33:39', 'Consequuntur corrupt', '/uploads/inventories/aspernatur-corporis-2025-03-17-67d8b3f25ba5f.jpg'),
(7, 1, '562852', 619, '953.00', 'Quidem sint cupidita', '57.00', '2024-11-07', '883', '2025-03-18 02:34:22', 'Consequuntur corrupt', '/uploads/inventories/aspernatur-corporis-2025-03-17-67d8b3f25ba5f.jpg'),
(8, 2, '5265', 619, '953.00', 'Quidem sint cupidita', '57.00', '2024-11-07', '883', '2025-03-18 02:34:34', 'Consequuntur corrupt', '/uploads/inventories/aspernatur-corporis-2025-03-17-67d8b3f25ba5f.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `locker`
--

CREATE TABLE `locker` (
  `lockerId` int NOT NULL,
  `lockerNumber` varchar(50) NOT NULL,
  `location` varchar(255) NOT NULL,
  `size` enum('Small','Medium','Large') NOT NULL,
  `status` enum('Available','Occupied','Under Maintenance') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locker_reservation`
--

CREATE TABLE `locker_reservation` (
  `reservationId` int NOT NULL,
  `accountId` int NOT NULL,
  `lockerId` int NOT NULL,
  `reservationStart` datetime NOT NULL,
  `reservationEnd` datetime NOT NULL,
  `status` enum('Active','Completed','Cancelled') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `offerId` int NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `discountPercentage` decimal(5,2) NOT NULL,
  `inventoryId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `offer`
--

INSERT INTO `offer` (`offerId`, `startDate`, `endDate`, `discountPercentage`, `inventoryId`) VALUES
(1, '2025-03-18', '2025-03-27', '76.00', 2),
(2, '2025-03-18', '2025-03-17', '73.00', 1),
(3, '2025-03-11', '2025-03-21', '5.00', 8);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int NOT NULL,
  `totalAmount` decimal(10,2) NOT NULL,
  `orderType` enum('Online','In-Store') NOT NULL,
  `usedPoints` int DEFAULT '0',
  `orderDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `orderStatus` enum('Pending','Completed','Cancelled') NOT NULL,
  `accountId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `totalAmount`, `orderType`, `usedPoints`, `orderDate`, `orderStatus`, `accountId`) VALUES
(1, '576.00', 'Online', 0, '2025-02-11 22:05:05', 'Completed', 4),
(2, '576.00', 'Online', 0, '2025-03-21 22:05:32', 'Pending', 4),
(3, '576.00', 'Online', 0, '2025-03-21 22:08:55', 'Pending', 4),
(4, '1529.00', 'Online', 0, '2025-01-08 23:37:49', 'Pending', 4),
(5, '1529.00', 'Online', 0, '2025-03-21 23:38:38', 'Pending', 4),
(6, '2482.00', 'Online', 0, '2025-04-13 12:36:20', 'Completed', 4);

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `orderItemId` int NOT NULL,
  `quantity` int NOT NULL,
  `soldPrice` decimal(10,2) NOT NULL,
  `orderId` int NOT NULL,
  `inventoryId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_item`
--

INSERT INTO `order_item` (`orderItemId`, `quantity`, `soldPrice`, `orderId`, `inventoryId`) VALUES
(1, 1, '576.00', 1, 1),
(2, 1, '576.00', 2, 1),
(3, 1, '576.00', 3, 1),
(4, 1, '576.00', 4, 1),
(5, 1, '953.00', 4, 2),
(6, 1, '576.00', 5, 1),
(7, 1, '953.00', 5, 2),
(8, 2, '953.00', 6, 4),
(9, 1, '576.00', 6, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentId` int NOT NULL,
  `paymentMethod` enum('Credit Card','Cash','Digital Wallet') NOT NULL,
  `cardNumber` varchar(20) DEFAULT NULL,
  `cardExpiryDate` varchar(44) DEFAULT NULL,
  `transactionStatus` enum('Pending','Completed','Failed') NOT NULL,
  `paymentDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `orderId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentId`, `paymentMethod`, `cardNumber`, `cardExpiryDate`, `transactionStatus`, `paymentDate`, `orderId`) VALUES
(1, 'Credit Card', NULL, NULL, 'Completed', '2025-03-21 22:08:55', 3),
(2, 'Credit Card', '3333', '10/30', 'Completed', '2025-03-21 23:38:38', 5),
(3, 'Credit Card', '4444', '09/31', 'Completed', '2025-04-13 12:36:20', 6);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productId` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `imageUrl` varchar(255) DEFAULT NULL,
  `categoryId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productId`, `name`, `description`, `imageUrl`, `categoryId`) VALUES
(1, 'Suki Jones', 'Explicabo Anim est', '/uploads/dummy-slug-2025-03-17-67d8b123a42d9.jpg', 4),
(2, 'Ariel Curry', 'Eius perferendis sit', '/uploads/dummy-slug-2025-03-17-67d8b1f979ef3.jpg', 4),
(3, 'Lucius Estrada', 'Nihil minus sapiente', '/uploads/dummy-slug-2025-03-17-67d8b206b665e.jpg', 6);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `reviewId` int NOT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `reviewDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `accountId` int NOT NULL,
  `inventoryId` int NOT NULL
) ;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`reviewId`, `rating`, `comment`, `reviewDate`, `accountId`, `inventoryId`) VALUES
(1, 1, 'AXAX', '2025-03-22 02:15:16', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `stock_shelf`
--

CREATE TABLE `stock_shelf` (
  `stockShelfId` int NOT NULL,
  `location` varchar(255) NOT NULL,
  `quantity` int NOT NULL,
  `inventoryId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `weam`
--

CREATE TABLE `weam` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accountId`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phoneNumber` (`phoneNumber`);

--
-- Indexes for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`cartItemId`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `inventoryId` (`inventoryId`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `complaint`
--
ALTER TABLE `complaint`
  ADD PRIMARY KEY (`complaintId`),
  ADD KEY `accountId` (`accountId`),
  ADD KEY `orderId` (`orderId`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventoryId`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD KEY `productId` (`productId`);

--
-- Indexes for table `locker`
--
ALTER TABLE `locker`
  ADD PRIMARY KEY (`lockerId`),
  ADD UNIQUE KEY `lockerNumber` (`lockerNumber`);

--
-- Indexes for table `locker_reservation`
--
ALTER TABLE `locker_reservation`
  ADD PRIMARY KEY (`reservationId`),
  ADD KEY `accountId` (`accountId`),
  ADD KEY `lockerId` (`lockerId`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`offerId`),
  ADD KEY `inventoryId` (`inventoryId`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `accountId` (`accountId`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`orderItemId`),
  ADD KEY `orderId` (`orderId`),
  ADD KEY `inventoryId` (`inventoryId`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentId`),
  ADD KEY `orderId` (`orderId`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `categoryId` (`categoryId`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`reviewId`),
  ADD KEY `accountId` (`accountId`),
  ADD KEY `inventoryId` (`inventoryId`);

--
-- Indexes for table `stock_shelf`
--
ALTER TABLE `stock_shelf`
  ADD PRIMARY KEY (`stockShelfId`),
  ADD KEY `inventoryId` (`inventoryId`);

--
-- Indexes for table `weam`
--
ALTER TABLE `weam`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `accountId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `cartItemId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `complaint`
--
ALTER TABLE `complaint`
  MODIFY `complaintId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `inventoryId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `locker`
--
ALTER TABLE `locker`
  MODIFY `lockerId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locker_reservation`
--
ALTER TABLE `locker_reservation`
  MODIFY `reservationId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `offerId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `orderItemId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `reviewId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_shelf`
--
ALTER TABLE `stock_shelf`
  MODIFY `stockShelfId` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_item_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_item_ibfk_2` FOREIGN KEY (`inventoryId`) REFERENCES `inventory` (`inventoryId`) ON DELETE CASCADE;

--
-- Constraints for table `complaint`
--
ALTER TABLE `complaint`
  ADD CONSTRAINT `complaint_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `account` (`accountId`) ON DELETE CASCADE,
  ADD CONSTRAINT `complaint_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`productId`) REFERENCES `product` (`productId`) ON DELETE CASCADE;

--
-- Constraints for table `locker_reservation`
--
ALTER TABLE `locker_reservation`
  ADD CONSTRAINT `locker_reservation_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `account` (`accountId`) ON DELETE CASCADE,
  ADD CONSTRAINT `locker_reservation_ibfk_2` FOREIGN KEY (`lockerId`) REFERENCES `locker` (`lockerId`) ON DELETE CASCADE;

--
-- Constraints for table `offer`
--
ALTER TABLE `offer`
  ADD CONSTRAINT `offer_ibfk_1` FOREIGN KEY (`inventoryId`) REFERENCES `inventory` (`inventoryId`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `account` (`accountId`) ON DELETE CASCADE;

--
-- Constraints for table `order_item`
--
ALTER TABLE `order_item`
  ADD CONSTRAINT `order_item_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_item_ibfk_2` FOREIGN KEY (`inventoryId`) REFERENCES `inventory` (`inventoryId`) ON DELETE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`) ON DELETE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryId`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`accountId`) REFERENCES `account` (`accountId`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`inventoryId`) REFERENCES `inventory` (`inventoryId`) ON DELETE CASCADE;

--
-- Constraints for table `stock_shelf`
--
ALTER TABLE `stock_shelf`
  ADD CONSTRAINT `stock_shelf_ibfk_1` FOREIGN KEY (`inventoryId`) REFERENCES `inventory` (`inventoryId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
