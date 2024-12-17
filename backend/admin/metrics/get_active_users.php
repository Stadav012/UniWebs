<?php

// get_active_users.php
include('../db_connection.php');

$query = "
    SELECT COUNT(DISTINCT user_id) as active_users 
    FROM engagement_logs 
    WHERE action_timestamp >= DATE_SUB(NOW(), INTERVAL 1 DAY)";

$result = $conn->query($query);

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["message" => "Failed to retrieve active users count"]);
}


?>