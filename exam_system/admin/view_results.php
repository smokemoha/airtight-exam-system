<?php


require_once '../includes/config.php';
require_once '../includes/auth.php';

require_login('admin');

global $exam_results;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results - E-Exam System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>View All Exam Results</h1>
        <p>This page shows all student exam scores and allows for editing (simulated).</p>

        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Score</th>
                    <th>Total</th>
                    <th>Percentage</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exam_results as $id => $result): ?>
                <tr>
                    <td><?php echo $id; ?></td>
                    <td><?php echo $result['score']; ?></td>
                    <td><?php echo $result['total']; ?></td>
                    <td><?php echo round(($result['score'] / $result['total']) * 100, 2); ?>%</td>
                    <td><?php echo $result['date']; ?></td>
                    <td><a href="#">Edit Score</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="dashboard.php" class="button secondary">Back to Dashboard</a></p>
    </div>
</body>
</html>
