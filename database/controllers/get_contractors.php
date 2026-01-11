<?php
//Database connection
require('../../database/connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Prepare and Execute Query to fetch all contractors
    $sql = "SELECT * FROM contractor_table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all rows
    if ($result->num_rows > 0) {
        $contractors = [];
        while ($row = $result->fetch_assoc()) {
            $contractors[] = $row;
        }
        echo json_encode($contractors);
    } else {
        echo json_encode([]);
    }

    $stmt->close();
}
?>
