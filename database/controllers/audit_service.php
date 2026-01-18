<?php
class AuditService {
    private $db;

    public function __construct($dbConnection) {
        // This will receive the $conn variable from your connection.php
        $this->db = $dbConnection;
    }

    public function log($userId, $action, $resType, $resId, $oldVals = null, $newVals = null) {
        // SQL query using mysqli syntax
        $query = "INSERT INTO audit_logs (
                    audit_log_id, user_id, action, resource_type, 
                    resource_id, old_values, new_values, created_at
                  ) VALUES (UUID(), ?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $this->db->prepare($query);
        
        // Convert arrays to JSON strings
        $oldJson = $oldVals ? json_encode($oldVals) : null;
        $newJson = $newVals ? json_encode($newVals) : null;

        // "ssssss" means 6 strings
        $stmt->bind_param("ssssss", $userId, $action, $resType, $resId, $oldJson, $newJson);
        
        return $stmt->execute();
    }
}
?>