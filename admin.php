<?php
session_start();

// --- CHANGE THESE TO YOUR OWN ADMIN USERNAME AND PASSWORD ---
$admin_username = "admin";
$admin_password = "12345";
// -----------------------------------------------------------

// Handle login form
if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] === $admin_username && $_POST['password'] === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        die("❌ Invalid username or password. <a href='admin-login.html'>Try again</a>");
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin-login.html");
    exit();
}

// Check if admin logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin-login.html");
    exit();
}

// If logged in, display all uploaded files
$dir = "uploads/";
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
$files = array_diff(scandir($dir), array('.', '..'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel – Uploaded Files</title>
  <style>
    body {font-family: Arial, sans-serif; margin: 20px;}
    .file-list {display: flex; flex-wrap: wrap; gap: 15px;}
    .file-item {width: 200px; border: 1px solid #ccc; padding: 10px; text-align: center;}
    img, video, audio {max-width: 100%; height: auto;}
    a {word-wrap: break-word;}
    .logout {float: right;}
  </style>
</head>
<body>
  <h2>Admin Panel – Uploaded Files</h2>
  <a class="logout" href="admin.php?logout=true">Logout</a>
  <div class="file-list">
    <?php foreach ($files as $file): 
      $path = $dir . $file;
      $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    ?>
      <div class="file-item">
        <?php if (in_array($ext, ['jpg','jpeg','png','gif'])): ?>
          <img src="<?php echo $path; ?>" alt="<?php echo $file; ?>">
        <?php elseif (in_array($ext, ['mp4'])): ?>
          <video controls>
            <source src="<?php echo $path; ?>" type="video/mp4">
          </video>
        <?php elseif (in_array($ext, ['mp3'])): ?>
          <audio controls>
            <source src="<?php echo $path; ?>" type="audio/mpeg">
          </audio>
        <?php else: ?>
          <a href="<?php echo $path; ?>" target="_blank"><?php echo $file; ?></a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
  <br><a href="upload.html">Go to Upload Page</a>
</body>
</html>
