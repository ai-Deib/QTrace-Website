<?php
// Database connection
require('../connection/connection.php'); // Provides $conn (MySQLi)
require_once('audit_service.php');

// Initialize Audit Service
$audit = new AuditService($conn);

// Get contractor ID from URL
$contractor_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($contractor_id <= 0) {
    header("Location: /QTrace-Website/pages/admin/list_contractor.php?status=error");
    exit();
}

// 1. FETCH OLD DATA FIRST
// We get the current status so the audit log shows what changed
$stmtGet = $conn->prepare("SELECT Contractor_Status FROM contractor_table WHERE Contractor_Id = ?");
$stmtGet->bind_param("i", $contractor_id);
$stmtGet->execute();
$result = $stmtGet->get_result();
$oldData = $result->fetch_assoc();

if (!$oldData) {
    die("Contractor not found.");
}

// 2. PERFORM THE UPDATE
$stmt = $conn->prepare("UPDATE contractor_table SET Contractor_Status = 'inactive' WHERE Contractor_Id = ?");
$stmt->bind_param("i", $contractor_id);
$success = $stmt->execute();

if ($success) {
    // 3. LOG THE CHANGE
    // Capture who is doing this action from the session
    $admin_id = $_SESSION['user_ID'] ?? 0; 

    $audit->log(
        $admin_id, 
        'DEACTIVATE',      // Action
        'contractor',      // Resource Type
        $contractor_id,    // Resource ID
        $oldData,          // Old Values: e.g., {"Contractor_Status":"active"}
        ['Contractor_Status' => 'inactive'] // New Values
    );
}

$msg = urlencode("Contractor disabled successfully.");
header("Location: /QTrace-Website/pages/admin/list_contractor.php?status=danger&msg=$msg");
exit();
?>