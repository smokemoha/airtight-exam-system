<?php
// /GATEKEEPER

require_once 'config.php';

function authenticate_user($username, $password) {
    global $users;
    if (isset($users[$username]) && $users[$username]['password'] === $password) {
        $_SESSION['user'] = $users[$username];
        return true;
    }
    return false;
}

function is_logged_in() {
    return isset($_SESSION['user']);
}

function get_user_role() {
    return is_logged_in() ? $_SESSION['user']['role'] : null;
}

function require_login($role = null) {
    if (!is_logged_in()) {
        header('Location: /student/login.php');
        exit;
    }
    if ($role && get_user_role() !== $role) {
        // Simple unauthorized redirect
        header('Location: /');
        exit;
    }
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: /');
    exit;
}
?>
