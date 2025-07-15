<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
    session_start();
    
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $result_array = [];
    $query = "SELECT * FROM orders INNER JOIN order_details ON orders.OrderID = order_details.OrderID 
    INNER JOIN itemnoimages ON itemnoimages.ItemID = order_details.ItemID ORDER BY orders.OrderID";
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