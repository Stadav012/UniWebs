<?php 

// post_club_join.php
include('../db.php');

$club_id = $_GET['club_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['user_id'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

$query = "INSERT INTO club_members (club_id, user_id) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $club_id, $data['user_id']);

if ($stmt->execute()) {
    echo json_encode(["message" => "User joined the club"]);
} else {
    echo json_encode(["message" => "Failed to join club"]);
}


?>