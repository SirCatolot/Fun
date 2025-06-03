<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['filename'])) {
    $uploadDir = 'uploads/';
    $targetFile = $uploadDir . 'current_file.' . pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);
    
    // Create uploads directory if it doesn't exist
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Check if file was uploaded without errors
    if ($_FILES['filename']['error'] === UPLOAD_ERR_OK) {
        // Remove any existing file in the directory (optional - for complete replacement)
        $existingFiles = glob($uploadDir . 'current_file.*');
        foreach ($existingFiles as $file) {
            unlink($file);
        }
        
        // Move uploaded file to target location
        if (move_uploaded_file($_FILES['filename']['tmp_name'], $targetFile)) {
            echo "File uploaded and replaced successfully.";
        } else {
            echo "Error moving uploaded file.";
        }
    } else {
        echo "Upload error: " . $_FILES['filename']['error'];
    }
} else {
    echo "No file uploaded.";
}
?>