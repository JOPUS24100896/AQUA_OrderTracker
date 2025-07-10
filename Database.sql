-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 04:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_Order` (IN `user_id` INT, IN `delivery` BOOLEAN, IN `item_id_list` VARCHAR(255), IN `item_val_list` VARCHAR(255))   BEGIN
    declare deadline_bool boolean;
    declare delivery_status boolean;
    declare return_deadline_id int;
    declare total_price decimal(10,2);
    declare order_id int;
    set return_deadline_id = null;
    SELECT return_deadline_needed(item_id_list) INTO deadline_bool;
    IF deadline_bool = 1 then
        INSERT INTO return_deadlines VALUES (default, DATE_ADD(NOW(), INTERVAL 5 DAY), default);
        SELECT LAST_INSERT_ID() INTO return_deadline_id;
    END IF;
    IF delivery = 0 then
        set delivery_status = null;
    ELSE 
        set delivery_status = delivery;
    END IF;
    CALL return_total_price(item_id_list, item_val_list, @totalprice);
    SELECT @totalprice INTO total_Price;
    INSERT INTO orders VALUES (DEFAULT, user_id , return_deadline_id, delivery, delivery_status, total_Price, DEFAULT);
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
  `Delivery` tinyint(1) DEFAULT 0,
  `DeliveryStatus` tinyint(1) DEFAULT NULL,
  `TotalPrice` decimal(10,2) DEFAULT NULL,
  `OrderDate` datetime NOT NULL DEFAULT current_timestamp()
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
(2, 'test', 'test', 'test', 'test1', 'test1', 'test', 'CUST');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
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
