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
$address = isset($_POST["address"]) ? $_POST["address"] : null;

//INPUT CHECKS-----------------
if(!(is_array($user_chosen_products) && is_array($user_chosen_amount)))
    echo_error(true, "Invalid input", "Product keys or amount is not an array");

if($user_chosen_products == null || $user_chosen_amount == null)
    echo_error(true, "Invalid input", "Missing product keys or amount");

if(count($user_chosen_products) != count($user_chosen_amount))
    echo_error(true, "Invalid input", "Product keys and amount mismatch");

if($delivery != 1 && $delivery != 0)
    echo_error(true, "Invalid input", "Delivery name tampered");

    // uncomment for delivery_address input check
// if($address == null && $delivery == 1)
//     echo_error(true, "Invalid input", "Delivery address is Invalid");


//MAIN QUERIES----------------- FOR CUSTOMERS ra
if($_SESSION["user_type"] == "CUST"){
            $query = "CALL verifyOrder(?, @bool);";
            $query_prepare = $conn->prepare($query);

            if($query_prepare->execute([$user_id])){
                $result = $conn->query("SELECT @bool AS `Check`");
                $row = $result->fetch_assoc();
                $check = (int) $row["Check"];
                if(!$check) {
                    echo json_encode ([
                        "Error" => true,
                        "Error_Location" => "You can only make one (1) order, please cancel your current order if you want to make a new order"
                    ]);
                    exit();
                }
            }else {
                echo json_encode ([
                    "Error" => true,
                    "Error_Number" => $conn->connect_errno,
                    "Error_Location" => "There was a problem verifying your order: $conn->connect_errno"
                    ]);
                exit();
            }

            // check delivery address != null           this is straight up uneccessary since the address is required for Sign up
            // if($delivery == 1){ 
            //     $address_query = "SELECT Address FROM users WHERE UserID = ?";
            //     $delivery_address_ = $conn->query($address_query);
            //     $raw_address = $delivery_address_->fetch_assoc();
            //     if( $raw_address["Address"] == null){
            //         // this is to to be used as for "alert" function and to determin what type of user
            //         echo json_encode([
            //             "Error" => true,
            //             "Error_Message" => "Customer",
            //             "Error_Location" => "Please set an address in your profile to avail delivery"
            //         ]);
            //         exit();
            //     }
            // }

        }





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