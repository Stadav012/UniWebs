<?php

// post_hot_spots.php
include('../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['description'], $data['spot_type'], $data['location_lat'], $data['location_lng'], $data['added_by'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

$query = "INSERT INTO hot_spots (name, description, spot_type, location_lat, location_lng, added_by) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssdsi", $data['name'], $data['description'], $data['spot_type'], $data['location_lat'], $data['location_lng'], $data['added_by']);

if ($stmt->execute()) {
    echo json_encode(["message" => "Hot spot added successfully"]);
} else {
    echo json_encode(["message" => "Failed to add hot spot"]);
}



?>