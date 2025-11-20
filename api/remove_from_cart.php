<?php
session_start();
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

$cart_id = $_POST['cart_id'] ?? null;

if (!$cart_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$conn = connectDB();
$stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
$user_id = $_SESSION['user_id'];
$stmt->bind_param("ii", $cart_id, $user_id);
$result = $stmt->execute();
$stmt->close();
$conn->close();

echo json_encode(['success' => $result]);
?>
