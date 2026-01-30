<?php


require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';

$error = '';

if (is_logged_in()) {
    if (get_user_role() === 'admin') {
        header('Location: dashboard.php');
        exit;
    } else {
        // Logged in as student, redirect to student area
        header('Location: ../student/exam.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize_input($_POST['username'] ?? '');
    $password = sanitize_input($_POST['password'] ?? '');

    if (authenticate_user($username, $password)) {
        if (get_user_role() === 'admin') {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Access denied. Please use the Student login page.';
            logout();
        }
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - E-Exam System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" >
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <button type="submit" class="button primary">Login</button>
        </form>
        <p><a href="../index.php">Back to Home</a></p>
    </div>
</body>
</html>
