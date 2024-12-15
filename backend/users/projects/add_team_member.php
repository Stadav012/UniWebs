<?php
// Add user as team member to a project
include '../db.php';
$project_id = $_POST['project_id'];
$user_id = $_POST['user_id'];

$query = "INSERT INTO project_team_members (project_id, user_id) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param('ii', $project_id, $user_id);
$stmt->execute();

echo json_encode(['message' => 'Team member added successfully']);
?>
