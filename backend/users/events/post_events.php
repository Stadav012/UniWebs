<?php


// post_events.php
include('../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['description'], $data['start_time'], $data['end_time'], $data['location_lat'], $data['location_lng'], $data['event_type'], $data['created_by'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

$query = "INSERT INTO events (name, description, start_time, end_time, location_lat, location_lng, event_type, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssdssi", $data['name'], $data['description'], $data['start_time'], $data['end_time'], $data['location_lat'], $data['location_lng'], $data['event_type'], $data['created_by']);

if ($stmt->execute()) {
    echo json_encode(["message" => "Event created successfully"]);
} else {
    echo json_encode(["message" => "Failed to create event"]);
}



?>