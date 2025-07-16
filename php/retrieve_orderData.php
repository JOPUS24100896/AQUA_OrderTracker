<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    session_start();
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $sql2 = "SELECT `order_details`.`OrderID`, `users`.`FullName`, `order_details`.`ItemID`, `items`.`ItemName`, `order_details`.`ItemQuantity`, `orders`.`OrderDate`, `items`.`Price`, `orders`.`TotalPrice`
            FROM `order_details`
            INNER JOIN `items`
            ON `order_details`.`ItemID` = `items`.`ItemID`
            INNER JOIN `orders`
            ON `orders`.`OrderID` = `order_details`.`OrderID`
            INNER JOIN `users`
            ON `orders`.`UserID` = `users`.`UserID`
            ORDER By `order_details`.`OrderID` DESC, `order_details`.`ItemID`;";
    $raw_Order_Data = $conn->query($sql2);
    $json_placeholder = [];
    while($query_raw_row = $raw_Order_Data->fetch_assoc()){
        $json_placeholder[] = $query_raw_row;
    }
    echo json_encode($json_placeholder);
?>