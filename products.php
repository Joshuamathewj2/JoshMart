<?php
require 'includes/db.php';
include 'includes/header.php';

// Get category ID from URL
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

// Fetch category name
$cat_stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
$cat_stmt->execute([$category_id]);
$category = $cat_stmt->fetchColumn();

// Fetch products for this category
$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id = ?");
$stmt->execute([$category_id]);
$products = $stmt->fetchAll();
?>

<style>
body {
  background: linear-gradient(to bottom right, #e6ffe6, #ffffff);
  font-family: 'Poppins', sans-serif;
}

h2 {
  color: #2e8b57;
  font-weight: 600;
  margin-bottom: 30px;
}

.card {
  border: none;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
  border-radius: 15px;
  transition: transform 0.2s, box-shadow 0.2s;
}

.card:hover {
  transform: scale(1.03);
  box-shadow: 0 8px 15px rgba(0,0,0,0.2);
}

.card-img-top {
  border-radius: 15px 15px 0 0;
  height: 180px;
  object-fit: cover;
}

.btn-primary {
  background-color: #2e8b57;
  border: none;
  border-radius: 30px;
}

.btn-primary:hover {
  background-color: #246b45;
}
</style>

<div class="container mt-4">
  <h2 class="text-center mb-4">🌿 <?php echo htmlspecialchars($category); ?> </h2>

  <div class="row">
    <?php if ($products): ?>
      <?php foreach ($products as $p): ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100">
            <img src="assets/images/<?php echo htmlspecialchars($p['image']); ?>" 
                 class="card-img-top" alt="<?php echo htmlspecialchars($p['name']); ?>">
            <div class="card-body text-center">
              <h5 class="card-title"><?php echo htmlspecialchars($p['name']); ?></h5>
              <p class="card-text text-success fw-bold">₹<?php echo number_format($p['price'], 2); ?></p>
              <a href="product.php?id=<?php echo $p['id']; ?>" class="btn btn-primary btn-sm">View</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-muted">No products found in this category.</p>
    <?php endif; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
