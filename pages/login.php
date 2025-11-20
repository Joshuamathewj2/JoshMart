<?php
require_once '../includes/header.php';
require_once '../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($email && $password) {
        $conn = connectDB();
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: categories.php');
            exit;
        } else {
            $error = 'Invalid email or password';
        }
    }
}
?>
<main class="main">
    <div class="container">
        <div class="login-form">
            <h1>Login</h1>
            <?php if (isset($error)): ?><p class="error"><?php echo htmlspecialchars($error); ?></p><?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</main>
<?php require_once '../includes/footer.php'; ?>
