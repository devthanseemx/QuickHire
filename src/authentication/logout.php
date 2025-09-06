<?php
session_start();
$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy();

// --- THE IMPORTANT PART ---
session_start(); // Start a new session

$_SESSION['flash_message'] = [
    'type' => 'success',
    'message' => 'You have been logged out.',
    'description' => 'Please log in again to continue.'
];

header("Location: login.php"); // Temporarily disabled
exit; // Temporarily disabled
