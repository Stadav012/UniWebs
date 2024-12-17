<?php
// update_user_role.php
require 'middleware.php';
require 'db_connection.php';

isAdmin();

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'];
$newRole = $data['role'];

if (!$username || !$newRole) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit();
}

$stmt = $conn->prepare("UPDATE users SET role = ? WHERE username = ?");
$stmt->bind_param("ss", $newRole, $username);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Role updated successfully"]);
} else {
    echo json_encode(["error" => "Failed to update role"]);
}
?>
