<?php
// Handle CORS headers
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    http_response_code(200); // Respond OK to OPTIONS requests
    exit();
}

// Include CORS headers for other methods
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "stanley.ndlovu";
$password = "Tulanistark0!";
$dbname = "webtech_fall2024_stanley_ndlovu";

$conn = mysqli_connect($servername,$username,$password,$dbname) or die ("could not connect database");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>