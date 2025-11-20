<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

$product_id = $_GET['id'] ?? null;
if (!$product_id) { header('Location: products.php'); exit; }

$conn = connectDB();
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$product) { header('Location: products.php'); exit; }
?>
<main class="main">
    <div class="container">
        <div class="product-view">
            <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-image">
            <div class="product-info">
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                <p class="price">Rs. <?php echo number_format($product['price'], 2); ?></p>
                <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                <p class="stock">Stock: <?php echo $product['stock']; ?> units available</p>
                <button class="btn btn-primary btn-large" onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
                <a href="products.php" class="btn btn-secondary">Back to Products</a>
            </div>
        </div>
    </div>
</main>
<?php require_once '../includes/footer.php'; ?>
