<?php

// Get user's clubs
include('db.php');

session_start();
$user_id = $_SESSION['user_id'];

// Query to fetch clubs the user is part of (based on engagement_logs or similar)
$query = "
    SELECT c.club_id, c.name, c.description, c.club_type
    FROM clubs c
    JOIN club_memberships cm ON c.club_id = cm.club_id
    WHERE cm.user_id = ?;   
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$clubs = [];
while ($row = $result->fetch_assoc()) {
    $clubs[] = $row;
}

echo json_encode($clubs);

?>
