<?php
require('../../database/connection/connection.php');

// 1. Get Filter/Search Inputs from GET request
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
$status = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';
$contractor_id = isset($_GET['contractor_id']) ? (int)$_GET['contractor_id'] : 0;

// 2. Build the Relational Query
// We join projects_table (pt) with projectdetails_table (pd) for info 
// and contractor_table (c) for the contractor name.
$sql = "SELECT 
            pt.Project_ID, 
            pt.Project_Status, 
            pd.ProjectDetails_Title, 
            pd.ProjectDetails_Description, 
            pd.ProjectDetails_Budget, 
            pd.ProjectDetails_StartedDate, 
            pd.ProjectDetails_EndDate,
            c.Contractor_Name
        FROM projects_table pt
        INNER JOIN projectdetails_table pd ON pt.Project_ID = pd.Project_ID
        LEFT JOIN contractor_table c ON pt.Contractor_ID = c.Contractor_Id
        WHERE 1=1";

// 3. Apply Filters based on UI (Search by title/desc, Status dropdown, Contractor dropdown)
if (!empty($search)) {
    $sql .= " AND (pd.ProjectDetails_Title LIKE '%$search%' OR pd.ProjectDetails_Description LIKE '%$search%')";
}


if (!empty($status) && $status !== 'All Status') {
    $sql .= " AND pt.Project_Status = '$status'";
}

if ($contractor_id > 0) {
    $sql .= " AND pt.Contractor_ID = $contractor_id";
}

// 4. Order and Execute
$sql .= " ORDER BY pt.Project_ID DESC";
$result = $conn->query($sql);
?>