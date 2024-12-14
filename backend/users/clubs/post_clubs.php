<?php

// post_clubs.php
include('../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['name'], $data['description'], $data['club_type'], $data['created_by'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

$query = "INSERT INTO clubs (name, description, club_type, created_by) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssi", $data['name'], $data['description'], $data['club_type'], $data['created_by']);

if ($stmt->execute()) {
    echo json_encode(["message" => "Club created successfully"]);
} else {
    echo json_encode(["message" => "Failed to create club"]);
}


?>