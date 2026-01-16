<?php
require('../config/disabled_records.php');

// Get contractor ID from URL
$contractor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($contractor_id <= 0) {
    header("Location: /QTrace-Website/pages/admin/list_contractor.php?status=error");
    exit();
}

// Disable contractor using PHP config
disableContractor($contractor_id);
header("Location: /QTrace-Website/pages/admin/list_contractor.php?status=disabled");
exit();
?>
