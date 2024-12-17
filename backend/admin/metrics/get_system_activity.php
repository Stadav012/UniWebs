<?php

// get_system_activity.php
include('../db_connection.php');

$query = "SELECT 
            (SELECT COUNT(*) FROM events) as total_events,
            (SELECT COUNT(*) FROM chat_messages) as total_messages,
            (SELECT COUNT(DISTINCT user_id) FROM engagement_logs WHERE action_timestamp >= DATE_SUB(NOW(), INTERVAL 1 DAY)) as active_users";

$result = $conn->query($query);

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["message" => "Failed to retrieve system metrics"]);
}


?>