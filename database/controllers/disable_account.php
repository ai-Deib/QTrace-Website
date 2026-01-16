<?php
require('../config/disabled_records.php');

// Get user ID from URL
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_id <= 0) {
    header("Location: /QTrace-Website/pages/admin/list_account.php?status=error");
    exit();
}

// Disable user using PHP config
disableUser($user_id);
header("Location: /QTrace-Website/pages/admin/list_account.php?status=disabled");
exit();
?>
