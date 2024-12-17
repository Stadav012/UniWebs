<?php

// get_user_engagement.php
include('../db_connection.php');

$query = "SELECT action_type, COUNT(*) as count FROM engagement_logs GROUP BY action_type";
$result = $conn->query($query);

$metrics = [];
while ($row = $result->fetch_assoc()) {
    $metrics[] = $row;
}

echo json_encode($metrics);


?>