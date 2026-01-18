<?php
session_start();
// Database connection
require('../connection/connection.php'); // This provides $conn (MySQLi)
require_once ('audit_service.php');

// Since your connection.php uses $conn, we pass $conn to the service
$audit = new AuditService($conn);

// Get user ID from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_id <= 0) {
    header("Location: /QTrace-Website/pages/admin/list_account.php?status=error");
    exit();
}

// 1. FETCH OLD DATA FIRST (Using MySQLi)
$stmtGet = $conn->prepare("SELECT user_status FROM user_table WHERE user_ID = ?");
$stmtGet->bind_param("i", $user_id);
$stmtGet->execute();
$result = $stmtGet->get_result();
$oldData = $result->fetch_assoc();

if (!$oldData) {
    die("User not found.");
}

// 2. PERFORM THE UPDATE
$stmt = $conn->prepare("UPDATE user_table SET user_status = 'inactive' WHERE user_ID = ?");
$stmt->bind_param("i", $user_id);
$success = $stmt->execute();

if ($success) {
    // 3. LOG THE CHANGE
    // Make sure your session key is exactly 'user_ID' or 'user_id' as per your login script
    $admin_id = $_SESSION['user_ID'] ?? 0; 

    $audit->log(
        $admin_id, 
        'DEACTIVATE', 
        'users', 
        $user_id, 
        $oldData,                      // Stored as: {"user_status":"active"}
        ['user_status' => 'inactive']  // Stored as: {"user_status":"inactive"}
    );
}

$msg = urlencode("Account disabled successfully.");
header("Location: /QTrace-Website/pages/admin/list_account.php?status=danger&msg=$msg");
exit();
?>