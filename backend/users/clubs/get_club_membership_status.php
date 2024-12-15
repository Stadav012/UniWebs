<?php
// get_club_membership_status.php
include('../db.php');

$club_id = $_GET['club_id'];
session_start();
$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM club_memberships WHERE club_id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $club_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User is a member of the club
    echo json_encode(["is_member" => true]);
} else {
    // User is not a member of the club
    echo json_encode(["is_member" => false]);
}
?>