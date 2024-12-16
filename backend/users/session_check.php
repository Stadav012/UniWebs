<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    echo json_encode(['logged_in' => true]);
} else {
    echo json_encode(['logged_in' => false]);
}
?>
