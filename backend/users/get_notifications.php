<?php

// Example for fetching unread messages for notifications
include('db.php');

session_start();
$user_id = $_SESSION['user_id'];

// Query to fetch unread messages
$query = "
    SELECT cm.message_id, cm.room_id, cm.content, cm.sent_at, cm.user_color, cm.is_anonymous, cm.is_read, cr.name AS room_name
    FROM chat_messages cm
    INNER JOIN chat_rooms cr ON cm.room_id = cr.room_id
    WHERE cm.is_read = 0 AND cm.user_id != ? 
    ORDER BY cm.sent_at DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$unread_messages = [];
while ($row = $result->fetch_assoc()) {
    $unread_messages[] = $row;
}

echo json_encode($unread_messages);

?>
