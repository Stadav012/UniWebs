<?php
// get_chat_messages.php
include('../db.php');

$room_id = $_GET['room_id'];

$query = "SELECT message_id, content, user_color, is_anonymous, chat_messages.user_id AS user_id, username FROM chat_messages JOIN users ON users.user_id = chat_messages.user_id WHERE room_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
