<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
$login_key = $_POST["login_key"];
$pass_key = $_POST["password"];

$verify_query = "SELECT verify_login(?, ?) as user_id";
$verify_prep = $conn->prepare($verify_query);
if(!$verify_prep){
    echo json_encode([
        "Error" => true,
        "Error_Number" => $verify_prep->errno,
        "Error_Location" => "Bad prepare"
    ]);
    exit;
}
$verify_prep->bind_param("ss", $login_key, $pass_key);
if($verify_prep->execute()){
    $verify_raw = $verify_prep->get_result();
    $verify_assoc = $verify_raw->fetch_assoc();
    if($verify_assoc["user_id"] == null){
        echo json_encode([
            "Error" => true,
            "Error_Number" => $verify_prep->errno,
            "Error_Location" => "Bad verification, returned null"
        ]);
    }else{
        echo json_encode([
            "Error" => false,
            "ID" => $verify_assoc["user_id"] //Temporary debugging 
        ]);
        $_SESSION["user_id"] = $verify_assoc["user_id"];
    }
}
else echo json_encode([
    "Error" => true,
    "Error_Number" => $verify_prep->errno,
    "Error_Location" => "Bad execution"
]);

?>