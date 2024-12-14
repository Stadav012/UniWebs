<?php

// post_chat_messages_flag.php
include('../db.php');

$message_id = $_GET['message_id'];

$query = "UPDATE chat_messages SET is_flagged = 1 WHERE message_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $message_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Message flagged successfully"]);
} else {
    echo json_encode(["message" => "Failed to flag message"]);
}



?>