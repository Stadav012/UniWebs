<?php

// get_chat_rooms.php
include('../db.php');

$query = "SELECT * FROM chat_rooms";
$result = $conn->query($query);

$chatRooms = [];
while ($row = $result->fetch_assoc()) {
    $chatRooms[] = $row;
}

echo json_encode($chatRooms);


?>