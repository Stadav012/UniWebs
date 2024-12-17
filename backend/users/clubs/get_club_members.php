<?php

// get_club_members.php
include('../db.php');

$club_id = $_GET['club_id'];

// Query to fetch all members of the club
$query = "
    SELECT u.user_id, u.username
    FROM users u
    INNER JOIN club_memberships cm ON u.user_id = cm.user_id
    WHERE cm.club_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $club_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $members = [];
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
    echo json_encode($members);
} else {
    echo json_encode(["message" => "No members found"]);
}

?>
