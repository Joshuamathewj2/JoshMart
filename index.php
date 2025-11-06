<?php
require 'includes/db.php';
include 'includes/header.php';

// Fetch all products
$stmt = $pdo->query("SELECT p.*, c.name AS category FROM products p LEFT JOIN categories c ON p.category_id = c.id");
$products = $stmt->fetchAll();
?>

<!-- 🌿 Fresh Grocery Theme Styling -->
<style>
body {
  background: linear-gradient(to bottom right, #e9fce9, #ffffff);
  font-family: 'Poppins', sans-serif;
  color: #2f3e2f;
  margin: 0;
  padding: 0;
}

/* Banner Section */
.banner {
  background: linear-gradient(135deg, #38b000, #70e000);
  color: white;
  text-align: center;
  padding: 50px 20px;
  border-radius: 0 0 40px 40px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.banner h1 {
  font-size: 2.8rem;
  margin-bottom: 10px;
}

.banner p {
  font-size: 1.2rem;
  opacity: 0.9;
}

/* Product Cards */
.card {
  border: none;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
  background-color: white;
  height: 100%;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.card-img-container {
  width: 100%;
  height: 200px;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f9f9f9;
}

.card-img-container img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* keeps same image ratio and fills evenly */
}

.card-body {
  padding: 15px;
  text-align: center;
}

.card-title {
  font-weight: 600;
  color: #2f5233;
}

.card-text {
  font-size: 1rem;
  color: #28a745;
  font-weight: bold;
}

.btn-primary {
  background-color: #38b000;
  border: none;
  border-radius: 25px;
  padding: 8px 18px;
  transition: background 0.3s, box-shadow 0.3s;
}

.btn-primary:hover {
  background-color: #2b9300;
  box-shadow: 0 0 10px rgba(56, 176, 0, 0.5);
}

/* Footer */
.footer {
  background: #2d6a4f;
  color: white;
  text-align: center;
  padding: 20px;
  margin-top: 50px;
  border-radius: 20px 20px 0 0;
}

.footer p {
  margin: 0;
  font-size: 0.9rem;
}
</style>

<!-- 🌿 Header Banner -->
<div class="banner">
  <h1>🌿 JoshMart - Nature Fresh Grocery</h1>
  <p>Farm-fresh produce, organic items & quality daily essentials delivered to your door.</p>
</div>

<!-- 🛒 Products Section -->
<div class="container my-5">
  <h2 class="text-center mb-4 fw-bold" style="color:#2f5233;">Our Fresh Products</h2>
  <div class="row">
    <?php foreach ($products as $p): ?>
      <div class="col-md-3 mb-4">
        <div class="card h-100">
          <div class="card-img-container">
            <img src="assets/images/<?php echo htmlspecialchars($p['image']); ?>" 
                 alt="<?php echo htmlspecialchars($p['name']); ?>">
          </div>
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($p['name']); ?></h5>
            <p class="card-text">₹<?php echo number_format($p['price'], 2); ?></p>
            <a href="product.php?id=<?php echo $p['id']; ?>" class="btn btn-primary btn-sm">View</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- 🌱 Footer -->
<div class="footer">
  <p>© 2025 JoshMart Grocery. Freshness Delivered Daily 🥗</p>
</div>

<?php include 'includes/footer.php'; ?>
