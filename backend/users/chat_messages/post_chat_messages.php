<?php


// post_chat_messages.php
include('../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['room_id'], $data['content'], $data['is_anonymous'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

// Get user_id from session
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "User not logged in"]);
    exit();
}
$user_id = $_SESSION['user_id'];

$query = "INSERT INTO chat_messages (room_id, user_id, content, is_anonymous) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iisi", $data['room_id'], $user_id, $data['content'], $data['is_anonymous']);

if ($stmt->execute()) {
    echo json_encode(["message" => "Message sent successfully"]);
} else {
    echo json_encode(["message" => "Failed to send message"]);
}


?>