<?php
// toggle_hot_spot_like.php
include('../db.php');
// Ensure session is started
session_start();

// Decode the JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Ensure that the required data is present
if (!isset($data['spot_id'], $data['liked'])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit();
}

$spotId = $data['spot_id'];
$liked = $data['liked']; // true = like, false = unlike
$userId = $_SESSION['user_id']; // Assuming user session is set

// Rest of the code...
if (!isset($_SESSION['hot_spot_likes'])) {
    $_SESSION['hot_spot_likes'] = [];
}

// Check if the user has already liked the spot
if ($liked) {
    // User wants to like the spot (if not already liked)
    if (!isset($_SESSION['hot_spot_likes'][$spotId])) {
        // Increase like count
        $query = "UPDATE hot_spots SET likes_count = likes_count + 1 WHERE spot_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $spotId);
        if ($stmt->execute()) {
            $_SESSION['hot_spot_likes'][$spotId] = true; // Mark the spot as liked
            echo json_encode(["success" => true, "message" => "Liked successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update like"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "You have already liked this spot"]);
    }
} else {
    // User wants to unlike the spot (if previously liked)
    if (isset($_SESSION['hot_spot_likes'][$spotId])) {
        // Decrease like count
        $query = "UPDATE hot_spots SET likes_count = likes_count - 1 WHERE spot_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $spotId);
        if ($stmt->execute()) {
            unset($_SESSION['hot_spot_likes'][$spotId]); // Remove from session
            echo json_encode(["success" => true, "message" => "Unliked successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update like"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "You haven't liked this spot"]);
    }
}

?>
