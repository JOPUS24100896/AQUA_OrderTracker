 <?php
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");

    $id = (int) $_POST["order_id"];
    $cancel = "Cancelled";
    $query = "UPDATE orders SET `Status` = ? WHERE OrderID = ?";
    $query_prepare = $conn->prepare($query);
    $query_prepare->bind_param("si", $cancel, $id);
    if($query_prepare->execute() && $query_prepare->affected_rows > 0){
        echo json_encode ([
            "Error" => false,
            "Message" => "Good Execute"
        ]);
    }else {
        echo json_encode ([
            "Error" => true,
            "Message" => "Bad Execute"
        ]);
    }
   
    
    
?>