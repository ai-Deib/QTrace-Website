<?php
// Database connection
require('../../database/connection/connection.php');

try {
    // 1. Collect filter values from GET request
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $actionFilter = isset($_GET['action']) ? trim($_GET['action']) : '';

    // 2. Base SQL Query
    $sql = "SELECT 
                a.audit_log_id, 
                a.user_id, 
                a.action, 
                a.resource_type, 
                a.resource_id, 
                a.old_values, 
                a.new_values, 
                a.created_at,
                u.user_firstName,
                u.user_lastName
            FROM audit_logs a
            LEFT JOIN user_table u ON a.user_id = u.user_ID";

    // 3. Build dynamic WHERE clauses
    $whereClauses = [];
    $params = [];
    $types = "";

    // If search is not empty, search by name or ID
    if ($search !== '') {
        $whereClauses[] = "(u.user_firstName LIKE ? OR u.user_lastName LIKE ? OR a.user_id LIKE ?)";
        $searchParam = "%$search%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $types .= "sss";
    }

    // If an action is selected
    if ($actionFilter !== '') {
        $whereClauses[] = "a.action = ?";
        $params[] = $actionFilter;
        $types .= "s";
    }

    // Attach WHERE clauses to SQL
    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(" AND ", $whereClauses);
    }

    // Add Ordering
    $sql .= " ORDER BY a.created_at DESC";

    // 4. Prepare and Execute
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        $audit_logs = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $audit_logs = [];
    }

} catch (Exception $e) {
    error_log("Audit List Error: " . $e->getMessage());
    $audit_logs = [];
}