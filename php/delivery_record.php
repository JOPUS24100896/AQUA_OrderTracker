<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
    session_start();
    /**Update orders set Status = "Ready" where OrderID IN (12,14,2,3,4,23,24,26,4,13,18,19,21) */
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $result_array = [];
    $query = "SELECT * FROM orders 
    INNER JOIN deliveries ON orders.DeliveryID = deliveries.DeliveryID
    INNER JOIN users ON users.UserID = orders.UserID 
    LEFT JOIN delivery_port ON deliveries.PortID = delivery_port.PortID 
    WHERE orders.Status = 'Ready' AND (deliveries.DeliveryStatus = 'Pending' 
    OR deliveries.DeliveryStatus = 'Delivered')
    ORDER BY orders.OrderID 
    ";
    header("Content-Type: application/json");
    if($data = $conn->query($query)){
        while($dataRow = $data->fetch_assoc()){
            array_push($result_array, $dataRow);
        }
        echo json_encode($result_array);
    }else{
        echoError(true, $conn->errno, "Bad query");
    }

    function echoError($errbool, $errno, $errloc){
        echo json_encode([
            "Error" => $errbool,
            "Error_Number" => $errno,
            "Error_Location" => $errloc
        ]);
    }
?>