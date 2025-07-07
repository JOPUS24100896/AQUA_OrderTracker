<?php
session_start();
$error_stack = [];
$conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
if($conn->connect_errno){
    array_push($error_stack, "There was a problem reaching the database. Error " . $conn->connect_errno);
    exit();
}

$prod_maxNum = 0;

$max_items_query = "SELECT return_total_items() AS Max_Items";
$max_items_raw = $conn->query($max_items_query);
if($max_items_raw){
    $max_items_result = $max_items_raw->fetch_assoc();
    $prod_maxNum = $max_items_result["Max_Items"];
}else{
    array_push($error_stack, "There was a problem retrieving from the database. Error"  . $conn->errno);
}


$prod_selected = [];
$prod_values = [];
$delivery = isset($_POST["delivery"]) ? 1:0;
$curr_date = new DateTime();
$retrieve_date = $curr_date->modify("+18 days");
$retrieve_dateFormatted = $retrieve_date->format("Y-m-d H:i:s");


for($prod_iterate = 1; $prod_iterate <= $prod_maxNum; $prod_iterate++){
    $temp = (string)$prod_iterate;
    if(isset($_POST[$temp])){
        $prod_selected[] = $prod_iterate;
        $prod_values[] = $_POST[$temp];
    }
}
$item_ids = implode(',', $prod_selected);
$item_values = implode(',', $prod_values);

function returnTotalPrice($conn, $item_ids, $item_values){
    //global $conn;
    //global $item_ids;
    $query = "CALL return_total_price('$item_ids', '$item_values', @total_Price); SELECT @total_Price AS total_Price;";
    if($conn->multi_query($query)){
        $conn->next_result();
        $result = $conn->store_result();
        $raw = $result->fetch_assoc();
        $total_Price = $raw["total_Price"];
        $result->free();
        return $total_Price;
    }else array_push($error_stack, "Failure to retrieve total price. Error " . $conn->errno);
}

function insertReturnDeadline($conn, $retrieve_dateFormatted){
    //global $conn;
    //global $retrieve_dateFormatted;
    $insertquery = "INSERT INTO return_deadlines VALUES (default, '$retrieve_dateFormatted', default)";
    $check_insert = $conn->query($insertquery);
    if(!$check_insert) array_push($error_stack, "Error inserting Return Deadlines. Error " . $conn->errno); 
    else return $conn->insert_id;
}

function insertOrders($conn, $delivery, $prod_selected, $item_ids, $item_values){
    //global $delivery;
    //global $conn;
    $curr_date = new DateTime();
    $curr_date_formatted = $curr_date->format("Y-m-s H:i:s");
    $retrieve_date = $curr_date->modify("+18 days");
    $retrieve_dateFormatted = $retrieve_date->format("Y-m-d H:i:s");
    $returnDate_Id = insertReturnDeadline($conn, $retrieve_dateFormatted);
    $totalPrice_result = returnTotalPrice($conn, $item_ids, $item_values);
    if($returnDate_Id != null && $totalPrice_result != null) {
        $order_query = "INSERT INTO orders VALUES (DEFAULT, ". $_SESSION['user_id'] . ", $returnDate_Id, $delivery, $totalPrice_result, DEFAULT)";
        $order_check = $conn->query($order_query);
        if(!$order_check) 
            array_push($error_stack, "There was a problem receiving order Error " . $conn->errno);
        else 
            return $conn->insert_id;
    }
    
    
}

function insertOrderDetails($conn, $delivery, $prod_selected, $item_ids, $item_values){
    //global $conn;
    //global $prod_selected;
    $order_id = insertOrders($conn, $delivery, $prod_selected, $item_ids, $item_values);
    $index = 0;
    $explode_item_values = explode(",", $item_values);
    if($order_id != null){
        foreach($prod_selected as $id){
            $item_amount = $explode_item_values[$index];
            $orderDetail_query = "INSERT INTO order_details VALUES (default, ?, ?, ?)";
            $prepare_orderDetail = $conn->prepare($orderDetail_query);
            $prepare_orderDetail->bind_param("iii", $id, $order_id, $item_amount);
            if(!$prepare_orderDetail->execute()){
                array_push($error_stack, "There was an error in receiving order details. Error " . $conn->errno);
            }
            $index++;
        }
        $prepare_orderDetail->close();
    }
}

insertOrderDetails($conn, $delivery, $prod_selected, $item_ids, $item_values);

header("Content-Type: application/json");
if(count($error_stack) > 0){
    echo json_encode([
        "Error" => true,
        "Error_Stack" => $error_stack
    ]);
}else{
    echo json_encode(["Error" => false]);
}


$conn->close();
?>