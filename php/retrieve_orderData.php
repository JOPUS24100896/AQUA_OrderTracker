<?php
    session_start();
    
    // class Item {
    //     public $ItemID;
    //     public $ItemName;
    //     public $Unit_price;
    //     // methods
    //     function set_ItemId($Id) {
    //         $this->ItemID = $Id;
    //     }
    //     function set_Unit_price($Price) {
    //         $this->Unit_price = $Price;
    //     }
    // }
    // $Item1 = new Item(); $Item1->set_ItemId(1);
    // $Item2 = new Item(); $Item2->set_ItemId(2);
    // $Item3 = new Item(); $Item3->set_ItemId(3);
    // $UnitPrice_arr = array($Item1, $Item2, $Item3);


    // class OrderDetails {
    //     public $ItemID;
    //     public $Quantity;
    //     public $TotalPrice;

    //     // methods
    //     function set_ItemId($Id) {
    //         $this->ItemID = $Id;
    //     }
    //     function set_Quantity($Qty) {
    //         $this->Quantity = $Qty;
    //     }
    //     function calculate_Price($UnitPrice_arr){
    //         for ($i=0; $i < count($UnitPrice_arr); $i++) { 
    //             if(strcmp($this->ItemID, $UnitPrice_arr[$i]) == 0){
    //                 $this->TotalPrice =  $this->Quantity * $UnitPrice_arr[$i]->Unit_price; 
    //                 //recheck if UnitPrice_arr accessing is correct----------------
    //             };
    //         }
    //         $this->TotalPrice = $this->calculate_Price($UnitPrice_arr);
    //     }
    // }
    // class Order_Profile {
    // // Properties
    //     public $OrderID;
    //     public $FullName;
    //     public $OrderDate;
    //     public $OrderDetails = []; //Array of OrderDetails objects
    //     public $TotalAmount;

    //     // Methods
    //     function set_OrderId($id){
    //         $this->OrderID = $id;
    //     }
    //     function set_FullName($name){
    //         $this->FullName = $name;
    //     }
    //     function set_OrderDate($date){
    //         $this->OrderDate = $date;
    //     }
    //     function set_TotalAmount($total){
    //         $this->TotalAmount = $total;
    //     }
    // }



    // k shjghflgfahwgbfuftgb8fy4qcr


    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    // Queries
    // $sql1 = "SELECT `items`.`ItemID`, `items`.`ItemName`, `items`.`Price`
    //         FROM `items`
    //         ORDER BY `items`.`ItemID`;";
    $sql2 = "SELECT `order_details`.`OrderID`, `users`.`FullName`, `order_details`.`ItemID`, `order_details`.`ItemQuantity`, `orders`.`OrderDate`, `items`.`Price`
            FROM `order_details`
            INNER JOIN `items`
            ON `order_details`.`ItemID` = `items`.`ItemID`
            INNER JOIN `orders`
            ON `orders`.`OrderID` = `order_details`.`OrderID`
            INNER JOIN `users`
            ON `orders`.`UserID` = `users`.`UserID`
            ORDER By `order_details`.`OrderID`, `order_details`.`ItemID`;";

    //get data
    // $raw_Item_Data = $conn->query($sql1);
    $raw_Order_Data = $conn->query($sql2);
    $json_placeholder = [];
    while($query_raw_row = $raw_Order_Data->fetch_assoc()){
        $json_placeholder[] = $query_raw_row;
    }
    $json_echo = json_encode($json_placeholder);
    echo $json_echo;
?>