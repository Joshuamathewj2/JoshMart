<?php
session_start();
require 'includes/db.php';
include 'includes/header.php';
?>

<div class="banner">
  <h1>🌿 Welcome to JoshMart</h1>
  <p>Farm-fresh produce, organic items & daily essentials delivered to your door.</p>
</div>

<div class="deal">
  🌾 <b>Deal of the Day:</b> Get 20% off on all fresh fruits today!
</div>

<?php
$id = intval($_GET['id'] ?? 0);

// 🥕 Fetch product details
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) {
    echo "<h3 class='text-center text-danger'>Product not found!</h3>";
    include 'includes/footer.php';
    exit;
}

// 🛒 Handle Add to Cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qty = max(1, intval($_POST['qty'] ?? 1));

    if ($qty > $p['stock']) {
        echo "<script>alert('Sorry, only {$p['stock']} items left in stock!');</script>";
    } else {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += $qty;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $p['name'],
                'price' => $p['price'],
                'qty' => $qty,
                'image' => $p['image']
            ];
        }

        // 🧮 Update stock in DB
        $update = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $update->execute([$qty, $id]);

        header('Location: cart.php');
        exit;
    }
}
?>

<style>
body {
  background: linear-gradient(to bottom right, #f2fff2, #ffffff);
  font-family: 'Poppins', sans-serif;
}

.banner {
  text-align: center;
  background: #2e8b57;
  color: white;
  padding: 30px 0;
  margin-bottom: 20px;
  border-radius: 0 0 20px 20px;
}

.deal {
  background: #e8f5e9;
  text-align: center;
  padding: 10px;
  margin: 10px auto 30px auto;
  width: 80%;
  border-radius: 10px;
  font-weight: 500;
  color: #2e8b57;
}

.product-container {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 40px;
  flex-wrap: wrap;
  margin: 40px auto;
  width: 85%;
}

.product-card {
  background: #fff;
  border-radius: 15px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  padding: 20px;
  width: 420px;
  text-align: center;
}

.product-card img {
  border-radius: 10px;
  width: 100%;
  height: 250px;
  object-fit: cover;
}

.btn-success {
  background-color: #2e8b57;
  border: none;
  border-radius: 30px;
  padding: 10px 25px;
  font-weight: 500;
}

.btn-success:hover {
  background-color: #246b45;
}

input[type='number'] {
  text-align: center;
}
</style>

<div class="product-container">
  <div class="product-card">
    <img src="assets/images/<?php echo htmlspecialchars($p['image']); ?>" 
         alt="<?php echo htmlspecialchars($p['name']); ?>">
    <h3 class="mt-3"><?php echo htmlspecialchars($p['name']); ?></h3>
    <p><?php echo htmlspecialchars($p['description']); ?></p>
    <h4 class="text-success">₹<?php echo number_format($p['price'], 2); ?></h4>
    <p><strong>Available Stock:</strong> <?php echo $p['stock']; ?></p>

    <?php if ($p['stock'] > 0): ?>
      <form method="post">
        <input type="number" name="qty" value="1" min="1" max="<?php echo $p['stock']; ?>" 
               class="form-control mb-2" style="width: 100px; margin: 0 auto;">
        <button type="submit" class="btn btn-success">🛒 Add to Cart</button>
      </form>
    <?php else: ?>
      <p class="text-danger fw-bold">Out of Stock</p>
    <?php endif; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
