<?php


// get_hot_spot_details.php
include('../db.php');

$spot_id = $_GET['spot_id'];

$query = "SELECT * FROM hot_spots WHERE spot_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $spot_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["message" => "Hot spot not found"]);
}


?>