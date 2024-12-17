<?php

// remove_member.php
include('../db.php');

$club_id = $_GET['club_id'];
$user_id = $_GET['user_id'];

// Query to remove a member from the club
$query = "DELETE FROM club_memberships WHERE club_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $club_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Member removed successfully"]);
} else {
    echo json_encode(["message" => "Failed to remove member"]);
}

?>
