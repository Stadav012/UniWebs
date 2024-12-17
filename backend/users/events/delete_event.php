<?php
// delete_event.php
include('../db.php');

$event_id = $_GET['event_id'];

$query = "DELETE FROM events WHERE event_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);

if ($stmt->execute()) {
    echo json_encode(["message" => "Event deleted successfully"]);
} else {
    echo json_encode(["message" => "Failed to delete event"]);
}
?>
