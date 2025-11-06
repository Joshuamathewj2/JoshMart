<?php
session_start();
require 'includes/db.php';
include 'includes/header.php';

// 🗑️ Handle removing an item
if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    if (isset($_SESSION['cart'][$id])) {
        $qty = $_SESSION['cart'][$id]['qty'];
        $stmt = $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
        $stmt->execute([$qty, $id]);
        unset($_SESSION['cart'][$id]);
    }
    header('Location: cart.php');
    exit;
}

// 🧹 Handle clearing the whole cart
if (isset($_GET['clear'])) {
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $stmt = $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
            $stmt->execute([$item['qty'], $item['id']]);
        }
        unset($_SESSION['cart']);
    }
    header('Location: cart.php');
    exit;
}

// 🛒 Get all cart items
$cart = $_SESSION['cart'] ?? [];
$total = 0;
foreach ($cart as $c) {
    $total += $c['price'] * $c['qty'];
}
?>

<style>
body {
  background: linear-gradient(to bottom right, #e9ffe9, #ffffff);
  font-family: 'Poppins', sans-serif;
  animation: fadeIn 0.8s ease-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

h2 {
  color: #2e8b57;
  text-align: center;
  margin: 40px 0 30px 0;
}

.table {
  width: 80%;
  margin: 0 auto;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.table th {
  background: #2e8b57;
  color: white;
  text-align: center;
}

.table td {
  text-align: center;
  vertical-align: middle;
}

.btn-warning {
  background-color: #f4a261;
  border: none;
  border-radius: 20px;
  margin-right: 10px;
}

.btn-primary {
  background-color: #2e8b57;
  border: none;
  border-radius: 20px;
  transition: transform 0.2s, box-shadow 0.2s;
}

.btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 12px rgba(46, 139, 87, 0.3);
}

.btn-danger {
  border-radius: 20px;
}

.action-buttons {
  text-align: center;
  margin: 30px;
}
</style>

<h2>Your Cart</h2>

<?php if (empty($cart)): ?>
  <p class="text-center text-muted">🛒 No items in cart.</p>
<?php else: ?>
  <table class="table table-bordered">
    <tr>
      <th>Product</th>
      <th>Quantity</th>
      <th>Price (₹)</th>
      <th>Subtotal (₹)</th>
      <th>Action</th>
    </tr>

    <?php foreach ($cart as $id => $c): ?>
      <tr>
        <td>
          <img src="assets/images/<?php echo htmlspecialchars($c['image']); ?>" 
               width="60" height="60" 
               style="border-radius: 10px; object-fit: cover; margin-right: 10px;">
          <?php echo htmlspecialchars($c['name']); ?>
        </td>
        <td><?php echo $c['qty']; ?></td>
        <td><?php echo number_format($c['price'], 2); ?></td>
        <td><?php echo number_format($c['price'] * $c['qty'], 2); ?></td>
        <td>
          <a href="cart.php?remove=<?php echo $id; ?>" class="btn btn-sm btn-danger">
            Remove
          </a>
        </td>
      </tr>
    <?php endforeach; ?>

    <tr>
      <th colspan="3" style="text-align:right;">Total:</th>
      <th>₹<?php echo number_format($total, 2); ?></th>
      <th></th>
    </tr>
  </table>

  <div class="action-buttons">
    <a href="cart.php?clear=1" class="btn btn-warning">🧹 Clear Cart</a>
    <a href="bill.php" class="btn btn-primary">🧾 Proceed to Bill</a>
  </div>

<?php endif; ?>

<?php include 'includes/footer.php'; ?>
