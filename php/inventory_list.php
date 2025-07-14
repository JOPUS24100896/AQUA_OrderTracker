<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $data_array = [];
    $query = "SELECT * FROM items";
    if($data = $conn->query($query)){
        while($data_row = $data->fetch_assoc())
            array_push($data_array, $data_row);
        echo json_encode($data_array);
    }
?>