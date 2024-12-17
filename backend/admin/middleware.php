<?php
// middleware.php
session_start();

function isAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        http_response_code(403);
        echo json_encode(["error" => "Forbidden. Admin access only."]);
        exit();
    }
}
?>
