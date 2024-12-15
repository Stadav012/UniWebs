<?php
// Fetch project details by project_id
include '../db.php';
$project_id = $_GET['project_id'];
$query = "SELECT * FROM projects WHERE project_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $project_id);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

// Fetch team members for the project
$query_team = "SELECT users.username FROM project_team_members ptm
               JOIN users ON ptm.user_id = users.user_id
               WHERE ptm.project_id = ?";
$stmt_team = $conn->prepare($query_team);
$stmt_team->bind_param('i', $project_id);
$stmt_team->execute();
$result_team = $stmt_team->get_result();

$team_members = [];
while ($row = $result_team->fetch_assoc()) {
    $team_members[] = $row['username'];
}

$project['team_members'] = $team_members;

echo json_encode($project);
?>
