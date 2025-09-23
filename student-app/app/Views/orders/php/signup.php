<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");//IMPORTANT, ESTABLISH CONNECTION

$username = $_POST['username'];
$email = $_POST["email"];
$password_unhash = $_POST['password'];
$password = password_hash($password_unhash, PASSWORD_DEFAULT);
$fullname = $_POST['fullname'];
$address = $_POST['address'];
$contact = $_POST['contact'];

//CHECK IF DUPLICATE
$checkQuery = "SELECT 1 FROM users WHERE Username = ? OR Email = ? LIMIT 1";
$check_prep = $conn->prepare($checkQuery);
$check_prep->bind_param("ss", $username, $email);
if($check_prep->execute()){
    $check_prep->store_result();

    if($check_prep->num_rows > 0){
        echo json_encode([
        "Error" => true,
        "Error_Message" => "Username or Email already exists"
    ]);
    exit();
    }else {
        $insquery = "INSERT INTO users VALUES (DEFAULT, ?, ?, ?, ?, ?, ?, DEFAULT)";
        $prep = $conn->prepare($insquery);
        $prep->bind_param("ssssss", $fullname, $address, $contact, $username, $email, $password);


        if($prep->execute()){
            $getId = $conn->insert_id;
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
    }
}else{
    echo json_encode([
        "Error" => true,
        "Error_Message" => "Error checking duplicates"
    ]);
    exit();
}

?>