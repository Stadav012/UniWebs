<?php

// post_hot_spots.php
include('../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['description'], $data['spot_type'], $data['location_lat'], $data['location_lng'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

// Get added_by from session
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "User not logged in"]);
    exit();
}

$data['added_by'] = $_SESSION['user_id'];

$query = "INSERT INTO hot_spots (name, description, spot_type, location_lat, location_lng, added_by) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssdsi", $data['name'], $data['description'], $data['spot_type'], $data['location_lat'], $data['location_lng'], $data['added_by']);

if ($stmt->execute()) {
    // response.success = true
    echo json_encode(["message" => "Hot spot added successfully"]);
} else {
    echo json_encode(["message" => "Failed to add hot spot"]);
}



?>