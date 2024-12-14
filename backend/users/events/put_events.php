<?php

// put_events.php
include('../db.php');

$event_id = $_GET['event_id'];
$data = json_decode(file_get_contents("php://input"), true);

$updates = [];
$params = [];
$types = "";

foreach (['name', 'description', 'start_time', 'end_time', 'location_lat', 'location_lng', 'event_type'] as $field) {
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

$params[] = $event_id;
$types .= "i";

$query = "UPDATE events SET " . implode(", ", $updates) . " WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode(["message" => "Event updated successfully"]);
} else {
    echo json_encode(["message" => "Failed to update event"]);
}


?>