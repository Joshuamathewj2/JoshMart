<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$conn = connectDB();
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT c.*, p.name, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$total = array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart_items));
$tax = $total * 0.05;
$grand_total = $total + $tax;

$conn->close();
?>
<main class="main">
    <div class="container">
        <h1>Order Summary</h1>
        <div class="bill-section">
            <table class="bill-table">
                <thead><tr><th>Product</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead>
                <tbody>
                    <?php foreach($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>Rs. <?php echo number_format($item['price'], 2); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="bill-summary">
                <p>Subtotal: Rs. <?php echo number_format($total, 2); ?></p>
                <p>Tax (5%): Rs. <?php echo number_format($tax, 2); ?></p>
                <h3>Total: Rs. <?php echo number_format($grand_total, 2); ?></h3>
                <button class="btn btn-primary btn-large" onclick="processPayment()">Proceed to Payment</button>
                <a href="cart.php" class="btn btn-secondary">Back to Cart</a>
            </div>
        </div>
    </div>
</main>
<?php require_once '../includes/footer.php'; ?>
