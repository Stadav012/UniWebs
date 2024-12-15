<?php
// join_room.php
include('../db.php');

session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not authenticated"]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Get the room_id from the request
if (isset($_POST['room_id'])) {
    $room_id = $_POST['room_id'];
} else {
    echo json_encode(["error" => "Room ID not provided"]);
    exit();
}

// Check if the user is already a member of the room
$query_check = "SELECT * FROM room_members WHERE user_id = ? AND room_id = ?";
$stmt_check = $conn->prepare($query_check);
$stmt_check->bind_param("ii", $user_id, $room_id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // User is already a member of the room
    echo json_encode(["message" => "User is already a member of this room"]);
    exit();
}

// Insert a new record in the room_members table to add the user to the room
$query = "INSERT INTO room_members (room_id, user_id) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $room_id, $user_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode(["message" => "User successfully joined the room"]);
} else {
    echo json_encode(["error" => "Failed to join the room"]);
}
?>
