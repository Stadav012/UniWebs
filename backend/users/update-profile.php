<?php

// update-profile.php
session_start();
include('db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

// Check if any fields to update are provided
$fields_to_update = [];

if (isset($data['username'])) {
    $fields_to_update[] = "username = '" . $data['username'] . "'";
}

if (isset($data['email'])) {
    $fields_to_update[] = "email = '" . $data['email'] . "'";
}
if (isset($data['role'])) {
    $fields_to_update[] = "role = '" . $data['role'] . "'";
}

if (isset($data['engagement_score'])) {
    $fields_to_update[] = "engagement_score = " . $data['engagement_score'];
}

if (isset($data['last_active_at'])) {
    $fields_to_update[] = "last_active_at = '" . $data['last_active_at'] . "'";
}


// If no fields are provided
if (empty($fields_to_update)) {
    echo json_encode(["message" => "No data to update"]);
    exit();
}

// Build SQL query
$update_query = "UPDATE users SET " . implode(", ", $fields_to_update) . " WHERE user_id = ?";
$stmt = $conn->prepare($update_query);
$stmt->bind_param("i", $user_id);

// Execute update
if ($stmt->execute()) {
    echo json_encode(["message" => "Profile updated successfully"]);
} else {
    echo json_encode(["message" => "Error updating profile"]);
}


?>