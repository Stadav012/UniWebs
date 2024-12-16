<?php
include('../db.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "User not authenticated"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$room_id = $_GET['room_id'];

$query = "SELECT * FROM room_members WHERE user_id = ? AND room_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(["is_member" => true]);
} else {
    echo json_encode(["is_member" => false]);
}
?>