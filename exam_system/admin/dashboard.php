<?php


require_once '../includes/config.php';
require_once '../includes/auth.php';

require_login('admin');

global $question_bank, $exam_results;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - E-Exam System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['user']['name']; ?>. You have full administrative access.</p>

        <div class="admin-menu">
            <a href="manage_questions.php" class="button primary">Manage Questions (<?php echo count($question_bank); ?>)</a>
            <a href="view_results.php" class="button primary">View All Results (<?php echo count($exam_results); ?>)</a>
            <a href="block_student.php" class="button primary">Block Student Access</a>
            <a href="../student/logout.php" class="button secondary">Logout</a>
        </div>

        <h2>System Overview</h2>
        <p>This is a simulated system. All data is stored in <code>/includes/config.php</code>.</p>
        
        <h3>Latest Exam Results (Simulated)</h3>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Score</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exam_results as $id => $result): ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $result['score']; ?></td>
                    <td><?php echo $result['total']; ?></td>
                    <td><?php echo $result['date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
