<?php
require('../../database/connection/connection.php');

try {
        $stmt = $pdo->query("SELECT * FROM projects_table");
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        // Fallback to empty array if query fails so JS doesn't break
        $projects = [];
    }
?>