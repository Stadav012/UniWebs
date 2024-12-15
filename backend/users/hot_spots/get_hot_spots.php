<?php

// get_hot_spots.php
include('../db.php');

// Get the filter parameters from the frontend (if they exist)
$filters = json_decode(file_get_contents('php://input'), true);
$spotTypes = isset($filters['types']) ? $filters['types'] : [];
$minLikes = isset($filters['minLikes']) ? (int) $filters['minLikes'] : 0;

// Base query
$query = "SELECT * FROM hot_spots WHERE likes_count >= $minLikes";

// Add filter for spot types
if (!empty($spotTypes)) {
    $typesString = "'" . implode("', '", $spotTypes) . "'";
    $query .= " AND spot_type IN ($typesString)";
}

// Execute the query
$result = $conn->query($query);

$hotSpots = [];
while ($row = $result->fetch_assoc()) {
    $hotSpots[] = $row;
}

// Return the results as JSON
echo json_encode($hotSpots);

?>
