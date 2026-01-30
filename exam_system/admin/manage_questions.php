<?php


require_once '../includes/config.php';
require_once '../includes/auth.php';

require_login('admin');

global $question_bank;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions - E-Exam System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Manage Questions</h1>
        <p>This page allows the admin to view and edit the question bank.</p>
        <p class="warning">**NOTE:** In this simulated environment, the question bank is stored in <code>/includes/config.php</code>. Editing functionality is a placeholder.</p>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course</th>
                    <th>Question</th>
                    <th>Correct Answer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($question_bank as $id => $q): ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $q['course']; ?></td>
                    <td><?php echo substr($q['question'], 0, 50) . '...'; ?></td>
                    <td><?php echo $q['correct_answer']; ?></td>
                    <td><a href="#">Edit</a> | <a href="#">Delete</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="dashboard.php" class="button secondary">Back to Dashboard</a></p>
    </div>
</body>
</html>
