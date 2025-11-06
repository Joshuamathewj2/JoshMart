<?php
session_start();
require 'includes/db.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: categories.php');
    exit;
}

// Get product info
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found!";
    exit;
}

// If product is out of stock
if ($product['stock'] <= 0) {
    header('Location: products.php?category=' . urlencode($product['category']));
    exit;
}

// Reduce stock in DB
$stmt = $pdo->prepare("UPDATE products SET stock = stock - 1 WHERE id = ?");
$stmt->execute([$id]);

// Add to session cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id]['qty'] += 1;
} else {
    $_SESSION['cart'][$id] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'qty' => 1
    ];
}

// Redirect to cart
header('Location: cart.php');
exit;
?>
