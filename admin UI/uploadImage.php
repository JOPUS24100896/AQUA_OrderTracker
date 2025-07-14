<?php
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $imgLocation = $_FILES["image"]["tmp_name"];
    $type = $_POST["type"];
    $image = file_get_contents($imgLocation);
    $id = (int) $_POST["id"];

    $query = "UPDATE items SET `Image` = ? WHERE ItemID = ?";
    $query_prepare = $conn->prepare($query);
    $query_prepare->bind_param("bi", $null, $id);
    $null = NULL;

    $query_prepare->send_long_data(0, $image);

    if($query_prepare->execute()){
        echo "Good";
    }else echo "Bad";

    $query1 = "UPDATE items SET `ImageType` = ? WHERE ItemID = ?";
    $query1_prepare = $conn->prepare($query1);
    $query1_prepare->bind_param("si", $type, $id);


    if($query1_prepare->execute()){
        echo "Good";
    }else echo "Bad";
?>
