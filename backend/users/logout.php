<?php
// logout.php
session_start();

// Ensure the user is logged in before proceeding
if (isset($_SESSION['user_id'])) {
    // Include your database connection (db.php)
    require_once 'db.php';

    // Get the user ID from the session
    $userId = $_SESSION['user_id'];

    // Get the current time to update the last active timestamp
    $currentTime = date('Y-m-d H:i:s');

    // Update the last active time in the database
    $stmt = $conn->prepare("UPDATE users SET last_active_at = ? WHERE user_id = ?");
    $stmt->execute([$currentTime, $userId]);

    // update the session table
    $stmt = $conn->prepare("UPDATE sessions SET logout_time = ? WHERE user_id = ? AND logout_time IS NULL");
    $stmt->execute([$currentTime, $userId]);
    

    // Logout process
    session_unset();
    session_destroy();

    // Delete session cookie if set
    if (isset($_COOKIE['user_id'])) {
        setcookie('user_id', '', time() - 3600, '/', '', false, true); // Expire the cookie
    }

    echo json_encode(["message" => "Logged out successfully"]);
} else {
    // If no session, return an error message
    echo json_encode(["message" => "No active session found"]);
}
?>
