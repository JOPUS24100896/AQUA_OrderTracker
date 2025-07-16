<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
if($conn->connect_errno) die("There was a problem connecting to the database: " . $conn->connect_errno);

$fullname = $_POST["partnerName"];
$address = $_POST["Address"];
$contact = $_POST["contactNumber"];
$username = $_POST["Username"];
$email = $_POST["partnerEmail"];
$password_unhash = $_POST["UpdatePassword"];
$password =password_hash($password_unhash, PASSWORD_DEFAULT);
$userid = $_SESSION["user_id"];

//CHECK DUPLICATES
$checkQuery = "SELECT UserID FROM users WHERE Username = ? OR Email = ? LIMIT 1";
$check_prep = $conn->prepare($checkQuery);
$check_prep->bind_param("ss", $username, $email);
if($check_prep->execute()){
    $check_prep->store_result();
    $check_prep->bind_result($selectUserID);
    $check_prep->fetch();
    if($check_prep->num_rows > 0 && $selectUserID != $userid){
        echo json_encode([
        "Error" => true,
        "Error_Message" => "Username or Email already exists.",
        "CHECK" => $selectUserID
    ]);
    exit();
    }
}


//UPDATE PROFILE
$update_query = <<<QUERY
                UPDATE users SET `FullName` = ?, `Address` = ?, `Contact` = ?,
                                `Username` = ?, `Email` = ?, `Password` = ?
                 WHERE UserID = ?;
            QUERY;
$update_prepare = $conn->prepare($update_query);
$update_prepare->bind_param("ssssssi", $fullname, $address, $contact, $username, $email, $password, $userid);
if($update_prepare->execute()){
    echo json_encode([
        "Error" => false,
        "Error_Message" => "Profile has been succesfully updated."
    ]);
}else{
    echo json_encode([
        "Error" => true,
        "Error_Message" => "There was a problem updating your profile. Error: $conn->connect_errno"
    ]);
}
                
/**<div class="input_boxes">
                            <label for="partnerName">Full Name <span style="color: red;">*</span></label>
                            <input type="text" name="partnerName" required>

                            <label for="Address">Address <span style="color: red;">*</span></label>
                            <input type="text" name="Address" required>

                            <label for="contactNumber">Contact Number <span style="color: red;">*</span></label>
                            <input type="text" name="contactNumber" required>    
                        </div>
                        

                        <div class="input_boxes">
                            <label for="Username">Username <span style="color: red;">*</span></label>
                            <input type="text" id="Username" name="Username" required>

                            <label for="partnerEmail">Email <span style="color: red;">*</span></label>
                            <input type="email" id="partnerEmail" name="partnerEmail" required>

                            <label for="Password">Password <span style="color: red;">*</span></label>
                            <input type="password" id="Password" name="UpdatePassword" required>
                        </div>
                    </div> */
?>