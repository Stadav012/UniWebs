<?php
// put_chat_rooms.php
include('../db.php');

// Get room_id from the URL parameters
$room_id = $_GET['room_id'];

// Get the raw data from the request body
$data = json_decode(file_get_contents("php://input"), true);

// Initialize arrays for fields to be updated and their types
$updates = [];
$params = [];
$types = "";

// Check for fields in the request body
foreach (['name', 'is_anonymous'] as $field) {
    if (isset($data[$field])) {
        $updates[] = "$field = ?";  // Prepare the update query for each field
        // Ensure that is_anonymous is always treated as an integer (1 or 0)
        $params[] = ($field === 'is_anonymous') ? (int)$data[$field] : $data[$field];
        $types .= is_int($params[count($params) - 1]) ? "i" : "s";  // Adjust type for bool (use "i" for integer)
    }
}

// If there are no fields to update, send an error message
if (empty($updates)) {
    echo json_encode(["message" => "No fields to update"]);
    exit();
}

// Ensure that room_id is treated as an integer
$params[] = (int)$room_id;
$types .= "i";  // "i" for integer type for room_id

// Build the SQL query for updating the chat room
$query = "UPDATE chat_rooms SET " . implode(", ", $updates) . " WHERE room_id = ?";



// Prepare the query
$stmt = $conn->prepare($query);

// Bind the parameters to the query
$stmt->bind_param($types, ...$params);

// Execute the query and check the result
if ($stmt->execute()) {
    echo json_encode(["message" => "Chat room updated successfully"]);
} else {
    echo json_encode(["message" => "Failed to update chat room", "error" => $stmt->error]);
}

?>
