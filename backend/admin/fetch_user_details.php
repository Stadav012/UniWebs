<?php
require 'middleware.php'; // For admin check
require 'db_connection.php';

isAdmin(); // Ensure only admins can access

// Check if username is provided in the GET request
if (!isset($_GET['username'])) {
    http_response_code(400);
    echo json_encode(["error" => "Username is required"]);
    exit();
}

$username = $_GET['username'];

// Fetch user details from the database
$stmt = $conn->prepare("SELECT username, email, role, last_active_at, engagement_score, created_at FROM users WHERE username = ?");
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "User not found"]);
    }
} else {
    http_response_code(500);
    echo json_encode(["error" => "Database query failed"]);
}

$stmt->close();
$conn->close();
?>
