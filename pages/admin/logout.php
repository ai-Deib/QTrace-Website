<?php
/**
 * logout.php
 * Fully terminates the user session and cleans up browser cookies.
 */

// 1. Initialize the session to gain access to it
session_start();

// 2. Clear all session variables from memory
$_SESSION = array();

// 3. Destroy the session cookie in the browser
// This is critical. If the cookie persists, the session ID could potentially be reused.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000, // Set expiration to 11+ hours ago
        $params["path"], 
        $params["domain"], 
        $params["secure"], 
        $params["httponly"]
    );
}

// 4. Destroy the session data on the server
session_destroy();

// 5. Close the session file to prevent any further writes
session_write_close();

// 6. Redirect to the login page
// We add a 'logged_out' parameter to show a success message if desired
header("Location: /QTrace-Website/login?message=logged_out");
exit();
?>