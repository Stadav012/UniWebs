<?php
// get_rooms.php
include('../db.php');

$query = "SELECT room_id, name FROM chat_rooms";
$result = $conn->query($query);

$rooms = [];
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

echo json_encode($rooms);
?>
