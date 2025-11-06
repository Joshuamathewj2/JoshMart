<?php
session_start();
require 'includes/db.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0 || !isset($_SESSION['cart'][$id])) {
    header('Location: cart.php');
    exit;
}

$qty = $_SESSION['cart'][$id]['qty'];

// Restore stock
$stmt = $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
$stmt->execute([$qty, $id]);

unset($_SESSION['cart'][$id]);

header('Location: cart.php');
exit;
?>
