<?php
// delete_member.php
include('../db.php');

if (!isset($_GET['member_id']) || !isset($_GET['room_id'])) {
    echo json_encode(["message" => "Missing parameters"]);
    exit();
}

$member_id = $_GET['member_id'];
$room_id = $_GET['room_id'];

$query = "DELETE FROM room_members WHERE user_id = ? AND room_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $member_id, $room_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Member deleted successfully"]);
} else {
    echo json_encode(["message" => "Failed to delete member"]);
}
?>
