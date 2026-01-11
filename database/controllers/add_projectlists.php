<?php
//Database connection
require('../../database/connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $contractor_id = (int)$_POST['Contractor_ID'];
    $status_id = (int)$_POST['status_id'];
    $project_title = $_POST['Project_Title'];
    $project_description = $_POST['Project_Description'];
    $project_budget = (float)$_POST['Project_Budget'];
    $project_started_date = $_POST['Project_StartedDate'] ?? null;
    $project_end_date = $_POST['Project_EndDate'] ?? null;
    $location_id = (int)$_POST['location_ID'];

    // Prepare and Execute Query
    $sql = "INSERT INTO projects_table (Contractor_ID, status_id, Project_Title, Project_Description, Project_Budget, Project_StartedDate, Project_EndDate, location_ID) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iissdsi", $contractor_id, $status_id, $project_title, $project_description, $project_budget, $project_started_date, $project_end_date, $location_id);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Project added successfully",
            "project_id" => $conn->insert_id
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "error" => "Failed to add project: " . $stmt->error
        ]);
    }

    $stmt->close();
}
?>
