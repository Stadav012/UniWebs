<?php

// post_club_leave.php
include('../db.php');

$club_id = $_GET['club_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'])) {
    session_start();
    $data['user_id'] = $_SESSION['user_id'];
}

if (!isset($data['user_id'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

$query = "DELETE FROM club_memberships WHERE club_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $club_id, $data['user_id']);

if ($stmt->execute()) {
    echo json_encode(["message" => "User left the club"]);
} else {
    echo json_encode(["message" => "Failed to leave club"]);
}


?>