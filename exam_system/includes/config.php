<?php
// /DATA STOTE

// Start session for authentication
session_start();

// --- SIMULATED DATABASE CONNECTION ---
// In a real application, this would connect to a MySQL/PostgreSQL database.
// For this demonstration, we use a simple array to hold the data.
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'password');
define('DB_NAME', 'e_exam_db');

// --- USER ACCOUNTS ---
$users = [
   
   
    'student101' => [
        'username' => 'student101',
        'password' => 'pass123', // Insecure: plain text password
        'role' => 'student',
        'name' => 'Great John'
    ],
    'student102' => [
        'username' => 'student102',
        'password' => 'pass133', // Insecure: plain text password
        'role' => 'student',
        'name' => 'Adam Grace'
    ],
    'admin' => [
        'username' => 'admin',
        'password' => 'secureadminpass', // Insecure: plain text password
        'role' => 'admin',
        'name' => 'Network Admin'
    ]
];

// --- QUESTION BANK (The core of the client-side vulnerability) ---
// The correct answer is stored directly in the question array.
$question_bank = [
    1 => [
        'question' => 'What is the primary protocol used to secure web traffic?',
        'options' => [
            'A' => 'HTTP',
            'B' => 'FTP',
            'C' => 'HTTPS',
            'D' => 'SSH'
        ],
        'correct_answer' => 'C', // VULNERABILITY: Answer is here
        'course' => 'Networking Fundamentals'
    ],
    2 => [
        'question' => 'Which layer of the OSI model is responsible for logical addressing?',
        'options' => [
            'A' => 'Data Link Layer',
            'B' => 'Network Layer',
            'C' => 'Transport Layer',
            'D' => 'Application Layer'
        ],
        'correct_answer' => 'B', // VULNERABILITY: Answer is here
        'course' => 'Networking Fundamentals'
    ],
    3 => [
        'question' => 'What does "DNS" stand for?',
        'options' => [
            'A' => 'Data Network Service',
            'B' => 'Domain Name System',
            'C' => 'Digital Naming Server',
            'D' => 'Dynamic Network System'
        ],
        'correct_answer' => 'B', // VULNERABILITY: Answer is here
        'course' => 'Networking Fundamentals'
    ],
    4 => [
        'question' => 'Which command is used to check network connectivity?',
        'options' => [
            'A' => 'ipconfig',
            'B' => 'ping',
            'C' => 'netstat',
            'D' => 'tracert'
        ],
        'correct_answer' => 'B', // VULNERABILITY: Answer is here
        'course' => 'Networking Fundamentals'
    ],
    5 => [
        'question' => 'What is the default port for SSH?',
        'options' => [
            'A' => '21',
            'B' => '22',
            'C' => '23',
            'D' => '80'
        ],
        'correct_answer' => 'B', // VULNERABILITY: Answer is here
        'course' => 'Networking Fundamentals'
    ]
];

// --- SIMULATED EXAM RESULTS ---
// This would be a separate table in a real DB
$exam_results = [
    'student101' => [
        'score' => 4,
        'total' => 5,
        'date' => '2026-01-17',
        'status' => 'Passed'
    ]
];
?>
