<?php

// put_hot_spots.php
include('../db.php');

$spot_id = $_GET['spot_id'];
$data = json_decode(file_get_contents("php://input"), true);

$updates = [];
$params = [];
$types = "";

foreach (['name', 'description', 'spot_type', 'location_lat', 'location_lng'] as $field) {
    if (isset($data[$field])) {
        $updates[] = "$field = ?";
        $params[] = $data[$field];
        $types .= is_float($data[$field]) ? "d" : "s";
    }
}

if (empty($updates)) {
    echo json_encode(["message" => "No fields to update"]);
    exit();
}

$params[] = $spot_id;
$types .= "i";

$query = "UPDATE hot_spots SET " . implode(", ", $updates) . " WHERE spot_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode(["message" => "Hot spot updated successfully"]);
} else {
    echo json_encode(["message" => "Failed to update hot spot"]);
}


?>