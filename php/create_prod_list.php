<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $json_placeholder = [];
    $query = "CALL return_all_items()";
    $query = $conn->query($query);
    while($query_raw_row = $query->fetch_assoc()){
        $json_placeholder[] = $query_raw_row;
    }
    $json_echo = json_encode($json_placeholder);
    echo $json_echo;
?>