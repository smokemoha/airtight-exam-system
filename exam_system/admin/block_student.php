<?php


require_once '../includes/config.php';
require_once '../includes/auth.php';

require_login('admin');

global $users;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Block Student - E-Exam System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Block Student Access</h1>
        <p>This page simulates the ability to restrict a student from taking an exam.</p>
        <p class="warning">**NOTE:** Functionality is a placeholder. In a real system, this would update a database field (e.g., <code>is_restricted</code>) for the student.</p>

        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $username => $user): ?>
                <?php if ($user['role'] === 'student'): ?>
                <tr>
                    <td><?php echo $username; ?></td>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['role']; ?></td>
                    <td><a href="#">Block/Unblock</a></td>
                </tr>
                <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="dashboard.php" class="button secondary">Back to Dashboard</a></p>
    </div>
</body>
</html>
