<?php
// Database connection
require('../connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture project_id
    $project_id = (int)$_POST['Project_ID'];
    
    if ($project_id <= 0) {
        die("Invalid project ID.");
    }

    // 1. Capture Data from "Project Information" & "Location"
    $contractor_id   = (int)$_POST['Contractor_ID'];
    $project_status  = $conn->real_escape_string($_POST['Project_Status']);
    $project_lng     = $conn->real_escape_string($_POST['lng']);
    $project_lat     = $conn->real_escape_string($_POST['lat']);

    // 2. Capture Data from "Budget & Timeline"
    $project_title       = $conn->real_escape_string($_POST['Project_Title']);
    $project_description = $conn->real_escape_string($_POST['Project_Description']);
    $project_budget      = (float)$_POST['Project_Budget'];
    $street              = $conn->real_escape_string($_POST['street']);
    $barangay            = $conn->real_escape_string($_POST['barangay']);
    $zip_code            = $conn->real_escape_string($_POST['zip_code']);
    $started_date        = $_POST['Project_StartedDate'];
    $end_date            = $_POST['Project_EndDate'];
    $project_category    = $conn->real_escape_string($_POST['Project_Category']);

    // Begin Transaction
    $conn->begin_transaction();

    try {
        // Update projects_table ---
        $sql1 = "UPDATE projects_table SET 
                    Contractor_ID = ?, 
                    Project_Status = ?, 
                    Project_Lng = ?, 
                    Project_Lat = ?,
                    Project_Category = ?
                WHERE Project_ID = ?";
        
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("issssi", $contractor_id, $project_status, $project_lng, $project_lat, $project_category, $project_id);
        $stmt1->execute();

        //Update projectdetails_table ---
        $sql2 = "UPDATE projectdetails_table SET 
                    ProjectDetails_Title = ?, 
                    ProjectDetails_Description = ?, 
                    ProjectDetails_Budget = ?, 
                    ProjectDetails_Street = ?, 
                    ProjectDetails_Barangay = ?, 
                    ProjectDetails_ZIP_Code = ?, 
                    ProjectDetails_StartedDate = ?, 
                    ProjectDetails_EndDate = ?
                WHERE Project_ID = ?";
        
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("ssdsssssi", 
            $project_title, $project_description, 
            $project_budget, $street, $barangay, $zip_code, 
            $started_date, $end_date,
            $project_id
        );
        $stmt2->execute();

        //STEP 3: Handle New Legal Documents (projectsdocument_table) ---
        if (!empty($_FILES['document_files']['name'][0])) {
            $docDir = $_SERVER['DOCUMENT_ROOT'] . "/QTrace-Website/uploads/projects/documents/";
            if (!is_dir($docDir)) mkdir($docDir, 0777, true);

            $stmtDoc = $conn->prepare("INSERT INTO projectsdocument_table (
                                        Project_ID, 
                                        ProjectDocument_FileLocation, 
                                        ProjectDocument_Type
                                        ) VALUES (?, ?, ?)");

            foreach ($_FILES['document_files']['name'] as $key => $val) {
                if ($_FILES['document_files']['error'][$key] == 0 && !empty($_POST['document_names'][$key])) {
                    $docName = $_POST['document_names'][$key];
                    $tmpPath = $_FILES['document_files']['tmp_name'][$key];
                    $ext     = pathinfo($val, PATHINFO_EXTENSION);
                    
                    // Generate unique filename to prevent overwriting
                    $filename = "DOC_" . $project_id . "_" . time() . "_" . $key . "." . $ext;
                    $serverPath = $docDir . $filename;
                    $webPath = "/QTrace-Website/uploads/projects/documents/" . $filename;

                    if (move_uploaded_file($tmpPath, $serverPath)) {
                        $stmtDoc->bind_param("iss", $project_id, $webPath, $docName);
                        $stmtDoc->execute();
                    }
                }
            }
        }

        //STEP 4: Handle New Milestone Gallery (projectmilestone_table) ---
        if (!empty($_FILES['img_files']['name'][0])) {
            $imgDir = $_SERVER['DOCUMENT_ROOT'] . "/QTrace-Website/uploads/projects/milestones/";
            if (!is_dir($imgDir)) mkdir($imgDir, 0777, true);

            $stmtMilestone = $conn->prepare("INSERT INTO projectmilestone_table (
                                                Project_ID, 
                                                projectMilestone_Image_Path, 
                                                projectMilestone_Phase
                                                ) VALUES (?, ?, ?)");

            foreach ($_FILES['img_files']['name'] as $key => $val) {
                if ($_FILES['img_files']['error'][$key] == 0 && !empty($_POST['img_types'][$key])) {
                    $phase   = $_POST['img_types'][$key];
                    $tmpPath = $_FILES['img_files']['tmp_name'][$key];
                    $ext     = pathinfo($val, PATHINFO_EXTENSION);
                    
                    $filename = "IMG_" . $project_id . "_" . time() . "_" . $key . "." . $ext;
                    $serverPath = $imgDir . $filename;
                    $webPath = "/QTrace-Website/uploads/projects/milestones/" . $filename;

                    if (move_uploaded_file($tmpPath, $serverPath)) {
                        $stmtMilestone->bind_param("iss", $project_id, $webPath, $phase);
                        $stmtMilestone->execute();
                    }
                }
            }
        }

        // Commit all changes if everything is successful
        $conn->commit();
        header("Location: /QTrace-Website/pages/admin/view_project.php?id=" . $project_id . "&status=updated");
        exit();

    } catch (Exception $e) {
        // Rollback transaction if any error occurs to prevent partial data
        $conn->rollback();
        die("Error processing request: " . $e->getMessage());
    }
}
?>
