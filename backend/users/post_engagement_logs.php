<?php


// post_engagement_logs.php
include('db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['action_type'], $data['details'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

// Get user_id from session
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "User not logged in"]);
    exit();
}
$user_id = $_SESSION['user_id'];

$query = "INSERT INTO engagement_logs (user_id, action_type, details) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("iss", $user_id, $data['action_type'], $data['details']);

if ($stmt->execute()) {
    echo json_encode(["message" => "Engagement action logged successfully"]);
} else {
    echo json_encode(["message" => "Failed to log engagement action"]);
}


?>