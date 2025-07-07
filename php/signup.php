<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");//IMPORTANT, ESTABLISH CONNECTION

$username = $_POST['username'];
$email = $_POST["email"];
$password = $_POST['password'];
$fullname = $_POST['fullname'];
$address = $_POST['address'];
$contact = $_POST['contact'];

//APPARENTTLY NEEDED FOR SECURITY
$insquery = "INSERT INTO customers (CustomerName, `Address`, Contact, Username, `Password`, Email) VALUES (?, ?, ?, ?, ?, ?)";
$prep = $conn->prepare($insquery);
$prep->bind_param("ssssss", $fullname, $address, $contact, $username, $email, $password);

if($prep->execute()){
    $user = [];
    $getId = "SELECT CustomerID FROM customers WHERE Username = ?";
    $take = $conn->prepare($getId);
    $take->bind_param("s", $username);
    $take->execute();
    $raw = $take->get_result();
    if($user = $raw->fetch_assoc()){
        $_SESSION["user_id"] = $user["CustomerID"];
        $return = json_encode([
            "Error" => true,
            "Error_Number" => $take->errno,
            "Error_Location" => "Selecting CustomerID"
        ]);
    }else {
        $return = json_encode([
            "Error" => false;
        ])
    }
    echo $return;
    
} 
else {
        $return = json_encode([
            "Error" => true,
            "Error_Number" =>  $prep->errno,
            "Error_Location" => "Prepare Insert"
        ]);
        echo $return;
    }
?>