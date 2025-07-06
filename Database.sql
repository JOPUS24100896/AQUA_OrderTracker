-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2025 at 05:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aquadelsol_ordertracker`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `clear_not_item` ()   BEGIN
	SET FOREIGN_KEY_CHECKS = 0;
    TRUNCATE customers;
    TRUNCATE orders;
    TRUNCATE order_details;
    TRUNCATE return_deadlines;
    SET FOREIGN_KEY_CHECKS = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `return_total_price` (IN `itemIdList` VARCHAR(255), IN `itemValList` VARCHAR(255), OUT `total_Price` DECIMAL(10,2))   BEGIN
    declare Item_Price decimal(10,2);
    declare loop_int int;
    declare ID_Length int;
    declare ID int;
    declare Val int;
    set total_Price = 0;
    set loop_int = 1;
    set ID_Length = LENGTH(itemIdList) - LENGTH(REPLACE(itemIdList, ',', '')) + 1;
    while loop_int <= ID_Length DO
		set ID = SUBSTRING_INDEX(SUBSTRING_INDEX(itemIdList, ',', loop_int), ',', -1);
        set Val = SUBSTRING_INDEX(SUBSTRING_INDEX(itemValList, ',', loop_int), ',', -1);
        set Val = CAST(Val AS UNSIGNED);
        SELECT Price INTO Item_Price FROM items WHERE ItemID = ID;
        SET total_Price = total_Price + Val * Item_Price;
        set loop_int = loop_int + 1;
	END while;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `return_total_items` () RETURNS INT(11) DETERMINISTIC BEGIN
	declare Total_items int;
	select count(distinct ItemID) into Total_items from items;
    return Total_items;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_Price` (`itemIdList` VARCHAR(255)) RETURNS DECIMAL(10,2) DETERMINISTIC BEGIN
	declare total_Price decimal(10,2);
	select sum(Price) into total_Price from items where FIND_IN_SET(ItemID, itemIdList);
    return total_Price;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(50) DEFAULT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `Contact` varchar(50) DEFAULT NULL,
  `Username` varchar(50) DEFAULT NULL,
  `Password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ItemID` int(11) NOT NULL,
  `StockQuantity` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Description` varchar(50) DEFAULT 'Description not set'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `StockQuantity`, `Price`, `Description`) VALUES
(1, 50, 25.00, 'Description not set'),
(2, 50, 50.00, 'Description not set');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `ReturnDeadlineID` int(11) NOT NULL,
  `Delivery` tinyint(1) DEFAULT 0,
  `TotalPrice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `OrderDetailID` int(11) NOT NULL,
  `ItemID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ItemQuantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_deadlines`
--

CREATE TABLE `return_deadlines` (
  `ReturnDeadlineID` int(11) NOT NULL,
  `ReturnDateTime` datetime DEFAULT NULL,
  `ReturnStatus` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ItemID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `orders_fkCust` (`CustomerID`),
  ADD KEY `orders_fkRet` (`ReturnDeadlineID`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`OrderDetailID`),
  ADD KEY `order_details_item` (`ItemID`),
  ADD KEY `order_details_order` (`OrderID`);

--
-- Indexes for table `return_deadlines`
--
ALTER TABLE `return_deadlines`
  ADD PRIMARY KEY (`ReturnDeadlineID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_deadlines`
--
ALTER TABLE `return_deadlines`
  MODIFY `ReturnDeadlineID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_fkCust` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`),
  ADD CONSTRAINT `orders_fkRet` FOREIGN KEY (`ReturnDeadlineID`) REFERENCES `return_deadlines` (`ReturnDeadlineID`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_item` FOREIGN KEY (`ItemID`) REFERENCES `items` (`ItemID`),
  ADD CONSTRAINT `order_details_order` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
