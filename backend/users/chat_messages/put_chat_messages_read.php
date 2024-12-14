<?php

// put_chat_messages_read.php
include('../db.php');

$message_id = $_GET['message_id'];

$query = "UPDATE chat_messages SET is_read = 1 WHERE message_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $message_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Message marked as read"]);
} else {
    echo json_encode(["message" => "Failed to mark message as read"]);
}


?>