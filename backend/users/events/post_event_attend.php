<?php

// post_event_attend.php
include('../db.php');

$event_id = $_GET['event_id'];
// Get user_id from session
session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "User not logged in"]);
    exit();
}
$user_id = $_SESSION['user_id'];

// Rest of the code
$query = "INSERT INTO engagement_logs (user_id, action_type, details) VALUES (?, 'event_attended', ?)";
$stmt = $conn->prepare($query);
$details = "$event_id";
$stmt->bind_param("is", $user_id, $details);

if ($stmt->execute()) {
    echo json_encode(["message" => "Event booked successfully"]);

    // Update event attendance count
    $query = "UPDATE events SET attendees_count = attendees_count + 1 WHERE event_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();


} else {
    echo json_encode(["message" => "Failed to attend event"]);
}


?>