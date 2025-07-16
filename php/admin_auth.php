<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(isset($_SESSION["user_id"])){
    switch($_SESSION["user_type"]){
        case "CUST":
            header("Location:../customer UI/CreateOrder.php");
        exit();
        case "ADMIN":
        break;
        case "STAFF":
            header("Location:../staff UI/ManageOrders.php");
        exit();
    }
    
} else{
    header("../index.php");
    exit();
}

?>
