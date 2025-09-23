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
function isReturnable(){
    global $conn;
    global $item_ids;
    $prep = $conn->prepare("SELECT return_deadline_needed(?) AS deadline_bool;");
    $prep->bind_param("s", $item_ids);
    $prep->execute();

    $result = $prep->get_result();
    $row = $result->fetch_assoc();
    return $row["deadline_bool"];
}

function prepOrder(){
    global $conn;
    global $user_chosen_products;
    global $user_chosen_amount;
    global $delivery;
    global $user_id;
    global $item_ids;
    global $item_values;
    $last_return_id = NULL;
    $last_del_id = NULL;
    if(isReturnable() == 1){
        $conn->query("INSERT INTO return_deadlines VALUES (default, DATE_ADD(NOW(), INTERVAL 5 DAY), default);");
        $last_return_id = $conn->insert_id;
    }
    if($delivery === 1){
        $conn->query("INSERT INTO deliveries VALUES (DEFAULT, DEFAULT, DEFAULT, DEFAULT);");
        $last_del_id = $conn->insert_id;
    }
    $conn->query("SET @total_price = 0;");
    $stmt = $conn->prepare("CALL return_total_price(? ,? , @total_price)");
    $stmt->bind_param("ss", $item_ids, $item_values);
    $stmt->execute();

    $priceRaw = $conn->query("SELECT @total_price AS total_price");
    $priceRow = $priceRaw->fetch_assoc();
    $price = $priceRow["total_price"];

    $conn->query("INSERT INTO orders 
    (OrderID, UserID, ReturnDeadlineID, DeliveryID, Status, TotalPrice, OrderDate)
    VALUES 
    (DEFAULT, $user_id, "
    . (is_null($last_return_id) ? "NULL" : $last_return_id) . ", "
    . (is_null($last_del_id) ? "NULL" : $last_del_id) . ", "
    . "DEFAULT, $price, DEFAULT)");
    $orderId = $conn->insert_id;
    
    foreach($user_chosen_products as $ndx => $val){
        $conn->query("INSERT INTO order_details VALUES (default, $val, $orderId," . $user_chosen_amount[$ndx] . "); ");
    }
}


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
        }

if($_SESSION["user_type"] == "STAFF" && $delivery == 1){
    echo json_encode (value: [
        "Error" => true,
        "Error_Location" => "Staff cannot create delivery orders"
    ]);
    exit();
}

prepOrder();
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