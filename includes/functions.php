<?php
// JoshMart Common Functions

function connectDB() {
    $host = 'localhost';
    $db = 'joshmart';
    $user = 'root';
    $pass = '';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch(PDOException $e) {
        die('Connection Error: ' . $e->getMessage());
    }
}

function getCategories() {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM categories');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProducts($category_id = null) {
    global $pdo;
    if($category_id) {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE category_id = ?');
        $stmt->execute([$category_id]);
    } else {
        $stmt = $pdo->prepare('SELECT * FROM products');
        $stmt->execute();
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProduct($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header('Location: ' . $url);
    exit;
}
?>
