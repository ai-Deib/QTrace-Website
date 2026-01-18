<?php
// Database connection
require('../connection/connection.php'); // Provides $conn (MySQLi)
require_once('audit_service.php');

// Initialize Audit Service
$audit = new AuditService($conn);

// Get project ID from URL
$project_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($project_id <= 0) {
    header("Location: /QTrace-Website/pages/admin/list_project.php?status=error");
    exit();
}

// 1. FETCH OLD DATA FIRST
// Captures the current status before changing it to 'inactive'
$stmtGet = $conn->prepare("SELECT Project_Status FROM projects_table WHERE Project_ID = ?");
$stmtGet->bind_param("i", $project_id);
$stmtGet->execute();
$result = $stmtGet->get_result();
$oldData = $result->fetch_assoc();

if (!$oldData) {
    die("Project not found.");
}

// 2. PERFORM THE UPDATE
$stmt = $conn->prepare("UPDATE projects_table SET Project_Status = 'inactive' WHERE Project_ID = ?");
$stmt->bind_param("i", $project_id);
$success = $stmt->execute();

if ($success) {
    // 3. LOG THE CHANGE
    $admin_id = $_SESSION['user_ID'] ?? 0; 

    $audit->log(
        $admin_id, 
        'DEACTIVATE',      // Action name
        'projects',        // Resource type (matches your list_audit columns)
        $project_id,       // Specific ID of the project
        $oldData,          // Old values: {"Project_Status": "active"}
        ['Project_Status' => 'inactive'] // New values
    );
}

$msg = urlencode("Project disabled successfully.");
header("Location: /QTrace-Website/pages/admin/list_project.php?status=danger&msg=$msg");
exit();
?>