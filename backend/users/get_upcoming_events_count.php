<?php

// Example for fetching the count of all upcoming events using engagement_logs
include('db.php');

session_start();
$user_id = $_SESSION['user_id'];

// Query to fetch the count of all upcoming events the user has attended based on engagement_logs
$query = "
    SELECT COUNT(DISTINCT e.event_id) AS upcoming_events_count
    FROM events e
    JOIN engagement_logs el ON e.event_id = el.details
    WHERE el.user_id = ? AND el.action_type = 'event_attended'
    AND e.start_time > NOW()
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
$upcoming_events_count = $row['upcoming_events_count'];

echo json_encode(["upcoming_events_count" => $upcoming_events_count]);

?>
