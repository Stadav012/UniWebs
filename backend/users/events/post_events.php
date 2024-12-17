<?php


// post_events.php
include('../db.php');

$data = json_decode(file_get_contents("php://input"), true);

// Check if all required fields are present
if (!isset($data['name'], $data['description'], $data['start_time'], $data['end_time'], $data['location_lat'], $data['location_lng'], $data['event_type'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

// Get the created_by from session variable called user_id
session_start();
$created_by = $_SESSION['user_id'];

$query = "INSERT INTO events (name, description, start_time, end_time, location_lat, location_lng, event_type, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssdssi", $data['name'], $data['description'], $data['start_time'], $data['end_time'], $data['location_lat'], $data['location_lng'], $data['event_type'], $created_by);

if ($stmt->execute()) {
    echo json_encode(["message" => "Event created successfully"]);
} else {
    echo json_encode(["message" => "Failed to create event"]);
}



?>