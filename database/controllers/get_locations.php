<?php
// Database connection
require('../../database/connection/connection.php');

// Set content type to JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    try {
        // Fetch all locations with coordinates for location picker
        $sql = "SELECT 
                    location_id as id,
                    address,
                    barangay,
                    district_number,
                    latitude as lat,
                    longitude as lng
                FROM locations_table
                WHERE latitude IS NOT NULL 
                AND longitude IS NOT NULL
                ORDER BY barangay ASC";

        $result = $conn->query($sql);
        $locations = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row['position'] = [
                    'lat' => floatval($row['lat']),
                    'lng' => floatval($row['lng'])
                ];
                $locations[] = $row;
            }
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'data' => $locations,
            'count' => count($locations)
        ]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Failed to fetch locations',
            'details' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
