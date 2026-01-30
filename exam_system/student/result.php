<?php


require_once '../includes/config.php';
require_once '../includes/auth.php';

require_login('student');

$result = $_SESSION['exam_result'] ?? null;

if (!$result) {
    header('Location: exam.php');
    exit;
}

// Clear the result from session after displaying
unset($_SESSION['exam_result']);

$percentage = round(($result['score'] / $result['total']) * 100, 2);
$status = $percentage >= 50 ? 'Passed' : 'Failed';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exam Result - E-Exam System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h1>Exam Result for <?php echo $_SESSION['user']['name']; ?></h1>
        <div class="result-summary">
            <p><strong>Date of Exam:</strong> <?php echo $result['date']; ?></p>
            <p><strong>Course:</strong> Networking Fundamentals</p>
            <p><strong>Score:</strong> <?php echo $result['score']; ?> / <?php echo $result['total']; ?></p>
            <p><strong>Percentage:</strong> <?php echo $percentage; ?>%</p>
            <p class="status-<?php echo strtolower($status); ?>"><strong>Status:</strong> <?php echo $status; ?></p>
        </div>
        <p><a href="exam.php" class="button primary">Take Another Exam</a></p>
        <p><a href="logout.php" class="button secondary">Logout</a></p>
    </div>
</body>
</html>
