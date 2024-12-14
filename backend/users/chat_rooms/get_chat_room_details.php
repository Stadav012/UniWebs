<?php


// get_chat_room_details.php
include('../db.php');

$room_id = $_GET['room_id'];

$query = "SELECT * FROM chat_rooms WHERE room_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["message" => "Chat room not found"]);
}



?>