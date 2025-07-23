<?php
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $id = (int) $_POST["DeliveryID"];

    $queryCheck = "SELECT 1 FROM deliveries WHERE DeliveryID = ? AND `DeliveryStatus` = 'Cancelled' LIMIT 1";
    $queryCheck_prepare = $conn->prepare($queryCheck);
    $queryCheck_prepare->bind_param("i", $id);
    if($queryCheck_prepare->execute()){

        $queryCheck_prepare->store_result();
        if($queryCheck_prepare->num_rows >= 1){
            echo json_encode ([
                "Error" => false,
                "Message" => "Order was cancelled"
            ]);
            exit();
        }
    }else {
        echo json_encode ([
            "Error" => true,
            "Message" => "Bad Execute"
        ]);
    }

    
    if(isset($_POST["Status"])){
        $status = $_POST["Status"];

        $query = "CALL update_delivery_status(?,?, @message);";
        $query_prepare = $conn->prepare($query);
        $query_prepare->bind_param("si", $status, $id);
        if($query_prepare->execute()){

            $result = $conn->query("SELECT @message AS `Message`");
            $row = $result->fetch_assoc();
            echo json_encode ([
                "Error" => false,
                "Message" => $row["Message"]
            ]);
        }else {
            echo json_encode ([
                "Error" => true,
                "Message" => "Bad Execute"
            ]);
        }
        exit();
    }else if(isset($_POST["PortID"])){

        if(is_numeric($_POST["PortID"])){
            $portid = ( ((int) $_POST["PortID"]) == 0)?NULL:(int) $_POST["PortID"];
            $query = "CALL update_port_status(?,?, @message);";
            $query_prepare = $conn->prepare($query);

            if($query_prepare->execute([$portid, $id])){
                $result = $conn->query("SELECT @message AS `Message`");
                $row = $result->fetch_assoc();
                echo json_encode ([
                    "Error" => false,
                    "Message" => $row["Message"]
                ]);
            }else {
                echo json_encode ([
                    "Error" => true,
                    "Message" => "There was a problem with updating the databse: $conn->connect_errno"
                    ]);
            }
        }else{
            echo json_encode ([
                    "Error" => false,
                    "Message" => "Please Pick an option"
                ]);
        }

        
        exit();
    }
    
?>