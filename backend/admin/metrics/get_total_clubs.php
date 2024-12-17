<?php
include('../db_connection.php');

$query = "SELECT COUNT(*) as total_clubs FROM clubs";
$result = $conn->query($query);

if ($row = $result->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(["message" => "Failed to retrieve clubs count"]);
}
?>
