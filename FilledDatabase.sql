-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2025 at 03:48 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

--
-- IMPORTANT: MAKE SURE TO USE items.sql FOR ITEMS TABLES
--

DROP DATABASE IF EXISTS aquadelsol_ordertracker;
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `cancel_order` (IN `order_id` INT, IN `order_status` VARCHAR(10))   BEGIN
	DECLARE deliv_id INT;
	UPDATE orders SET `Status` = order_status WHERE OrderID = order_id;
    SELECT DeliveryID INTO deliv_id FROM orders WHERE OrderID = order_id;
    UPDATE deliveries SET DeliveryStatus = "Cancelled" WHERE DeliveryID = deliv_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clear_all` ()   BEGIN
	SET FOREIGN_KEY_CHECKS = 0;
    UPDATE items SET StockQuantity = 200;
    TRUNCATE users;
    TRUNCATE orders;
    TRUNCATE order_details;
    TRUNCATE return_deadlines;
    TRUNCATE deliveries;
    SET FOREIGN_KEY_CHECKS = 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clear_not_item` ()   BEGIN
	SET FOREIGN_KEY_CHECKS = 0;
    TRUNCATE orders;
    TRUNCATE order_details;
    TRUNCATE return_deadlines;
    TRUNCATE deliveries;
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
            UPDATE items SET StockQuantity = StockQuantity - item_val WHERE ItemID = item_id;
            INSERT INTO order_details VALUES (default, item_id, order_id, item_val); 
            set item_index = item_index + 1;
        end while;
    END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `fill_simulation` ()   BEGIN
	INSERT INTO users (UserID, FullName, Address, Contact, Username, Email, Password, Type) VALUES
(1, 'Ava Dela Cruz', 'Manila', '09171234567', 'ava_dc', 'ava@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(2, 'John Mercado', 'Quezon City', '09181234567', 'johnnyboy', 'john@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(3, 'Mika Soriano', 'Pasig', '09192234567', 'mikas', 'mika@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(4, 'Carlos Reyes', 'Cebu', '09173334567', 'carlosr', 'carlos@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(5, 'Dana Lopez', 'Davao', '09174444567', 'danalo', 'dana@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(6, 'Elijah Tan', 'Bacolod', '09175554567', 'elijaht', 'elijah@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(7, 'Faith Gonzales', 'Taguig', '09176664567', 'faithgo', 'faith@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(8, 'Gabriel Chua', 'Las Piñas', '09177774567', 'gabchua', 'gabriel@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(9, 'Hannah Cruz', 'Marikina', '09178884567', 'hannahc', 'hannah@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(10, 'Ivan Lim', 'Makati', '09179994567', 'ivanlim', 'ivan@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(11, 'Julia Santos', 'Tagaytay', '09271114567', 'julias', 'julia@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(12, 'Ken Navarro', 'Bulacan', '09272224567', 'kennav', 'ken@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(13, 'Lara Manalo', 'Antipolo', '09273334567', 'laram', 'lara@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(14, 'Marco de Leon', 'Rizal', '09274444567', 'marcodl', 'marco@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(15, 'Nina Valdez', 'Cavite', '09275554567', 'ninav', 'nina@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(16, 'Oscar Ramos', 'Batangas', '09276664567', 'oscram', 'oscar@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(17, 'Patricia Uy', 'Zamboanga', '09277774567', 'patuy', 'patricia@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(18, 'Quincy Basilio', 'Ilocos', '09278884567', 'quinbas', 'quincy@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(19, 'Rhea Dizon', 'Cagayan', '09279994567', 'rhead', 'rhea@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(20, 'Samuel Lee', 'Nueva Ecija', '09381114567', 'samlee', 'samuel@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(21, 'Tina Bautista', 'Laguna', '09382224567', 'tinab', 'tina@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'ADMIN'),
(22, 'Ulysses Go', 'Pampanga', '09383334567', 'ulyssg', 'ulysses@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'ADMIN'),
(23, 'Vanessa Jimenez', 'Baguio', '09384444567', 'vanj', 'vanessa@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'ADMIN'),
(24, 'Wilbert Tan', 'Valenzuela', '09385554567', 'wilbertt', 'wilbert@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(25, 'Xena Morales', 'San Juan', '09386664567', 'xenam', 'xena@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(26, 'Yuri Santos', 'Navotas', '09387774567', 'yuris', 'yuri@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'ADMIN'),
(27, 'Zara delos Reyes', 'Malabon', '09388884567', 'zarad', 'zara@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(28, 'Benjie Alano', 'Muntinlupa', '09389994567', 'benjiea', 'benjie@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(29, 'Clarissa Chan', 'Parañaque', '09481114567', 'clarissac', 'clarissa@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(30, 'Daryl Bautista', 'Manila', '09482224567', 'darylb', 'daryl@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF');
CALL create_order(3, 0, '2,3', '6,3');
CALL create_order(6, 1, '1', '9');
CALL create_order(8, 1, '2', '5');
CALL create_order(10, 0, '1,3', '3,8');
CALL create_order(13, 1, '2,3', '3,2');
CALL create_order(16, 0, '2,3', '3,3');
CALL create_order(19, 0, '3', '10');
CALL create_order(27, 1, '1,2', '5,6');
CALL create_order(30, 0, '2,1', '2,9');

-- One call per CUST only
CALL create_order(1, 1, '1,2,3', '3,1,2');
CALL create_order(2, 0, '1,3', '5,5');
CALL create_order(4, 0, '2', '7');
CALL create_order(5, 1, '1,2', '1,5');
CALL create_order(7, 1, '1,3', '2,9');
CALL create_order(9, 0, '2', '8');
CALL create_order(11, 1, '1', '10');
CALL create_order(12, 0, '3,1,2', '1,6,7');
CALL create_order(14, 1, '2', '10');
CALL create_order(15, 0, '3', '6');
CALL create_order(17, 1, '1,2', '6,3');
CALL create_order(18, 1, '1', '4');
CALL create_order(20, 1, '1', '8');
CALL create_order(24, 0, '3', '4');
CALL create_order(25, 1, '1,2,3', '2,4,7');
CALL create_order(28, 0, '3,2', '7,9');
CALL create_order(29, 0, '3,1', '2,7');
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `return_all_items` ()   BEGIN
	SELECT ItemName, ItemID, Price FROM items;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_delivery_status` (IN `stat` VARCHAR(20), IN `delivery_id` INT, OUT `message` VARCHAR(150))   BEGIN
    DECLARE port_Id INT;
    DECLARE orderstat VARCHAR(20);
    DECLARE delivStat VARCHAR(20);


    SELECT PortID, DeliveryStatus INTO port_Id, delivStat 
    FROM deliveries 
    WHERE DeliveryID = delivery_id;
    
	SELECT `Status` INTO orderstat 
    FROM orders 
    WHERE DeliveryID = delivery_id;
    
    IF orderstat != 'Pending' THEN
        IF delivStat != stat THEN
            IF stat = 'Delivered' THEN
                IF port_Id IS NOT NULL AND delivStat = 'Pending' THEN 
                    UPDATE deliveries 
                    SET DeliveryStatus = 'Delivered' 
                    WHERE DeliveryID = delivery_id;
                    UPDATE orders
                    SET `Status` = 'Complete' 
                    WHERE DeliveryID = delivery_id;
                    SET message = 'Order SUCCESSFULLY delivered';
                ELSEIF port_Id IS NOT NULL AND delivStat != 'Pending' THEN
                	SET message = 'The order is NOT yet in TRANSIT';
                ELSE
                    SET message = 'There is NO ASSIGNED vehicle for the selected order';
                END IF;

            ELSEIF stat = 'Pending' THEN
                IF port_Id IS NOT NULL AND delivStat = 'Delivered' THEN
                    UPDATE deliveries 
                    SET DeliveryStatus = 'Failed' 
                    WHERE DeliveryID = delivery_id;
                    UPDATE orders
                    SET `Status` = 'Ready' 
                    WHERE DeliveryID = delivery_id;
                    SET message = 'Status changed to pending, a FAILURE is assumed. REASSIGN the order to pending';
                ELSE
                    UPDATE orders
                    SET `Status` = 'Transit' 
                    WHERE DeliveryID = delivery_id;
                    UPDATE deliveries 
                    SET DeliveryStatus = 'Pending' 
                    WHERE DeliveryID = delivery_id;
                    SET message = 'Delivery is awaiting transit';
                END IF;
            ELSE
                SET message = CONCAT('Invalid status: ', stat);
            END IF;
        ELSE
            SET message = CONCAT('Status is already set to ', stat);
        END IF;
	ELSE
    	SET message = 'Order is not ready';
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_order_status` (IN `stat` VARCHAR(20), IN `order_id` INT)   BEGIN
	declare deliv int;
	UPDATE orders SET `Status` = stat WHERE `OrderID` = order_id;
    IF stat = 'Ready' THEN
    	SELECT DeliveryID into deliv from orders WHERE `OrderID` = order_id;
        IF deliv IS NULL THEN
        	UPDATE orders SET `Status` = 'Complete' WHERE `OrderID` = order_id;
        END IF;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_order_test` (IN `status` VARCHAR(20), IN `statuss` VARCHAR(10), IN `orderid` INT)   BEGIN
	UPDATE testtab SET `test1` = `status` WHERE `primaryCol` = orderid;
    UPDATE testtab SET `test2` = statuss WHERE `primaryCol` = orderid;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_port_status` (IN `port_id_in` INT, IN `delivery_id` INT, OUT `message` VARCHAR(150))   BEGIN
    DECLARE port_id INT;
    DECLARE orderstat VARCHAR(20);
    DECLARE delivStat VARCHAR(20);


    SELECT PortID, DeliveryStatus INTO port_id, delivStat 
    FROM deliveries 
    WHERE DeliveryID = delivery_id;
    
	SELECT `Status` INTO orderstat 
    FROM orders 
    WHERE DeliveryID = delivery_id;
    IF NOT (port_id <=> port_id_in) THEN
        IF orderstat NOT IN ('Pending', 'Complete') THEN
            IF port_id_in IS NULL THEN
                UPDATE deliveries SET DeliveryStatus = 'Pending', PortID = port_id_in WHERE DeliveryID = delivery_id;
                UPDATE orders SET Status = 'Ready' WHERE DeliveryID = delivery_id;
                SET message = 'Order was REASSIGNED with NO vehicle, order status is set back to ready';
            ELSE
                UPDATE deliveries SET DeliveryStatus = 'Pending',  PortID = port_id_in WHERE DeliveryID = delivery_id;
                UPDATE orders SET Status = 'Transit' WHERE DeliveryID = delivery_id;
                SET message = 'Order was REASSIGNED a vehicle, order status is set to transit';
            END IF;
        ELSE
            SET message = 'Cannot reassign vehicle, order is PENDING or already COMPLETE'; 
        END IF;
	ELSE
    	SET message = 'Order is already assigned to the SAME vehicle'; 
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `verifyOrder` (IN `user_id` INT, OUT `check` BOOLEAN)   BEGIN
	DECLARE temp INT;
	SELECT 1 INTO temp FROM orders WHERE UserID = user_id AND Status NOT IN ('Cancelled', 'Complete') LIMIT 1;
    IF temp IS NULL THEN
    	SET `check` = 1;
    ELSE 
    	SET `check` = 0;
    END IF;
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
(1, '2025-09-23 21:48:15', 'Pending', NULL),
(2, '2025-09-23 21:48:15', 'Pending', NULL),
(3, '2025-09-23 21:48:15', 'Pending', NULL),
(4, '2025-09-23 21:48:15', 'Pending', NULL),
(5, '2025-09-23 21:48:15', 'Pending', NULL),
(6, '2025-09-23 21:48:15', 'Pending', NULL),
(7, '2025-09-23 21:48:15', 'Pending', NULL),
(8, '2025-09-23 21:48:15', 'Pending', NULL),
(9, '2025-09-23 21:48:15', 'Pending', NULL),
(10, '2025-09-23 21:48:15', 'Pending', NULL),
(11, '2025-09-23 21:48:15', 'Pending', NULL),
(12, '2025-09-23 21:48:15', 'Pending', NULL),
(13, '2025-09-23 21:48:15', 'Pending', NULL);

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
-- Stand-in structure for view `itemnoimages`
-- (See below for the actual view)
--
CREATE TABLE `itemnoimages` (
`ItemID` int(11)
,`StockQuantity` int(11)
,`Price` decimal(10,2)
,`Description` varchar(50)
,`ItemName` varchar(50)
,`Returnable` tinyint(1)
);

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
  `ImagePath` varchar(255) NOT NULL DEFAULT 'empty_image.jpg',
  `Returnable` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`ItemID`, `StockQuantity`, `Price`, `Description`, `ItemName`, `ImagePath`, `Returnable`) VALUES
(1, 120, 25.00, 'Description not set', 'Bottled Water', 'bottle_water.webp', 0),
(2, 121, 50.00, 'Description not set', 'Water Gallon', 'water_gallon.jpg', 1),
(3, 131, 20.00, 'Description not set', 'Water Gallon With Faucet', 'wat_gall_faucet.png', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `itemwithimages`
-- (See below for the actual view)
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `OrderID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ReturnDeadlineID` int(11) DEFAULT NULL,
  `DeliveryID` int(11) DEFAULT NULL,
  `Status` enum('Pending','Transit','Ready','Cancelled','Complete') NOT NULL DEFAULT 'Pending',
  `TotalPrice` decimal(10,2) DEFAULT NULL,
  `OrderDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`OrderID`, `UserID`, `ReturnDeadlineID`, `DeliveryID`, `Status`, `TotalPrice`, `OrderDate`) VALUES
(1, 3, 1, NULL, 'Pending', 360.00, '2025-09-23 21:48:15'),
(2, 6, NULL, 1, 'Pending', 225.00, '2025-09-23 21:48:15'),
(3, 8, 2, 2, 'Pending', 250.00, '2025-09-23 21:48:15'),
(4, 10, 3, NULL, 'Pending', 235.00, '2025-09-23 21:48:15'),
(5, 13, 4, 3, 'Pending', 190.00, '2025-09-23 21:48:15'),
(6, 16, 5, NULL, 'Pending', 210.00, '2025-09-23 21:48:15'),
(7, 19, 6, NULL, 'Pending', 200.00, '2025-09-23 21:48:15'),
(8, 27, 7, 4, 'Pending', 425.00, '2025-09-23 21:48:15'),
(9, 30, 8, NULL, 'Pending', 325.00, '2025-09-23 21:48:15'),
(10, 1, 9, 5, 'Pending', 165.00, '2025-09-23 21:48:15'),
(11, 2, 10, NULL, 'Pending', 225.00, '2025-09-23 21:48:15'),
(12, 4, 11, NULL, 'Pending', 350.00, '2025-09-23 21:48:15'),
(13, 5, 12, 6, 'Pending', 275.00, '2025-09-23 21:48:15'),
(14, 7, 13, 7, 'Pending', 230.00, '2025-09-23 21:48:15'),
(15, 9, 14, NULL, 'Pending', 400.00, '2025-09-23 21:48:15'),
(16, 11, NULL, 8, 'Pending', 250.00, '2025-09-23 21:48:15'),
(17, 12, 15, NULL, 'Pending', 520.00, '2025-09-23 21:48:15'),
(18, 14, 16, 9, 'Pending', 500.00, '2025-09-23 21:48:15'),
(19, 15, 17, NULL, 'Pending', 120.00, '2025-09-23 21:48:15'),
(20, 17, 18, 10, 'Pending', 300.00, '2025-09-23 21:48:15'),
(21, 18, NULL, 11, 'Pending', 100.00, '2025-09-23 21:48:15'),
(22, 20, NULL, 12, 'Pending', 200.00, '2025-09-23 21:48:15'),
(23, 24, 19, NULL, 'Pending', 80.00, '2025-09-23 21:48:15'),
(24, 25, 20, 13, 'Pending', 390.00, '2025-09-23 21:48:15'),
(25, 28, 21, NULL, 'Pending', 590.00, '2025-09-23 21:48:15'),
(26, 29, 22, NULL, 'Pending', 215.00, '2025-09-23 21:48:15');

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
(1, 2, 1, 6),
(2, 3, 1, 3),
(3, 1, 2, 9),
(4, 2, 3, 5),
(5, 1, 4, 3),
(6, 3, 4, 8),
(7, 2, 5, 3),
(8, 3, 5, 2),
(9, 2, 6, 3),
(10, 3, 6, 3),
(11, 3, 7, 10),
(12, 1, 8, 5),
(13, 2, 8, 6),
(14, 2, 9, 2),
(15, 1, 9, 9),
(16, 1, 10, 3),
(17, 2, 10, 1),
(18, 3, 10, 2),
(19, 1, 11, 5),
(20, 3, 11, 5),
(21, 2, 12, 7),
(22, 1, 13, 1),
(23, 2, 13, 5),
(24, 1, 14, 2),
(25, 3, 14, 9),
(26, 2, 15, 8),
(27, 1, 16, 10),
(28, 3, 17, 1),
(29, 1, 17, 6),
(30, 2, 17, 7),
(31, 2, 18, 10),
(32, 3, 19, 6),
(33, 1, 20, 6),
(34, 2, 20, 3),
(35, 1, 21, 4),
(36, 1, 22, 8),
(37, 3, 23, 4),
(38, 1, 24, 2),
(39, 2, 24, 4),
(40, 3, 24, 7),
(41, 3, 25, 7),
(42, 2, 25, 9),
(43, 3, 26, 2),
(44, 1, 26, 7);

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
(1, '2025-09-28 21:48:15', 0),
(2, '2025-09-28 21:48:15', 0),
(3, '2025-09-28 21:48:15', 0),
(4, '2025-09-28 21:48:15', 0),
(5, '2025-09-28 21:48:15', 0),
(6, '2025-09-28 21:48:15', 0),
(7, '2025-09-28 21:48:15', 0),
(8, '2025-09-28 21:48:15', 0),
(9, '2025-09-28 21:48:15', 0),
(10, '2025-09-28 21:48:15', 0),
(11, '2025-09-28 21:48:15', 0),
(12, '2025-09-28 21:48:15', 0),
(13, '2025-09-28 21:48:15', 0),
(14, '2025-09-28 21:48:15', 0),
(15, '2025-09-28 21:48:15', 0),
(16, '2025-09-28 21:48:15', 0),
(17, '2025-09-28 21:48:15', 0),
(18, '2025-09-28 21:48:15', 0),
(19, '2025-09-28 21:48:15', 0),
(20, '2025-09-28 21:48:15', 0),
(21, '2025-09-28 21:48:15', 0),
(22, '2025-09-28 21:48:15', 0);

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
  `Password` varchar(255) NOT NULL,
  `Type` enum('CUST','ADMIN','STAFF') NOT NULL DEFAULT 'CUST'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FullName`, `Address`, `Contact`, `Username`, `Email`, `Password`, `Type`) VALUES
(1, 'Ava Dela Cruz', 'Manila', '09171234567', 'ava_dc', 'ava@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(2, 'John Mercado', 'Quezon City', '09181234567', 'johnnyboy', 'john@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(3, 'Mika Soriano', 'Pasig', '09192234567', 'mikas', 'mika@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(4, 'Carlos Reyes', 'Cebu', '09173334567', 'carlosr', 'carlos@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(5, 'Dana Lopez', 'Davao', '09174444567', 'danalo', 'dana@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(6, 'Elijah Tan', 'Bacolod', '09175554567', 'elijaht', 'elijah@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(7, 'Faith Gonzales', 'Taguig', '09176664567', 'faithgo', 'faith@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(8, 'Gabriel Chua', 'Las Piñas', '09177774567', 'gabchua', 'gabriel@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(9, 'Hannah Cruz', 'Marikina', '09178884567', 'hannahc', 'hannah@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(10, 'Ivan Lim', 'Makati', '09179994567', 'ivanlim', 'ivan@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(11, 'Julia Santos', 'Tagaytay', '09271114567', 'julias', 'julia@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(12, 'Ken Navarro', 'Bulacan', '09272224567', 'kennav', 'ken@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(13, 'Lara Manalo', 'Antipolo', '09273334567', 'laram', 'lara@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(14, 'Marco de Leon', 'Rizal', '09274444567', 'marcodl', 'marco@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(15, 'Nina Valdez', 'Cavite', '09275554567', 'ninav', 'nina@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(16, 'Oscar Ramos', 'Batangas', '09276664567', 'oscram', 'oscar@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(17, 'Patricia Uy', 'Zamboanga', '09277774567', 'patuy', 'patricia@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(18, 'Quincy Basilio', 'Ilocos', '09278884567', 'quinbas', 'quincy@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(19, 'Rhea Dizon', 'Cagayan', '09279994567', 'rhead', 'rhea@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(20, 'Samuel Lee', 'Nueva Ecija', '09381114567', 'samlee', 'samuel@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(21, 'Tina Bautista', 'Laguna', '09382224567', 'tinab', 'tina@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'ADMIN'),
(22, 'Ulysses Go', 'Pampanga', '09383334567', 'ulyssg', 'ulysses@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'ADMIN'),
(23, 'Vanessa Jimenez', 'Baguio', '09384444567', 'vanj', 'vanessa@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'ADMIN'),
(24, 'Wilbert Tan', 'Valenzuela', '09385554567', 'wilbertt', 'wilbert@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(25, 'Xena Morales', 'San Juan', '09386664567', 'xenam', 'xena@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(26, 'Yuri Santos', 'Navotas', '09387774567', 'yuris', 'yuri@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'ADMIN'),
(27, 'Zara delos Reyes', 'Malabon', '09388884567', 'zarad', 'zara@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF'),
(28, 'Benjie Alano', 'Muntinlupa', '09389994567', 'benjiea', 'benjie@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(29, 'Clarissa Chan', 'Parañaque', '09481114567', 'clarissac', 'clarissa@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'CUST'),
(30, 'Daryl Bautista', 'Manila', '09482224567', 'darylb', 'daryl@gmail.com', '$2a$12$OT9B0HuEkDrao3rCiIlqkOjv/ah7gIrCKe92X5FxwDZAPwOFcUc9u', 'STAFF');

-- --------------------------------------------------------

--
-- Structure for view `itemnoimages`
--
DROP TABLE IF EXISTS `itemnoimages`;

-- --------------------------------------------------------

--
-- Structure for view `itemwithimages`
--
DROP TABLE IF EXISTS `itemwithimages`;

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
  MODIFY `DeliveryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `delivery_port`
--
ALTER TABLE `delivery_port`
  MODIFY `PortID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `OrderDetailID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `return_deadlines`
--
ALTER TABLE `return_deadlines`
  MODIFY `ReturnDeadlineID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
