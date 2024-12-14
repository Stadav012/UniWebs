<?php

// check-session.php
session_start();

// Check if the session exists
if (isset($_SESSION['user_id'])) {
    echo json_encode([
        "message" => "User is logged in",
        "user_id" => $_SESSION['user_id'],
        "username" => $_SESSION['username'],
        "role" => $_SESSION['role']
    ]);
} else {
    echo json_encode(["message" => "No active session"]);
}


?>