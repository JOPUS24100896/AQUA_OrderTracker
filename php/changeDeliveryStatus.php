<?php
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");

    $id = (int) $_POST["DeliveryID"];
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
                    "Error" => true,
                    "Message" => "Please Pick an option"
                ]);
        }

        
        exit();
    }
    
?>