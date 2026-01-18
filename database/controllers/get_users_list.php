<?php
require('../../database/connection/connection.php');

// 1. Capture the search input from the GET request
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// 2. Build the base query
$query = "SELECT * FROM user_table";

// 3. Add filter logic if search is not empty
if (!empty($search)) {
    // We check all three columns for a partial match
    $query .= " WHERE user_lastName LIKE ? 
                OR user_firstName LIKE ? 
                OR QC_ID_Number LIKE ?";
}

// 4. Add the ordering at the end
$query .= " ORDER BY user_status ASC, user_ID ASC";

// 5. Prepare and execute the statement
$stmt = $conn->prepare($query);

if (!empty($search)) {
    $searchTerm = "%$search%";
    // We bind the same search term to all three '?' placeholders
    $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();
?>