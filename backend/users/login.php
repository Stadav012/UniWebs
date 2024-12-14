<?php

// login.php
include('db.php'); // Include the database connection

// Get input data
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(["message" => "Missing required fields"]);
    exit();
}

$username = $data['username'];
$password = $data['password'];

// Check if user exists
$query = "SELECT user_id, username, password_hash, role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["message" => "Invalid username or password"]);
    exit();
}

$user = $result->fetch_assoc();

// Verify password
if (!password_verify($password, $user['password_hash'])) {
    echo json_encode(["message" => "Invalid username or password"]);
    exit();
}

// Start session and set session variables
session_start();
$_SESSION['user_id'] = $user['user_id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

// Record login session
$login_time = date('Y-m-d H:i:s');
$query = "INSERT INTO sessions (user_id, login_time) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("is", $user['user_id'], $login_time);
$stmt->execute();

// Set session cookie (optional, for persistent sessions)
setcookie("user_id", $user['user_id'], time() + 3600, "/", "", false, true); // 1 hour expiration

echo json_encode(["message" => "Login successful", "role" => $user['role']]);


?>