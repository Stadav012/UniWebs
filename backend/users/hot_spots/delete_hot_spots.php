<?php


// delete_hot_spots.php
include('../db.php');

$spot_id = $_GET['spot_id'];

$query = "DELETE FROM hot_spots WHERE spot_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $spot_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Hot spot deleted successfully"]);
} else {
    echo json_encode(["message" => "Failed to delete hot spot"]);
}


?>