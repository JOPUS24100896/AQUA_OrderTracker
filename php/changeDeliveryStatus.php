<?php
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");

    $id = (int) $_POST["DeliveryID"];
    if(isset($_POST["Status"])){
        $status = $_POST["Status"];

        $query = "UPDATE deliveries SET `DeliveryStatus` = ? WHERE `DeliveryID` = ? ";
        $query_prepare = $conn->prepare($query);
        $query_prepare->bind_param("si", $status, $id);
        if($query_prepare->execute()){
            echo json_encode ([
                "Error" => false,
                "Message" => "Execute Complete"
            ]);
        }else {
            echo json_encode ([
                "Error" => true,
                "Message" => "Bad Execute"
            ]);
        }
        exit();
    }else if(isset($_POST["PortID"])){
        $portid = $_POST["PortID"];

        $query = "UPDATE deliveries SET `PortID` = ? WHERE `DeliveryID` = ? ";
        $query_prepare = $conn->prepare($query);
        $query_prepare->bind_param("ii", $portid, $id);
        if($query_prepare->execute()){
            echo json_encode ([
                "Error" => false,
                "Message" => "Execute Complete"
            ]);
        }else {
            echo json_encode ([
                "Error" => true,
                "Message" => "Bad Execute"
            ]);
        }
        exit();
    }
    
?>