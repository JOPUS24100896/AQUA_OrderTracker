<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");//IMPORTANT, ESTABLISH CONNECTION

$username = $_POST['username'];
$password = $_POST['password'];
$fullname = $_POST['fullname'];
$address = $_POST['address'];
$contact = $_POST['contact'];

//APPARENTTLY NEEDED FOR SECURITY
$insquery = "INSERT INTO customers (CustomerName, `Address`, Contact, Username, `Password`) VALUES (?, ?, ?, ?, ?)";
$prep = $conn->prepare($insquery);
$prep->bind_param("sssss", $fullname, $address, $contact, $username, $password);

if($prep->execute()){
    $user = [];
    $getId = "SELECT CustomerID FROM customers WHERE Username = ?";
    $take = $conn->prepare($getId);
    $take->bind_param("s", $username);
    $take->execute();
    $raw = $take->get_result();
    if($user = $raw->fetch_assoc()){
        $_SESSION["user_id"] = $user["CustomerID"];
        echo "Successful Sign Up" . $_SESSION["user_id"];
    }else {
        echo "Unable to retrieve user";
    }
    
} 
else echo "There was a problem with signing up, " . $prep->error;
?>