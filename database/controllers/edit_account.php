<?php
session_start();
require('../connection/connection.php');
require_once('audit_service.php');

$audit = new AuditService($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture user_id
    $user_id = (int)$_POST['user_id'];
    
    if ($user_id <= 0) {
        die("Invalid user ID.");
    }

    // 1. FETCH OLD DATA BEFORE UPDATE
    $stmtOld = $conn->prepare("SELECT user_firstName, user_middleName, user_lastName, user_sex, user_birthDate, user_Role, user_contactInformation, user_Email, user_address FROM user_table WHERE user_ID = ?");
    $stmtOld->bind_param("i", $user_id);
    $stmtOld->execute();
    $oldData = $stmtOld->get_result()->fetch_assoc();
    $stmtOld->close();

    // Capture Information from Form
    $first_name     = $_POST['first_name'];
    $middle_name    = $_POST['middle_name'];
    $last_name      = $_POST['last_name'];
    $sex            = $_POST['sex'];
    $birth_date     = $_POST['birth_date'];
    $role           = $_POST['role'];
    $contact_number = $_POST['contact_number'];
    $email          = $_POST['email'];
    $main_address   = $_POST['main_address'];
    
    // Begin Database Transaction
    $conn->begin_transaction();
    
    try {    
        if (!empty($_POST['defaultpassword'])) {
            $raw_password = $_POST['defaultpassword'];
            $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);
            
            $sql = "UPDATE user_table SET 
                        user_firstName = ?, user_middleName = ?, user_lastName = ?, 
                        user_sex = ?, user_birthDate = ?, user_Role = ?, 
                        user_contactInformation = ?, user_Email = ?,
                        user_address = ?, user_Password = ?
                    WHERE user_ID = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssi", 
                $first_name, $middle_name, $last_name, 
                $sex, $birth_date, $role, 
                $contact_number, $email, $main_address, 
                $hashed_password, $user_id
            );
        } else {
            $sql = "UPDATE user_table SET 
                        user_firstName = ?, user_middleName = ?, user_lastName = ?, 
                        user_sex = ?, user_birthDate = ?, user_Role = ?, 
                        user_contactInformation = ?, user_Email = ?,
                        user_address = ?
                    WHERE user_ID = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssi", 
                $first_name, $middle_name, $last_name, 
                $sex, $birth_date, $role, 
                $contact_number, $email, $main_address, $user_id
            );
        }

        if (!$stmt->execute()) {
            throw new Exception("Execution failed: " . $stmt->error);
        }

        // 2. PREPARE NEW DATA ARRAY (excluding password for security)
        $newData = [
            'user_firstName' => $first_name,
            'user_middleName' => $middle_name,
            'user_lastName' => $last_name,
            'user_sex' => $sex,
            'user_birthDate' => $birth_date,
            'user_Role' => $role,
            'user_contactInformation' => $contact_number,
            'user_Email' => $email,
            'user_address' => $main_address
        ];

        // 3. LOG THE CHANGE
        $admin_id = $_SESSION['user_ID'] ?? 0;
        
        // We only want to log fields that actually changed
        $changed_old = [];
        $changed_new = [];

        foreach ($newData as $key => $value) {
            if ($oldData[$key] != $value) {
                $changed_old[$key] = $oldData[$key];
                $changed_new[$key] = $value;
            }
        }

        // Only log if something actually changed
        if (!empty($changed_new)) {
            $audit->log(
                $admin_id, 
                'UPDATE', 
                'users', 
                $user_id, 
                $changed_old, 
                $changed_new
            );
        }

        $conn->commit();
        $stmt->close();
        $msg = urlencode("Account updated successfully.");
        header("Location: /QTrace-Website/view-account?id=" . $user_id . "&status=success&msg=$msg"); 
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}
?>