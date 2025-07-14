<?php
    $conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");
    $id = $_GET["id"];
    $query = "SELECT `Image`, ImageType FROM items WHERE ItemID = ?";
    $query_prepare = $conn->prepare($query);
    $query_prepare->bind_param("i", $id);

    if(!$query_prepare->execute()){
        echo "Bad execute";
        exit();
    }

    $query_prepare->store_result();
    if(!$query_prepare->num_rows){
        echo "No image";
        exit();
    }

    $query_prepare->bind_result($image, $imageType);
    $query_prepare->fetch();

    header("Content-Type: image/$imageType");
    echo $image;
?>