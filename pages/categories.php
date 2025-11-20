<?php
session_start();
require_once '../includes/functions.php';
$pdo = connectDB();
$categories = getCategories();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Categories - JoshMart</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Shop by Category</h1>
    <div class="categories-grid">
        <?php foreach ($categories as $cat): ?>
            <div class="category-card">
                <a href="category_products.php?id=<?php echo $cat['id']; ?>">
                    <h3><?php echo htmlspecialchars($cat['name']); ?></h3>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <script src="../assets/js/script.js"></script>
</body>
</html>
