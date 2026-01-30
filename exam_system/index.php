<?php


require_once 'includes/config.php';
require_once 'includes/auth.php';

if (is_logged_in()) {
    $role = get_user_role();
    if ($role === 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: student/exam.php');
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script>
    // This is a speed bump, not a security measure.
    document.addEventListener('contextmenu', event => event.preventDefault());
    document.onkeydown = function(e) {
        // Disable F12
        if(e.keyCode == 123) {
            return false;
        }
        // Disable Ctrl+Shift+I
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
            return false;
        }
        // Disable Ctrl+Shift+J
        if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
            return false;
        }
        // Disable Ctrl+U (View Source)
        if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
            return false;
        }
    }
</script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Exam System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome to the E-Exam System</h1>
        <h2>Please select your role to log in:</h2>
        <div class="role-links">
            <a href="student/login.php" class="button primary">Student Login</a>
            <a href="admin/index.php" class="button secondary">Admin Login</a>
        </div>
    </div>
</body>
</html>
