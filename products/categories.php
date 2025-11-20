<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

$conn = connectDB();
$categories = getCategories($conn);
$conn->close();
?>
<main class="main">
    <div class="container">
        <h1>Categories</h1>
        <div class="categories-grid">
            <?php foreach($categories as $category): ?>
                <div class="category-card">
                    <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                    <p><?php echo htmlspecialchars($category['description']); ?></p>
                    <a href="products.php?category=<?php echo $category['id']; ?>" class="btn btn-primary">View Products</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
<?php require_once '../includes/footer.php'; ?>
