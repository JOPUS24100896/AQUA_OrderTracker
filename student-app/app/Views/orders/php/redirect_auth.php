<?php
session_start();

if(isset($_SESSION["user_id"])){
    switch($_SESSION["user_type"]){
        case "CUST":
            header("Location:../customer UI/CreateOrder.php");
        break;
        case "ADMIN":
            header("Location:../admin UI/InventoryUI.php");
        break;
        case "STAFF":
            header("Location:orders/staff/manageOrders");
        break;
    }
    exit();
}

?>