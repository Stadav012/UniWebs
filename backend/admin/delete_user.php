<?php
// delete_user.php
require 'middleware.php';
require 'db_connection.php';

isAdmin();

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'];

if (!$username) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit();
}

$stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "User deleted successfully"]);
} else {
    echo json_encode(["error" => "Failed to delete user"]);
}
?>
