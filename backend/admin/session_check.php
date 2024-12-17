<?php

# CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-Type: application/json; charset=UTF-8");

session_start();

// Check if user is logged in and has an admin role
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    echo json_encode([
        'logged_in' => true,
        'role' => 'admin'
    ]);
} else {
    // If not logged in or not an admin
    echo json_encode([
        'logged_in' => false,
        'error' => 'Unauthorized access. Admin role required.'
    ]);
    http_response_code(403); // Forbidden
}
?>
