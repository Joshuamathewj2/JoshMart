<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

$conn = connectDB();
$products = getProducts($conn);
$closeDB($conn);
?>
<main class="main">
    <div class="container">
        <h1>All Products</h1>
        <div class="products-grid">
            <?php foreach($products as $product): ?>
                <div class="product-card">
                    <img src="../assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p class="price">Rs. <?php echo number_format($product['price'], 2); ?></p>
                    <p class="description"><?php echo substr(htmlspecialchars($product['description']), 0, 100); ?>...</p>
                    <button class="btn btn-primary" onclick="addToCart(<?php echo $product['id']; ?>)">Add to Cart</button>
                    <a href="product_view.php?id=<?php echo $product['id']; ?>" class="btn btn-secondary">View</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php require_once '../includes/footer.php'; ?>
