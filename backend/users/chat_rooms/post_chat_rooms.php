<?php

// post_chat_rooms.php
include('../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

// Get created_by from session
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "User not logged in"]);
    exit();
}

$created_by = $_SESSION['user_id'];

$query = "INSERT INTO chat_rooms (name, created_by) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $data['name'], $created_by);

if ($stmt->execute()) {
    echo json_encode(["message" => "Chat room created successfully"]);
} else {
    echo json_encode(["message" => "Failed to create chat room"]);
}


?>