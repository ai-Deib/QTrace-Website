<?php
require('../../database/connection/connection.php');

// Fetch articles/reports with their project details
$sql = "SELECT 
            r.report_ID,
            r.Project_ID, 
            r.report_type,
            r.report_description,
            r.report_evidencesPhoto_URL,
            r.report_status,
            r.report_CreatedAt,
            pt.Project_Status, 
            pd.ProjectDetails_Title, 
            pd.ProjectDetails_Description, 
            pd.ProjectDetails_Budget, 
            pd.ProjectDetails_StartedDate, 
            pd.ProjectDetails_EndDate,
            pd.ProjectDetails_Barangay,
            c.Contractor_Name,
            CONCAT(u.user_firstName, ' ', u.user_lastName) as author_name
        FROM report_table r
        INNER JOIN projects_table pt ON r.Project_ID = pt.Project_ID
        INNER JOIN projectdetails_table pd ON pt.Project_ID = pd.Project_ID
        LEFT JOIN contractor_table c ON pt.Contractor_ID = c.Contractor_Id
        LEFT JOIN user_table u ON r.user_ID = u.user_ID
        WHERE pt.Project_Status != 'Disabled'
        ORDER BY r.report_CreatedAt DESC, r.report_ID DESC";

$projects_result = $conn->query($sql);

// Helper function to format budget
function formatBudget($amount) {
    return '₱' . number_format($amount, 2);
}
?>
