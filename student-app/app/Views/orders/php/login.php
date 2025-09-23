<?php
session_start();
$conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
$login_key = $_POST["login_key"];
$pass_key = $_POST["password"];
/**select UserID, Type from users where (Username = login_key or Email = login_key) and Password = pass_key;
END */
$verify_query = "SELECT UserID, `Type`, `Password` FROM users WHERE Username = ? or Email = ? ";
$verify_prep = $conn->prepare($verify_query);
$verify_prep->bind_param("ss", $login_key, $login_key);
if(!$verify_prep){
    echo json_encode([
        "Error" => true,
        "Error_Number" => $verify_prep->errno,
        "Error_Location" => "Bad prepare"
    ]);
    exit();
} 
if($verify_prep->execute()){
    $verify_raw = $verify_prep->get_result();
    $verify_assoc = $verify_raw->fetch_assoc();

    if(empty($verify_assoc["UserID"])){
        echo json_encode([
            "Error" => true,
            "Error_Number" => $verify_prep->errno,
            "Error_Location" => "Bad Username"
        ]);
        exit();
    }else{
        if(password_verify($pass_key, $verify_assoc["Password"])){
        
            $_SESSION["user_id"] = $verify_assoc["UserID"];
            $_SESSION["user_type"] = $verify_assoc["Type"];
            echo json_encode([
                "Error" => false,
                "ID" => $verify_assoc["UserID"], //Temporary debugging 
                "Type" => $verify_assoc["Type"]
            ]);
            exit();
        }else{
            echo json_encode([
                "Error" => true,
                "Message" => "Bad password" 
            ]);
            exit();
        }
    }
}
else {
    echo json_encode([
        "Error" => true,
        "Error_Number" => $verify_prep->errno,
        "Error_Location" => "Bad execution"
    ]);
    exit();
}
    

?>