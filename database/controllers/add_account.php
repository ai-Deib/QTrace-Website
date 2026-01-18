<?php
session_start();
// Database connection
require('../connection/connection.php');
require_once('audit_service.php');

$audit = new AuditService($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture Information
    $first_name     = $_POST['first_name'];
    $middle_name    = $_POST['middle_name'];
    $last_name      = $_POST['last_name'];
    $sex            = $_POST['sex'];
    $birth_date     = $_POST['birth_date'];
    $role           = $_POST['role'];
    $contact_number = $_POST['contact_number'];
    $email          = $_POST['email'];
    $main_address   = $_POST['main_address'];
    
    $raw_password   = $_POST['defaultpassword'];
    $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);

    // 3. Generate 11-digit Unique QC ID
    $isUnique = false;
    $qc_id_number = "";

    while (!$isUnique) {
        $qc_id_number = (string)random_int(10000000000, 99999999999);
        $checkStmt = $conn->prepare("SELECT QC_ID_Number FROM user_table WHERE QC_ID_Number = ? LIMIT 1");
        $checkStmt->bind_param("s", $qc_id_number);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows == 0) {
            $isUnique = true;
        }
        $checkStmt->close();
    }

    // 4. Begin Database Transaction
    $conn->begin_transaction();
    
    try {    
        // Insert User Record
        $sql = "INSERT INTO user_table (
                    user_firstName, 
                    user_middleName, 
                    user_lastName, 
                    user_sex, 
                    user_birthDate, 
                    user_Role, 
                    user_contactInformation, 
                    user_Email,
                    user_address,
                    user_Password,
                    user_status,
                    QC_ID_Number
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        
        $status = 'active';
        $stmt->bind_param("ssssssssssss", // Corrected to 12 's' characters
            $first_name, 
            $middle_name, 
            $last_name, 
            $sex, 
            $birth_date, 
            $role, 
            $contact_number, 
            $email, 
            $main_address, 
            $hashed_password,
            $status,
            $qc_id_number
        );

        if (!$stmt->execute()) {
            throw new Exception("Execution failed: " . $stmt->error);
        }

        // 5. GET THE NEW USER ID
        $new_user_id = $conn->insert_id;

        // 6. LOG THE ACTION
        $admin_id = $_SESSION['user_ID'] ?? 0;
        
        // We prepare an array of the new data to store in new_values
        $new_data = [
            'name' => $first_name . ' ' . $last_name,
            'role' => $role,
            'email' => $email,
            'qc_id' => $qc_id_number
        ];

        $audit->log(
            $admin_id, 
            'CREATE', 
            'users', 
            $new_user_id, 
            null,      // Old values are null for a new record
            $new_data  // Store the key details
        );

        $conn->commit();
        $stmt->close();
        
        $msg = urlencode("Account added successfully.");
        header("Location: /QTrace-Website/account-list?status=success&msg=$msg"); 
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}
?>