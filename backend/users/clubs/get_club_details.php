<?php

// get_club_details.php
include('../db.php');

$club_id = $_GET['club_id'];

$query = "SELECT * FROM clubs WHERE club_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $club_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["message" => "Club not found"]);
}


?>