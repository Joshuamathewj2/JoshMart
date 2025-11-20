<?php
session_start();
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$product_id = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? 1;

if (!$product_id) {
    echo json_encode(['success' => false]);
    exit;
}

$conn = connectDB();
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?");
$stmt->bind_param("iiii", $user_id, $product_id, $quantity, $quantity);
$result = $stmt->execute();
$stmt->close();
$conn->close();

echo json_encode(['success' => $result]);
?>
