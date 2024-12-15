<?php
// Insert new project
include '../db.php';
$name = $_POST['name'];
$description = $_POST['description'];
$image_url = $_POST['image_url'];

$query = "INSERT INTO projects (name, description, image_url) VALUES (?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('sss', $name, $description, $image_url);
$stmt->execute();

echo json_encode(['message' => 'Project proposed successfully']);
?>
