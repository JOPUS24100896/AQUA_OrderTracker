<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $result_array = [];
    $user_id = (int) $_SESSION["user_id"];
    $query = "SELECT * FROM orders WHERE Status = 'Pending' AND user_id = $user_id"
    if($data = $conn->query($query)){
        while($dataRow = $data->fetch_assoc()){
            array_push($result_array, $dataRow);
        }
        echo json_encode($result_array);
    }else{
        echo echoError(true, $conn->errno, "Bad query");
    }
?>