<?php
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $id = (int) $_POST["OrderID"];
    $status = $_POST["Status"];

    $queryCheck = "SELECT 1 FROM orders WHERE OrderID = ? AND `Status` = 'Cancelled' LIMIT 1";
    $queryCheck_prepare = $conn->prepare($queryCheck);
    $queryCheck_prepare->bind_param("i", $id);
    if($queryCheck_prepare->execute()){

        $queryCheck_prepare->store_result();
        if($queryCheck_prepare->num_rows >= 1){
            echo json_encode ([
                "Error" => true,
                "Message" => "Order status is cancelled"
            ]);
            exit();
        }
        
    }else {
        echo json_encode ([
            "Error" => true,
            "Message" => "Bad Execute"
        ]);
    }

    
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