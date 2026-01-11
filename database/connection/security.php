<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check_session_security() {
    $timeout = 10; // Change to 1800 for 30 minutes in production

    if (!isset($_SESSION['user_ID'])) {
        header("Location: /QTrace-Website/dashboard");
        exit();
    }

    // Check if the "last activity" exists
    if (isset($_SESSION['last_activity'])) {
        $duration = time() - $_SESSION['last_activity'];
        
        if ($duration > $timeout) {
            session_unset();
            session_destroy();
            header("Location: /QTrace-Website/login?message=session_expired");
            exit();
        }
    }

    // IMPORTANT: Update timestamp AFTER the check
    $_SESSION['last_activity'] = time();
}
?>