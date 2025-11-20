<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoshMart - Online Shopping Platform</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/animations/entrance.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-top">
                <h1 class="logo">JoshMart</h1>
                <nav class="nav">
                    <ul class="nav-list">
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="categories.php">Categories</a></li>
                        <li><a href="products.php">Products</a></li>
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <li><a href="cart.php">Cart</a></li>
                            <li><a href="profile.php">Profile</a></li>
                            <li><a href="../api/logout.php">Logout</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
