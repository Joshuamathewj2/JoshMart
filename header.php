<!-- includes/header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JoshMart Grocery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    nav.navbar {
      background: linear-gradient(135deg, #38b000, #70e000);
      padding: 15px 20px;
    }
    .navbar-brand {
      color: white;
      font-weight: 600;
      font-size: 1.4rem;
    }
    .navbar-brand:hover {
      color: #e9ffe9;
    }
    .nav-link {
      color: white !important;
      font-weight: 500;
      margin-right: 15px;
    }
    .nav-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="categories.php">🌿 JoshMart</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="categories.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php">All Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">🛒 Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
