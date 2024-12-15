<?php

// get_all_room_messages.php
include('../db.php');

session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not authenticated"]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Query to fetch all messages from rooms the user is part of
$query = "
    SELECT cm.message_id, cm.room_id, cm.content, cm.sent_at, cr.name AS room_name
    FROM chat_messages cm
    INNER JOIN chat_rooms cr ON cm.room_id = cr.room_id
    INNER JOIN room_members rm ON rm.room_id = cr.room_id
    WHERE rm.user_id = ?
    ORDER BY cm.sent_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);

?>
