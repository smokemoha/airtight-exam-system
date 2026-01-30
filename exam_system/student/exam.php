<?php


require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../includes/security.php';

require_login('student');

global $question_bank;

// The entire question bank, including answers, is passed to the client-side JavaScript.
// This is the CRITICAL VULNERABILITY that allows "Inspect Mode" cheating.
$exam_data_json = json_encode($question_bank);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In this insecure phase, we simulate client-side scoring.
    // The real scoring logic would be on the server.
    $score = 0;
    $total = count($question_bank);
    $answers = $_POST['answer'] ?? [];

    foreach ($question_bank as $id => $q) {
        if (isset($answers[$id]) && $answers[$id] === $q['correct_answer']) {
            $score++;
        }
    }

    // Store the result in session to display on result.php
    $_SESSION['exam_result'] = [
        'score' => $score,
        'total' => $total,
        'date' => date('Y-m-d H:i:s')
    ];

    // Simulate immediate marking and submission
    header('Location: result.php');
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
    <title>E-Exam - E-Exam System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['user']['name']; ?></h1>
        <h2>Networking Fundamentals Exam</h2>
        <p class="warning">**VULNERABILITY DEMO:** The answers for this exam are loaded into the page source code. Use your browser's "Inspect Element" feature to find the `exam_data` variable in the script tag below.</p>

        <form method="POST" id="exam-form">
            <?php foreach ($question_bank as $id => $q): ?>
                <div class="question-block">
                    <h3>Question <?php echo $id; ?>:</h3>
                    <p><?php echo $q['question']; ?></p>
                    <div class="options">
                        <?php foreach ($q['options'] as $key => $option): ?>
                            <label>
                                <input type="radio" name="answer[<?php echo $id; ?>]" value="<?php echo $key; ?>" required>
                                <?php echo $key; ?>. <?php echo $option; ?>
                            </label><br>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="button primary">Submit Exam</button>
        </form>
        <p><a href="logout.php" class="button secondary">Logout</a></p>
    </div>

    <script>
        // CRITICAL VULNERABILITY: The full exam data, including correct answers, is exposed here.
        const exam_data = <?php echo $exam_data_json; ?>;
        console.log("EXAM DATA (including answers):", exam_data);
        // A student can easily inspect this variable to find the correct_answer for each question.
    </script>
</body>
</html>
