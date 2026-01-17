<?php

if (!isset($conn)) {
    include(__DIR__ . '/../connection/connection.php');
}

$articles_query = "
    SELECT 
        a.article_ID,
        a.article_type,
        a.article_description,
        a.article_photo_url,
        a.article_status,
        a.article_created_at,
        pt.Project_ID,
        pd.ProjectDetails_Title,
        pd.ProjectDetails_Barangay,
        pd.ProjectDetails_Budget,
        u.user_id,
        CONCAT(u.user_FirstName, ' ', u.user_LastName) as author_name
    FROM articles_table a
    INNER JOIN projects_table pt ON a.Project_ID = pt.Project_ID
    INNER JOIN projectdetails_table pd ON pt.Project_ID = pd.Project_ID
    LEFT JOIN user_table u ON a.user_ID = u.user_id
    ORDER BY a.article_created_at DESC
";

$articles_result = $conn->query($articles_query);

if (!$articles_result) {
    error_log("Articles query error: " . $conn->error);
    $articles_result = null;
}
?>
