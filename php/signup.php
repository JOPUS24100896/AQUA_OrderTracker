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
$insquery = "INSERT INTO users VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, DEFAULT)";
$prep = $conn->prepare($insquery);
$prep->bind_param("ssssss", $fullname, $address, $contact, $username, $email, $password);

if($prep->execute()){
    $getId = $conn->insert_id;
    $_SESSION["user_id"] = $getId;
    echo json_encode([
        "Error" => false
    ]);
    
}else {
    echo json_encode([
        "Error" => true,
        "Error_Number" =>  $conn->errno,
        "Error_Location" => "Prepare Insert"
    ]);
}
?>