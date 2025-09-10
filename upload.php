<?php
// Folder where files will be stored
$target_dir = "uploads/";

// Create folder if not exists
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $file_name = basename($_FILES['file']['name']);
        $target_file = $target_dir . $file_name;

        // Allowed file types
        $allowed_ext = ['jpg','jpeg','png','gif','pdf','txt','mp4','mp3'];
        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed_ext)) {
            die("❌ File type not allowed! Allowed: " . implode(', ', $allowed_ext));
        }

        // Size limit (10MB)
        if ($_FILES['file']['size'] > 10 * 1024 * 1024) {
            die("❌ File too large. Max 10MB");
        }

        // Move file to uploads folder
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
            echo "✅ File uploaded successfully!<br>";
            echo "<a href='upload.html'>Upload another file</a><br>";
            echo "<a href='admin-login.html'>Admin Panel</a>";
        } else {
            echo "❌ File upload failed!";
        }
    } else {
        echo "❌ No file selected!";
    }
} else {
    echo "❌ Invalid request!";
}
?>
