-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2025 at 01:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
DROP DATABASE aquadelsol_ordertracker;
CREATE DATABASE IF NOT EXISTS aquadelsol_ordertracker;
USE aquadelsol_ordertracker;
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
    TRUNCATE orders;
    TRUNCATE order_details;
    TRUNCATE return_deadlines;
    SET FOREIGN_KEY_CHECKS = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_Delivery` (OUT `delivery_id` INT)   BEGIN
        set delivery_id = null;
        insert into deliveries values (DEFAULT, DEFAULT, DEFAULT, DEFAULT);
        select LAST_INSERT_ID() into delivery_id;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_Order` (IN `user_id` INT, IN `delivery` BOOLEAN, IN `item_id_list` VARCHAR(255), IN `item_val_list` VARCHAR(255))   BEGIN
    declare deadline_bool boolean;
    declare return_deadline_id int;
    declare total_price decimal(10,2);
    declare order_id int;
    declare delivery_id int;
    set delivery_id = null;
    set return_deadline_id = null;
    SELECT return_deadline_needed(item_id_list) INTO deadline_bool;
    IF deadline_bool = 1 then
        INSERT INTO return_deadlines VALUES (default, DATE_ADD(NOW(), INTERVAL 5 DAY), default);
        SELECT LAST_INSERT_ID() INTO return_deadline_id;
    END IF;
    If delivery = 1 then
        call create_Delivery(@delivery_id);
        select @delivery_id into delivery_id;
    END IF;
    CALL return_total_price(item_id_list, item_val_list, @totalprice);
    SELECT @totalprice INTO total_Price;
    INSERT INTO orders VALUES (DEFAULT, user_id , return_deadline_id, delivery_id, DEFAULT, total_Price, DEFAULT);
    SELECT LAST_INSERT_ID() INTO order_id;
    CALL create_OrderDetail(item_id_list, order_id,item_val_list);
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_OrderDetail` (IN `item_list` VARCHAR(255), IN `order_id` INT, IN `item_amount` VARCHAR(255))   BEGIN 
        declare item_num int;
        declare item_id int;
        declare item_val int;
        declare item_index int;
        set item_num = 1 + LENGTH(item_list) - LENGTH(REPLACE(item_list, ",", ""));
        set item_index = 1;
        while item_index <= item_num DO
            set item_id = CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(item_list, ",", item_index), ",", -1) AS UNSIGNED);
            set item_val = CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(item_amount, ",", item_index), ",", -1) AS UNSIGNED);
            INSERT INTO order_details VALUES (default, item_id, order_id, item_val); 
            set item_index = item_index + 1;
        end while;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `return_all_items` ()   BEGIN
	SELECT ItemName, ItemID FROM items;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `verify_login` (IN `login_key` VARCHAR(50), IN `pass_key` VARCHAR(50))   BEGIN
    select UserID, Type from users where (Username = login_key or Email = login_key) and Password = pass_key;
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `return_deadline_needed` (`item_list` VARCHAR(255)) RETURNS INT(11)  BEGIN
	declare item_id int;
    declare item_returnable int;
	declare digit_count int;
    declare loop_index int;
    set digit_count = 1 + LENGTH(item_list) - LENGTH(REPLACE(item_list, ",", ""));
    set loop_index = 1;
    main_loop: 
    	while loop_index <= digit_count do 
    	set item_id = SUBSTRING_INDEX(SUBSTRING_INDEX(item_list, ",", loop_index), ",", -1);
        set item_id = CAST(item_id as unsigned);
    	select Returnable into item_returnable from items where ItemID = item_id;
        if item_returnable = 1 then
        	return 1;
        end if;
        set loop_index = loop_index + 1;
     end while main_loop;
   	 return 0;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `return_total_items` () RETURNS INT(11) DETERMINISTIC BEGIN
	declare Total_items int;
	select count(distinct ItemID) into Total_items from items;
    return Total_items;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `DeliveryID` int(11) NOT NULL,
  `DeliveryDate` datetime DEFAULT current_timestamp(),
  `DeliveryStatus` enum('Pending','Delivered','Cancelled','Failed') NOT NULL DEFAULT 'Pending',
  `PortID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`DeliveryID`, `DeliveryDate`, `DeliveryStatus`, `PortID`) VALUES
(1, '2025-07-11 00:20:52', 'Pending', NULL),
(2, '2025-07-14 01:18:14', 'Pending', NULL),
(3, '2025-07-14 14:16:11', 'Pending', NULL),
(4, '2025-07-14 14:26:10', 'Pending', NULL),
(5, '2025-07-14 14:27:17', 'Pending', NULL),
(6, '2025-07-14 14:32:59', 'Pending', NULL),
(7, '2025-07-14 17:22:14', 'Pending', NULL),
(8, '2025-07-14 17:24:28', 'Pending', NULL),
(9, '2025-07-14 17:24:38', 'Pending', NULL),
(10, '2025-07-14 17:24:44', 'Pending', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_port`
--

CREATE TABLE `delivery_port` (
  `PortID` int(11) NOT NULL,
  `PortNumber` varchar(5) DEFAULT NULL,
  `PortStatus` enum('Ready','Transit','Maintenance','Closed') NOT NULL DEFAULT 'Maintenance'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_port`
--

INSERT INTO `delivery_port` (`PortID`, `PortNumber`, `PortStatus`) VALUES
(1, 'DEL01', 'Ready'),
(2, 'DEL02', 'Ready'),
(3, 'DEL03', 'Ready'),
(4, 'DEL04', 'Ready');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ItemID` int(11) NOT NULL,
  `StockQuantity` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `Description` varchar(50) DEFAULT 'Description not set',
  `ItemName` varchar(50) DEFAULT 'Unnamed',
  `Returnable` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `StockQuantity`, `Price`, `Description`, `ItemName`, `Returnable`) VALUES
(1, 50, 25.00, 'Description not set', 'Product 1', 1),
(2, 50, 50.00, 'Description not set', 'Product 2', 0),
(3, 50, 20.00, 'Description not set', 'Product 3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ReturnDeadlineID` int(11) DEFAULT NULL,
  `DeliveryID` int(11) DEFAULT NULL,
  `Status` enum('Pending','Ready','Cancelled','Complete') NOT NULL DEFAULT 'Pending',
  `TotalPrice` decimal(10,2) DEFAULT NULL,
  `OrderDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `ReturnDeadlineID`, `DeliveryID`, `Status`, `TotalPrice`, `OrderDate`) VALUES
(1, 1, 1, 1, 'Complete', 75.00, '2025-07-11 00:20:52'),
(2, 1, 2, NULL, 'Pending', 95.00, '2025-07-11 00:33:27'),
(3, 1, NULL, NULL, 'Pending', 70.00, '2025-07-11 00:33:55'),
(4, 1, 3, NULL, 'Pending', 400.00, '2025-07-12 18:21:29'),
(5, 1, 4, 2, 'Pending', 520.00, '2025-07-14 01:18:14'),
(6, 1, 5, 3, 'Pending', 95.00, '2025-07-14 14:16:11'),
(7, 1, 6, 4, 'Pending', 95.00, '2025-07-14 14:26:10'),
(8, 1, 7, 5, 'Pending', 95.00, '2025-07-14 14:27:17'),
(9, 4, 8, 6, 'Pending', 275.00, '2025-07-14 14:32:59'),
(10, 4, 10, 8, 'Pending', 95.00, '2025-07-14 17:24:28'),
(11, 4, 11, 9, 'Pending', 95.00, '2025-07-14 17:24:38'),
(12, 4, 12, 10, 'Pending', 95.00, '2025-07-14 17:24:44'),
(13, 4, 13, NULL, 'Pending', 95.00, '2025-07-14 17:24:50');

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

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`OrderDetailID`, `ItemID`, `OrderID`, `ItemQuantity`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 1, 2, 1),
(4, 2, 2, 1),
(5, 3, 2, 1),
(6, 2, 3, 1),
(7, 3, 3, 1),
(8, 1, 4, 10),
(9, 2, 4, 3),
(10, 1, 5, 4),
(11, 2, 5, 6),
(12, 3, 5, 6),
(13, 1, 6, 1),
(14, 2, 6, 1),
(15, 3, 6, 1),
(16, 1, 7, 1),
(17, 2, 7, 1),
(18, 3, 7, 1),
(19, 1, 8, 1),
(20, 2, 8, 1),
(21, 3, 8, 1),
(22, 1, 9, 3),
(23, 2, 9, 4),
(24, 1, 10, 1),
(25, 2, 10, 1),
(26, 3, 10, 1),
(27, 1, 11, 1),
(28, 2, 11, 1),
(29, 3, 11, 1),
(30, 1, 12, 1),
(31, 2, 12, 1),
(32, 3, 12, 1),
(33, 1, 13, 1),
(34, 2, 13, 1),
(35, 3, 13, 1);

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
-- Dumping data for table `return_deadlines`
--

INSERT INTO `return_deadlines` (`ReturnDeadlineID`, `ReturnDateTime`, `ReturnStatus`) VALUES
(1, '2025-07-16 00:20:52', 0),
(2, '2025-07-16 00:33:27', 0),
(3, '2025-07-17 18:21:29', 0),
(4, '2025-07-19 01:18:14', 0),
(5, '2025-07-19 14:16:11', 0),
(6, '2025-07-19 14:26:10', 0),
(7, '2025-07-19 14:27:17', 0),
(8, '2025-07-19 14:32:59', 0),
(9, '2025-07-19 17:22:14', 0),
(10, '2025-07-19 17:24:28', 0),
(11, '2025-07-19 17:24:38', 0),
(12, '2025-07-19 17:24:44', 0),
(13, '2025-07-19 17:24:50', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FullName` varchar(50) DEFAULT NULL,
  `Address` varchar(50) DEFAULT NULL,
  `Contact` varchar(50) DEFAULT NULL,
  `Username` varchar(50) NOT NULL DEFAULT 'Unset',
  `Email` varchar(50) NOT NULL DEFAULT 'Unset',
  `Password` varchar(50) NOT NULL DEFAULT 'Unset',
  `Type` varchar(5) NOT NULL DEFAULT 'CUST'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FullName`, `Address`, `Contact`, `Username`, `Email`, `Password`, `Type`) VALUES
(1, 'test', 'test', 'test', 'test', 'test', 'test', 'CUST'),
(2, 'test', 'test', 'test', 'test1', 'test1', 'test', 'CUST'),
(4, 'John', 'cebu', '14543616', 'Test2', 'example@email.com', 'qwerty', 'CUST');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`DeliveryID`),
  ADD KEY `deliveries_FK` (`PortID`);

--
-- Indexes for table `delivery_port`
--
ALTER TABLE `delivery_port`
  ADD PRIMARY KEY (`PortID`),
  ADD UNIQUE KEY `PortNumber` (`PortNumber`);

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
  ADD KEY `orders_fkCust` (`UserID`),
  ADD KEY `orders_fkRet` (`ReturnDeadlineID`),
  ADD KEY `orders_deliveryFK` (`DeliveryID`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Username_2` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `DeliveryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `delivery_port`
--
ALTER TABLE `delivery_port`
  MODIFY `PortID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `return_deadlines`
--
ALTER TABLE `return_deadlines`
  MODIFY `ReturnDeadlineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_FK` FOREIGN KEY (`PortID`) REFERENCES `delivery_port` (`PortID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_deliveryFK` FOREIGN KEY (`DeliveryID`) REFERENCES `deliveries` (`DeliveryID`),
  ADD CONSTRAINT `orders_fkCust` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
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
