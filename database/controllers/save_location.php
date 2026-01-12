<?php
// Database connection
require('../../database/connection/connection.php');

// Set content type to JSON
header('Content-Type: application/json');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validate required fields
        if (empty($_POST['latitude']) || empty($_POST['longitude']) || 
            empty($_POST['address']) || empty($_POST['barangay']) || 
            empty($_POST['district_number'])) {
            throw new Exception('All fields are required');
        }

        $latitude = floatval($_POST['latitude']);
        $longitude = floatval($_POST['longitude']);
        $address = trim($_POST['address']);
        $barangay = trim($_POST['barangay']);
        $district_number = intval($_POST['district_number']);

        // Validate coordinates are within Quezon City bounds
        if ($latitude < 14.620 || $latitude > 14.760 || 
            $longitude < 120.980 || $longitude > 121.120) {
            throw new Exception('Coordinates are outside Quezon City bounds');
        }

        // Validate district number
        if ($district_number < 1 || $district_number > 6) {
            throw new Exception('District number must be between 1 and 6');
        }

        // Insert new location into database
        $sql = "INSERT INTO locations_table (address, barangay, district_number, latitude, longitude) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssidd", $address, $barangay, $district_number, $latitude, $longitude);
        
        if ($stmt->execute()) {
            $location_id = $conn->insert_id;
            
            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Location saved successfully',
                'location_id' => $location_id,
                'data' => [
                    'id' => $location_id,
                    'address' => $address,
                    'barangay' => $barangay,
                    'district_number' => $district_number,
                    'latitude' => $latitude,
                    'longitude' => $longitude
                ]
            ]);
        } else {
            throw new Exception('Failed to save location to database');
        }
        
        $stmt->close();
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>
