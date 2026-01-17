<?php
// Fetch single article detail from database
// Used in view_article.php for both admin and public

if (!isset($conn)) {
    include(__DIR__ . '/../connection/connection.php');
}

$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($article_id <= 0) {
    die('Invalid article ID');
}

$article_query = "
    SELECT 
        a.article_ID,
        a.article_type,
        a.article_description,
        a.article_photo_url,
        a.article_status,
        a.article_created_at,
        a.article_updated_at,
        pt.Project_ID,
        pd.ProjectDetails_Title,
        pd.ProjectDetails_Description,
        pd.ProjectDetails_Barangay,
        pd.ProjectDetails_Budget,
        u.user_id,
        CONCAT(u.user_FirstName, ' ', u.user_LastName) as author_name
    FROM articles_table a
    INNER JOIN projects_table pt ON a.Project_ID = pt.Project_ID
    INNER JOIN projectdetails_table pd ON pt.Project_ID = pd.Project_ID
    LEFT JOIN user_table u ON a.user_ID = u.user_id
    WHERE a.article_ID = $article_id
";

$article_result = $conn->query($article_query);

if (!$article_result || $article_result->num_rows === 0) {
    die('Article not found');
}

$article = $article_result->fetch_assoc();
?>
