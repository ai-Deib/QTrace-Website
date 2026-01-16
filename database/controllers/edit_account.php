<?php

require('../connection/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture user_id
    $user_id = (int)$_POST['user_id'];
    
    if ($user_id <= 0) {
        die("Invalid user ID.");
    }

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
    
    // Begin Database Transaction
    $conn->begin_transaction();
    
    try {    
        // Check if password needs to be updated
        if (!empty($_POST['defaultpassword'])) {
            // Update with new password
            $raw_password = $_POST['defaultpassword'];
            $hashed_password = password_hash($raw_password, PASSWORD_BCRYPT);
            
            $sql = "UPDATE user_table SET 
                        user_firstName = ?, 
                        user_middleName = ?, 
                        user_lastName = ?, 
                        user_sex = ?, 
                        user_birthDate = ?, 
                        user_Role = ?, 
                        user_contactInformation = ?, 
                        user_Email = ?,
                        user_address = ?,
                        user_Password = ?
                    WHERE user_ID = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssssssi", 
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
                $user_id
            );
        } else {
            // Update without changing password
            $sql = "UPDATE user_table SET 
                        user_firstName = ?, 
                        user_middleName = ?, 
                        user_lastName = ?, 
                        user_sex = ?, 
                        user_birthDate = ?, 
                        user_Role = ?, 
                        user_contactInformation = ?, 
                        user_Email = ?,
                        user_address = ?
                    WHERE user_ID = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssssssi", 
                $first_name, 
                $middle_name, 
                $last_name, 
                $sex, 
                $birth_date, 
                $role, 
                $contact_number, 
                $email, 
                $main_address,
                $user_id
            );
        }

        if (!$stmt->execute()) {
            throw new Exception("Execution failed: " . $stmt->error);
        }

        $conn->commit();
        $stmt->close();
        
        // Redirect after success
        header("Location: /QTrace-Website/pages/admin/view_account.php?id=" . $user_id . "&status=updated"); 
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Error: " . $e->getMessage());
    }
}
?>
