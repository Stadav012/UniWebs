<?php
// get_chat_room_members.php
include('../db.php');

if (!isset($_GET['room_id'])) {
    echo json_encode(["message" => "Missing room ID"]);
    exit();
}

$room_id = $_GET['room_id'];

// Fetch chat room members
$query = "
    SELECT users.user_id, users.username 
    FROM room_members 
    JOIN users ON room_members.user_id = users.user_id 
    WHERE room_members.room_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

$members = [];
while ($row = $result->fetch_assoc()) {
    $members[] = $row;
}

echo json_encode($members);
?>
