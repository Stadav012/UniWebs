<?php

// logout.php
session_start();
session_unset();
session_destroy();

// Delete session cookie if set
if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/', '', false, true); // Expire the cookie
}

echo json_encode(["message" => "Logged out successfully"]);


?>