<?php

// include CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);



// db.php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "uniwebs";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>