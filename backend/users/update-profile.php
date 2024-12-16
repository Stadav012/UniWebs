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

// Check if required fields are provided
if (empty($data['current_password'])) {
    echo json_encode(["message" => "Current password is required"]);
    exit();
}

$current_password = $data['current_password'];

// Fetch current password hash from database
$query = "SELECT password_hash FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($current_password, $user['password_hash'])) {
    echo json_encode(["message" => "Invalid current password"]);
    exit();
}

// Fields to update
$fields_to_update = [];
$bind_types = "";
$bind_values = [];

// Update username
if (isset($data['username']) && !empty($data['username'])) {
    $fields_to_update[] = "username = ?";
    $bind_types .= "s";
    $bind_values[] = $data['username'];
}

// Update email
if (isset($data['email']) && !empty($data['email'])) {
    $fields_to_update[] = "email = ?";
    $bind_types .= "s";
    $bind_values[] = $data['email'];
}

// Update password
if (isset($data['password']) && !empty($data['password'])) {
    $new_password_hash = password_hash($data['password'], PASSWORD_BCRYPT);
    $fields_to_update[] = "password_hash = ?";
    $bind_types .= "s";
    $bind_values[] = $new_password_hash;
}

// Update social media links
if (isset($data['twitter_url'])) {
    $fields_to_update[] = "twitter_url = ?";
    $bind_types .= "s";
    $bind_values[] = $data['twitter_url'];
}
if (isset($data['linkedin_url'])) {
    $fields_to_update[] = "linkedin_url = ?";
    $bind_types .= "s";
    $bind_values[] = $data['linkedin_url'];
}
if (isset($data['github_url'])) {
    $fields_to_update[] = "github_url = ?";
    $bind_types .= "s";
    $bind_values[] = $data['github_url'];
}

// If no fields are provided to update
if (empty($fields_to_update)) {
    echo json_encode(["message" => "No data to update"]);
    exit();
}

// Build query
$update_query = "UPDATE users SET " . implode(", ", $fields_to_update) . " WHERE user_id = ?";
$bind_types .= "i";
$bind_values[] = $user_id;

$stmt = $conn->prepare($update_query);
$stmt->bind_param($bind_types, ...$bind_values);

// Execute update
if ($stmt->execute()) {
    echo json_encode(["message" => "Profile updated successfully"]);
} else {
    echo json_encode(["message" => "Error updating profile"]);
}

?>
