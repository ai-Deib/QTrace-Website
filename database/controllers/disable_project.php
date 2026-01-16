<?php
require('../config/disabled_records.php');

// Get project ID from URL
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($project_id <= 0) {
    header("Location: /QTrace-Website/pages/admin/list_project.php?status=error");
    exit();
}

// Disable project using PHP config
disableProject($project_id);
header("Location: /QTrace-Website/pages/admin/list_project.php?status=disabled");
exit();
?>
