<?php

// put_chat_rooms.php
include('../db.php');

$room_id = $_GET['room_id'];
$data = json_decode(file_get_contents("php://input"), true);

$updates = [];
$params = [];
$types = "";

foreach (['name'] as $field) {
    if (isset($data[$field])) {
        $updates[] = "$field = ?";
        $params[] = $data[$field];
        $types .= "s";
    }
}

if (empty($updates)) {
    echo json_encode(["message" => "No fields to update"]);
    exit();
}

$params[] = $room_id;
$types .= "i";

$query = "UPDATE chat_rooms SET " . implode(", ", $updates) . " WHERE room_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode(["message" => "Chat room updated successfully"]);
} else {
    echo json_encode(["message" => "Failed to update chat room"]);
}



?>