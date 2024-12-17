<?php
// fetch_users.php
require 'middleware.php';
require 'db_connection.php'; 

isAdmin(); // Check if the user is an admin

$query = "SELECT username, email, role, last_active_at FROM users";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $users = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($users);
} else {
    echo json_encode([]);
}
?>
