<?php

// get_clubs.php
include('../db.php');

$query = "SELECT * FROM clubs";
$result = $conn->query($query);

$clubs = [];
while ($row = $result->fetch_assoc()) {
    $clubs[] = $row;
}

echo json_encode($clubs);


?>