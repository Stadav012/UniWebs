<?php
// get_chat_messages.php
include('../db.php');

session_start();
$room_id = $_GET['room_id'];
$loggedInUserId = $_SESSION['user_id'];

$query = "SELECT cm.content, cm.user_id, cm.is_anonymous, cm.user_color as user_color, 
                 IF(cm.is_anonymous = 1, NULL, u.username) AS username, cm.user_id = ? AS is_user 
          FROM chat_messages cm
          LEFT JOIN users u ON cm.user_id = u.user_id
          WHERE cm.room_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $loggedInUserId, $room_id);
$stmt->execute();
$result = $stmt->get_result();

function getRandomUsername() {
    $adjectives = ['Brave', 'Clever', 'Silent', 'Cheerful', 'Mighty'];
    $animals = ['Lion', 'Eagle', 'Fox', 'Dolphin', 'Panda'];
    return $adjectives[array_rand($adjectives)] . ' ' . $animals[array_rand($animals)];
}

if (!isset($_SESSION['anonymous_username'])) {
    $_SESSION['anonymous_username'] = getRandomUsername();
}

$messages = [];
while ($row = $result->fetch_assoc()) {
    if ($row['is_anonymous'] == 1) {
        $row['username'] = $_SESSION['anonymous_username'];
    }
    $messages[] = $row;
}

echo json_encode($messages);

?>
