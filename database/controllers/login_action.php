<?php
session_start(); // Always start session at the very top
require('../connection/connection.php');

// If already logged in, skip login page
if (isset($_SESSION['user_id'])) {
    header("Location: /QTrace-Website/dashboard");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // FIX: Ensure these keys match exactly the 'name' attribute in your HTML <input> tags
    $user = isset($_POST['QC_ID_Number']) ? trim($_POST['QC_ID_Number']) : '';
    $pass = isset($_POST['user_Password']) ? $_POST['user_Password'] : '';

    if (empty($user) || empty($pass)) {
        header("Location: /QTrace-Website/login?error=empty_fields");
        exit();
    }

    // FIX: Check if $pdo exists. If your connection file uses $conn, change $pdo to $conn below.
    if (!isset($pdo)) {
        die("Database connection variable not found. Check connection.php");
    }

    try {
        // 1. Prepare statement
        $stmt = $pdo->prepare("SELECT user_ID, QC_ID_Number, user_Password FROM user_table WHERE QC_ID_Number = ?");
        $stmt->execute([$user]);
        $account = $stmt->fetch();

        // 2. Verify password
        if ($account && password_verify($pass, $account['user_Password'])) {
            
            // 3. Security: Prevent Session Fixation
            session_regenerate_id(true);

            $_SESSION['user_id'] = $account['user_ID'];
            $_SESSION['username'] = $account['QC_ID_Number'];
            
            // 4. Set initial activity for the 10-second timer
            $_SESSION['last_activity'] = time();

            header("Location: /QTrace-Website/dashboard");
            exit();
        } else {
            header("Location: /QTrace-Website/login?error=invalid_credentials");
            exit();
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
?>