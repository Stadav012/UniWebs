<?php
// Fetch all projects and their respective details
include '../db.php';
$query = "SELECT * FROM projects";
$result = $conn->query($query);
$projects = [];

while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

echo json_encode($projects);
?>
