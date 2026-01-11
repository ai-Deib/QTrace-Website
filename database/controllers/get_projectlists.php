<?php
//Database connection
require('../../database/connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Prepare and Execute Query to fetch all project lists
    $sql = "SELECT * FROM projects_table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all rows
    if ($result->num_rows > 0) {
        $project_lists = [];
        while ($row = $result->fetch_assoc()) {
            $project_lists[] = $row;
        }
        echo json_encode($project_lists);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
}
?>