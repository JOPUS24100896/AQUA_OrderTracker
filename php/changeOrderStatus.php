<?php
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");

    $id = (int) $_POST["OrderID"];
    $status = $_POST["Status"];
   /**  echo json_encode ([
            "Error" => false,
            "Message" => "orderid: ". $id
        ]);
    exit();*/
    $query = "CALL update_order_status(?,?);";
    $query_prepare = $conn->prepare($query);
    $query_prepare->bind_param("si", $status, $id);
    if($query_prepare->execute()){
        echo json_encode ([
            "Error" => false,
            "Message" => "Good Execution"
        ]);
    }else {
        echo json_encode ([
            "Error" => true,
            "Message" => "Bad Execute"
        ]);
    }
?>