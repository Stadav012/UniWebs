<?php
// get_chat_rooms.php
include('../db.php');

// Fetch chat rooms with username of the creator and message count
$query = "
    SELECT 
        chat_rooms.room_id, 
        chat_rooms.name, 
        chat_rooms.is_anonymous, 
        chat_rooms.created_by, 
        users.username AS created_by_username, 
        COUNT(chat_messages.message_id) AS message_count
    FROM chat_rooms
    LEFT JOIN users ON chat_rooms.created_by = users.user_id
    LEFT JOIN chat_messages ON chat_rooms.room_id = chat_messages.room_id
    GROUP BY chat_rooms.room_id, chat_rooms.name, chat_rooms.is_anonymous, chat_rooms.created_by, users.username
";

$result = $conn->query($query);
$chatRooms = [];

while ($row = $result->fetch_assoc()) {
    $chatRooms[] = [
        "room_id" => $row['room_id'],
        "name" => $row['name'],
        "is_anonymous" => $row['is_anonymous'],
        "created_by_username" => $row['created_by_username'] ?? 'Unknown', // Fallback if null
        "message_count" => $row['message_count'] ?? 0
    ];
}

echo json_encode($chatRooms);
?>
