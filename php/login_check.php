<?php
//CHECK IF ALREADY LOGGED IN
session_start();
if(isset($_SESSION["user_id"])){
    switch($_SESSION["user_type"]){
        case "CUST":
            echo json_encode([
                "Error" => true,
                "Error_Number" => "Login",
                "Error_Location" => "CUST"
            ]);
        break;
        case "ADMIN":
            echo json_encode([
                "Error" => true,
                "Error_Number" => "Login",
                "Error_Location" => "ADMIN"
            ]);
        break;
        case "STAFF":
            echo json_encode([
                "Error" => true,
                "Error_Number" => "Login",
                "Error_Location" => "STAFF"
            ]);
        break;
    }
    exit();
}
?>