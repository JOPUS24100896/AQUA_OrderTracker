<?php
session_start();
mysqli_report(MYSQLI_REPORT_OFF);
$conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");//IMPORTANT, ESTABLISH CONNECTION

$username = $_POST['username'];
$email = $_POST["email"];
$password = $_POST['password'];
$fullname = $_POST['fullname'];
$address = $_POST['address'];
$contact = $_POST['contact'];

//APPARENTTLY NEEDED FOR SECURITY
$insquery = "INSERT INTO customers VALUES (DEFAULT, ?, ?, ?, ?, ?, ?)";
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
            "Error" => false
        ]);
    }else {
        $return = json_encode([
            "Error" => true,
            "Error_Number" => $conn->errno,
            "Error_Location" => "Selecting CustomerID"
        ]);
    }
    echo $return;
    
} 
else {
        $return = json_encode([
            "Error" => true,
            "Error_Number" =>  $conn->errno,
            "Error_Location" => "Prepare Insert"
        ]);
        echo $return;
    }
?>