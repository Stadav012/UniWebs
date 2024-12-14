<?php

// put_clubs.php
include('../db.php');

$club_id = $_GET['club_id'];
$data = json_decode(file_get_contents("php://input"), true);

$updates = [];
$params = [];
$types = "";

foreach (['name', 'description', 'club_type'] as $field) {
    if (isset($data[$field])) {
        $updates[] = "$field = ?";
        $params[] = $data[$field];
        $types .= "s";
    }
}

if (empty($updates)) {
    echo json_encode(["message" => "No fields to update"]);
    exit();
}

$params[] = $club_id;
$types .= "i";

$query = "UPDATE clubs SET " . implode(", ", $updates) . " WHERE club_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    echo json_encode(["message" => "Club updated successfully"]);
} else {
    echo json_encode(["message" => "Failed to update club"]);
}


?>