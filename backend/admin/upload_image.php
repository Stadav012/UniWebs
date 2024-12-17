<?php
// upload_project_image.php
include 'db_connection.php';

// Check if a file is uploaded
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $image = $_FILES['image'];

    // Set the upload directory
    $upload_dir = '../../../uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Generate a unique filename
    $image_name = time() . '_' . basename($image['name']);
    $image_path = $upload_dir . $image_name;

    // Move the uploaded file
    if (move_uploaded_file($image['tmp_name'], $image_path)) {
        // Return the URL of the uploaded image
        $image_url = '../../../uploads/' . $image_name;
        echo json_encode(['image_url' => $image_url]);
    } else {
        echo json_encode(['error' => 'Failed to upload image']);
    }
} else {
    echo json_encode(['error' => 'No image uploaded']);
}
?>
