<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('../../database/connection/connection.php');

// Get article ID from URL
$article_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($article_id <= 0) {
    $_SESSION['error'] = 'Invalid article ID.';
    header('Location: /QTrace-Website/project-articles');
    exit();
}

// Verify user is logged in
if (!isset($_SESSION['user_ID'])) {
    $_SESSION['error'] = 'You must be logged in to delete articles.';
    header('Location: /QTrace-Website/login');
    exit();
}

// Verify article exists
$article_check = $conn->query("SELECT article_ID FROM articles_table WHERE article_ID = $article_id");
if (!$article_check || $article_check->num_rows === 0) {
    $_SESSION['error'] = 'Article not found.';
    header('Location: /QTrace-Website/project-articles');
    exit();
}

// Delete the article
$delete_sql = "DELETE FROM articles_table WHERE article_ID = $article_id";

if ($conn->query($delete_sql) === TRUE) {
    $_SESSION['success_message'] = 'Article deleted successfully!';
    header('Location: /QTrace-Website/project-articles');
    exit();
} else {
    $_SESSION['error'] = 'Error deleting article: ' . $conn->error;
    error_log('Database error: ' . $conn->error);
    header('Location: /QTrace-Website/project-articles');
    exit();
}
?>
