<?php

// get_hot_spots.php
include('../db.php');

$query = "SELECT * FROM hot_spots";
$result = $conn->query($query);

$hotSpots = [];
while ($row = $result->fetch_assoc()) {
    $hotSpots[] = $row;
}

echo json_encode($hotSpots);


?>