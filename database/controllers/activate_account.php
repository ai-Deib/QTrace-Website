<?php
// Database connection
require('../connection/connection.php');

// Get user ID from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_id <= 0) {
    header("Location: /QTrace-Website/pages/admin/list_account.php?status=error");
    exit();
}

// Disable user using PHP config
$stmt = $conn->prepare("UPDATE user_table SET user_status = 'active' WHERE user_ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$msg = urlencode("Account activated successfully.");
header("Location: /QTrace-Website/pages/admin/list_account.php?status=success&msg=$msg");
exit();
?>
