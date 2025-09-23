<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "aquadelsol_ordertracker");

$data = json_decode(file_get_contents("php://input"), true);
$itemId = $data['ItemID'];
$addedStock = $data['AddedStock'];

if ($itemId && $addedStock) {
    $query = "UPDATE itemnoimages SET StockQuantity = StockQuantity + ? WHERE ItemID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $addedStock, $itemId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Stock updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update stock."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid input."]);
}

$conn->close();
?>