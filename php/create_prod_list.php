<?php
    session_start();
    if(!isset($_SESSION["user_id"])) echo_error(true, "User not found", "No login credentials found");
    
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $json_placeholder = [];
    $query = "CALL return_all_items()";
    $query = $conn->query($query);
    while($query_raw_row = $query->fetch_assoc()){
        $json_placeholder[] = $query_raw_row;
    }
    $json_echo = json_encode($json_placeholder);
    echo $json_echo;

    function echo_error($bool, $errno, $errLoc){
    if(!$bool)
        echo json_encode([
            "Error" => $bool    
        ]);
    else
        echo json_encode([
            "Error" => $bool,
            "Error_Number" => $errno,
            "Error_Location" => $errLoc
        ]);
    exit();
}
?>