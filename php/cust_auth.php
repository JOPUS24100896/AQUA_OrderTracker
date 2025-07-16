<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(isset($_SESSION["user_id"])){
    switch($_SESSION["user_type"]){
        case "CUST"://Do nothing
        break;
        case "ADMIN":
            header("Location:../admin UI/InventoryUI.php");
        exit();
        case "STAFF":
            header("Location:../staff UI/ManageOrders.php");
        exit();
    }
    
} else{
    header("../index.php");
    exit();
}

?>
