<?php
session_start();
require_once "db.php";

try {
    $pdo->beginTransaction();
    
    if (isset($_GET['serch']) && !empty(trim($_GET['serch']))) {
        // Search case
        $searchTerm = '%' . trim($_GET['serch']) . '%';
        $stmt = $pdo->prepare('SELECT * FROM products WHERE title LIKE :term OR description LIKE :term ORDER BY creat_date DESC');
        $stmt->execute([':term' => $searchTerm]);
    } else {
        // Non-search case
        $stmt = $pdo->prepare('SELECT * FROM products ORDER BY creat_date DESC');
        $stmt->execute();
    }
    
    $_SESSION['products'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $pdo->commit();
    
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log('Failed to get products: ' . $e->getMessage());
    $_SESSION['products'] = [];
}

// Redirect back to index.php
header('Location: index.php');
exit();