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

$conn->close();
?>
<main class="main">
    <div class="container">
        <h1>Shopping Cart</h1>
        <?php if(empty($cart_items)): ?>
            <p>Your cart is empty. <a href="products.php">Continue Shopping</a></p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th><th>Action</th></tr>
                </thead>
                <tbody>
                    <?php foreach($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>Rs. <?php echo number_format($item['price'], 2); ?></td>
                            <td><input type="number" value="<?php echo $item['quantity']; ?>" min="1"></td>
                            <td>Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td><button class="btn btn-danger" onclick="removeFromCart(<?php echo $item['id']; ?>)">Remove</button></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="cart-summary">
                <h3>Total: Rs. <?php echo number_format($total, 2); ?></h3>
                <a href="bill.php" class="btn btn-primary btn-large">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php require_once '../includes/footer.php'; ?>
