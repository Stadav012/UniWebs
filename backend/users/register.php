<?php

// register.php
include('db.php');

// Get input data
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (!isset($data['username']) || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

$username = $data['username'];
$email = $data['email'];
$password = $data['password'];
$password_hash = password_hash($password, PASSWORD_DEFAULT);
$role = isset($data['role']) ? $data['role'] : 'student';
$engagement_score = isset($data['engagement_score']) ? $data['engagement_score'] : 0;
$last_active_at = date('Y-m-d H:i:s'); // Set current time

// Prepare SQL query
$query = "INSERT INTO users (username, email, password_hash, role, engagement_score, last_active_at) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssds", $username, $email, $password_hash, $role, $engagement_score, $last_active_at);

// Execute the query
if ($stmt->execute()) {
    echo json_encode(["message" => "User registered successfully"]);
} else {
    echo json_encode(["message" => "Error registering user"]);
}




?>