<?php
// get_user_details.php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT username, email, role, last_active_at, engagement_score, created_at, chat_messages.user_color FROM users JOIN chat_messages ON users.user_id = chat_messages.user_id WHERE users.user_id = ? LIMIT 1;";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode($user);
} else {
    echo json_encode(["message" => "User not found"]);
}
?>
