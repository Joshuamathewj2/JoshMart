<?php
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

$category_id = $_GET['category_id'] ?? null;
$search = $_GET['search'] ?? '';

$conn = connectDB();

if ($category_id) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ? AND name LIKE ?");
    $search_term = "%" . $search . "%";
    $stmt->bind_param("is", $category_id, $search_term);
} else {
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
    $search_term = "%" . $search . "%";
    $stmt->bind_param("s", $search_term);
}

$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

echo json_encode(['products' => $products]);
?>
