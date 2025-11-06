<?php
require 'includes/db.php';
include 'includes/header.php';

// Fetch all categories
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();
?>

<style>
body {
  background: linear-gradient(to bottom right, #e9fce9, #ffffff);
  font-family: "Poppins", sans-serif;
  color: #2f3e2f;
  margin: 0;
  padding: 0;
}

.banner {
  background: linear-gradient(135deg, #38b000, #70e000);
  color: white;
  text-align: center;
  padding: 50px 20px;
  border-radius: 0 0 50px 50px;
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

.card {
  border: none;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s, box-shadow 0.3s;
  background-color: white;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.card img {
  height: 220px;
  width: 100%;
  object-fit: cover;
}

.card-body {
  padding: 15px;
  text-align: center;
}

.card-title {
  font-weight: 600;
  color: #2f5233;
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

.footer {
  background: #2d6a4f;
  color: white;
  text-align: center;
  padding: 20px;
  margin-top: 50px;
  border-radius: 20px 20px 0 0;
}
</style>

<div class="banner">
  <h1>🌿 JoshMart - Nature Fresh Grocery</h1>
  <p>Farm-fresh produce, organic items & quality daily essentials delivered to your door.</p>
</div>

<div class="container mt-5">
  <h2 class="text-center mb-4">Shop by Category</h2>
  <div class="row">
    <?php foreach ($categories as $c): ?>
      <?php
        // ✅ Fix for image filename — replaces spaces and '&' with safe text
        $imgFile = strtolower(str_replace([' ', '&'], ['_', 'and'], $c['name'])) . '.jpg';
      ?>
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="assets/images/<?php echo $imgFile; ?>?v=<?php echo time(); ?>"
               class="card-img-top" 
               alt="<?php echo htmlspecialchars($c['name']); ?>">
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($c['name']); ?></h5>
            <a href="products.php?category_id=<?php echo $c['id']; ?>" class="btn btn-primary">View Products</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="footer">
  <p>© 2025 JoshMart Grocery. Freshness Delivered Daily 🥗</p>
</div>

<?php include 'includes/footer.php'; ?>
