<?php
session_start();
header('Content-Type: application/json');
require_once '../includes/functions.php';

$data = json_decode(file_get_contents('php://input'), true);
$product_id = $data['product_id'] ?? null;

if (!$product_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$pdo = connectDB();
$stmt = $pdo->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)');
$result = $stmt->execute([$user_id, $product_id]);

echo json_encode(['success' => $result]);
?>
