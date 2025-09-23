 <?php
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");

    $id = (int) $_POST["order_id"];
    $cancel = "Cancelled";
    $query = "CALL cancel_order(?,?)";
    $query_prepare = $conn->prepare($query);
    $query_prepare->bind_param("is", $id, $cancel);
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