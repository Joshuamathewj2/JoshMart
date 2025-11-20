<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

$category_id = $_GET['category'] ?? null;
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
?>
<main class="main">
    <div class="container">
        <h1>All Products</h1>
        <div class="products-grid">
            <?php while ($product = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price">Rs. <?php echo number_format($product['price'], 2); ?></p>
                    <button class="btn btn-primary" onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-secondary">View</a>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</main>
<?php $stmt->close(); $conn->close(); require_once '../includes/footer.php'; ?>
