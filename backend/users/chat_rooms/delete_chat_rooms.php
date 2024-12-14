<?php

// delete_chat_rooms.php
include('../db.php');

$room_id = $_GET['room_id'];

$query = "DELETE FROM chat_rooms WHERE room_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $room_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Chat room deleted successfully"]);
} else {
    echo json_encode(["message" => "Failed to delete chat room"]);
}


?>