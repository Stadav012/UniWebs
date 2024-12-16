<?php
// get_chat_rooms.php
include('../db.php');

$query = "SELECT room_id, name, is_anonymous FROM chat_rooms";
$result = $conn->query($query);

$rooms = [];
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

function getRandomUsername() {
    $adjectives = ['Brave', 'Clever', 'Silent', 'Cheerful', 'Mighty'];
    $animals = ['Lion', 'Eagle', 'Fox', 'Dolphin', 'Panda'];
    return $adjectives[array_rand($adjectives)] . ' ' . $animals[array_rand($animals)];
}

// Assign a random username to an anonymous user if not already assigned
session_start();
if (!isset($_SESSION['anonymous_username'])) {
    $_SESSION['anonymous_username'] = getRandomUsername();
}


echo json_encode($rooms);
?>
