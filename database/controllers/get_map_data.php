<?php
// Database connection
require('../../database/connection/connection.php');

// Set content type to JSON
header('Content-Type: application/json');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        // Fetch projects with location data for map
        $sql = "SELECT 
                    pt.Project_Id as id,
                    pt.Project_Title as name,
                    pt.Project_Description as description,
                    pt.Project_Budget as budget,
                    pt.Project_StartedDate as start_date,
                    pt.Project_EndDate as end_date,
                    ps.status_name as status,
                    lt.address as area,
                    lt.barangay,
                    lt.district_number,
                    lt.latitude as lat,
                    lt.longitude as lng,
                    ct.Contractor_Name as contractor,
                    COALESCE(pcat.Category_Name, 'General') as category
                FROM projects_table pt
                LEFT JOIN locations_table lt ON pt.location_ID = lt.location_id
                LEFT JOIN contractor_table ct ON pt.Contractor_ID = ct.Contractor_Id
                LEFT JOIN project_categories pcat ON pt.Project_Id = pcat.Project_ID
                LEFT JOIN project_status ps ON pt.status_id = ps.status_id
                WHERE ps.status_name IS NOT NULL
                AND lt.latitude IS NOT NULL 
                AND lt.longitude IS NOT NULL
                ORDER BY pt.Project_Id DESC";

        // Apply filters if provided
        if (!empty($_GET['status'])) {
            $sql = str_replace(
                "WHERE ps.status_name IS NOT NULL",
                "WHERE ps.status_name = '" . $conn->real_escape_string($_GET['status']) . "'",
                $sql
            );
        }

        if (!empty($_GET['category'])) {
            $sql = str_replace(
                "ORDER BY pt.Project_Id DESC",
                "AND pcat.Category_Name = '" . $conn->real_escape_string($_GET['category']) . "' ORDER BY pt.Project_Id DESC",
                $sql
            );
        }

        $result = $conn->query($sql);
        $projects = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Convert budget to formatted string with peso symbol
                $numericBudget = floatval($row['budget']);
                $row['budget_display'] = '₱' . number_format($numericBudget / 1_000_000, 1) . 'M';
                
                // Create position object for map marker
                $row['position'] = [
                    'lat' => floatval($row['lat']),
                    'lng' => floatval($row['lng'])
                ];
                
                $projects[] = $row;
            }
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'data' => $projects,
            'count' => count($projects)
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Failed to fetch map data',
            'details' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
