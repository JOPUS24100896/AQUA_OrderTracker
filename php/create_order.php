<?php
//SETUP----------------
session_start();
if(!isset($_SESSION["user_id"])) echo_error(true, "User not found", "No login credentials found");

$conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
if($conn->connect_errno)
    echo_error(true, $conn->errno, "Bad connection to server");
    

$user_chosen_products = isset($_POST["product"])?$_POST["product"]:null;
$user_chosen_amount = isset($_POST["product_amount"])?$_POST["product_amount"]:null;
$user_id = $_SESSION["user_id"];
$item_ids = implode(',', $user_chosen_products);
$item_values = implode(',', $user_chosen_amount);
$prod_selected = [];
$prod_values = [];
$delivery = (int) $_POST["delivery"];

//INPUT CHECKS-----------------
if(!(is_array($user_chosen_products) && is_array($user_chosen_amount)))
    echo_error(true, "Invalid input", "Product keys or amount is not an array");

if($user_chosen_products == null || $user_chosen_amount == null)
    echo_error(true, "Invalid input", "Missing product keys or amount");

if(count($user_chosen_products) != count($user_chosen_amount))
    echo_error(true, "Invalid input", "Product keys and amount mismatch");

if($delivery != 1 && $delivery != 0)
    echo_error(true, "Invalid input", "Delivery name tampered");


//MAIN QUERY-----------------
$order_query = "CALL create_order(?, ?, ?, ?)";
$order_prepare = $conn->prepare($order_query); 
$order_prepare->bind_param("iiss", $user_id, $delivery, $item_ids, $item_values);
if($order_prepare->execute()){
    echo_error(false, "", "");
}


//ERROR FEEDBACK--------------
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
    exit(1);
}
$conn->close();
?>