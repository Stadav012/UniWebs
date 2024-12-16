<?php
include_once 'db.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);


if ($conn) {
    echo "Database connection successful!";
} else {
    echo "Database connection failed: " . mysqli_connect_error();
}
?>