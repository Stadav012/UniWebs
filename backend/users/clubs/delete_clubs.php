<?php

// delete_clubs.php
include('../db.php');

$club_id = $_GET['club_id'];

$query = "DELETE FROM clubs WHERE club_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $club_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Club deleted successfully"]);
} else {
    echo json_encode(["message" => "Failed to delete club"]);
}


?>