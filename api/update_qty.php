<?php
session_start();
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

$cart_id = $_POST['cart_id'] ?? null;
$quantity = $_POST['quantity'] ?? null;

if (!$cart_id || !$quantity || $quantity < 1) {
    echo json_encode(['success' => false]);
    exit;
}

$conn = connectDB();
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("iii", $quantity, $cart_id, $user_id);
$result = $stmt->execute();
$stmt->close();
$conn->close();

echo json_encode(['success' => $result]);
?>
