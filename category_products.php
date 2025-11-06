<?php
include 'includes/db.php';
include 'includes/header.php';

if (!isset($_GET['category'])) {
    die("<div class='text-center mt-5 text-danger fw-bold'>Invalid Category!</div>");
}

$category = $_GET['category'];

$stmt = $pdo->prepare("
    SELECT p.*, c.name AS category 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id 
    WHERE c.name = ?
");
$stmt->execute([$category]);
$products = $stmt->fetchAll();
?>

<!-- 🌿 Header Banner -->
<div class="banner text-center">
  <h1>🌿 JoshMart - Nature Fresh Grocery</h1>
  <p>Farm-fresh produce, organic items & quality daily essentials delivered to your door.</p>
</div>

<div class="container my-5">
  <h2 class="text-center mb-5 text-success fw-bold"><?php echo htmlspecialchars($category); ?></h2>

  <div class="row">
    <?php if (count($products) > 0): ?>
      <?php foreach ($products as $p): ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="assets/images/<?php echo htmlspecialchars($p['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($p['name']); ?>">
            <div class="card-body text-center">
              <h5 class="card-title"><?php echo htmlspecialchars($p['name']); ?></h5>
              <p class="text-success fw-bold">₹<?php echo number_format($p['price'], 2); ?></p>
              <a href="product.php?id=<?php echo $p['id']; ?>" class="btn btn-success btn-sm">View</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-center text-muted">No products found in this category.</p>
    <?php endif; ?>
  </div>
</div>

<style>
.banner {
  background: linear-gradient(135deg, #38b000, #70e000);
  color: white;
  text-align: center;
  padding: 60px 20px;
  border-radius: 0 0 50px 50px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}
.banner h1 {
  font-size: 2.5rem;
  font-weight: 700;
}
.banner p {
  font-size: 1.1rem;
  opacity: 0.9;
}
.card-img-top {
  height: 200px;
  object-fit: cover;
  border-radius: 15px 15px 0 0;
}
</style>

<?php include 'includes/footer.php'; ?>
