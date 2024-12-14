<?php

// get_weekly_engagement.php
include('db.php');

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $query = "SELECT action_type, COUNT(*) as count 
              FROM engagement_logs 
              WHERE user_id = ? AND DATE(action_timestamp) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
              GROUP BY action_type";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $engagement = [];
    while ($row = $result->fetch_assoc()) {
        $engagement[] = $row;
    }

    echo json_encode($engagement);
} else {
    echo "User ID not found in session.";
}


?>