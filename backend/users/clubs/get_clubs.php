<?php

// get_clubs.php
include('../db.php');

// Ensure your database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM clubs";
$result = $conn->query($query);

// Check if the query execution was successful
if ($result === false) {
    die("Error executing query: " . $conn->error);
}

$clubs = [];
while ($row = $result->fetch_assoc()) {
    $clubs[] = $row;
}

// Check if any clubs were fetched
if (empty($clubs)) {
    die("No clubs found.");
}

header('Content-Type: application/json');
echo json_encode($clubs);



?>