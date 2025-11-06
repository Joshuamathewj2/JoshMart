<?php
session_start();
require 'includes/db.php';

// If already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JoshMart Login</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <style>
    body {
      background: #f6f7fb;
      font-family: 'Poppins', sans-serif;
    }
    .login-container {
      width: 400px;
      margin: 80px auto;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      padding: 30px;
    }
    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 20px;
    }
    input[type="text"], input[type="email"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 6px;
      background: #28a745;
      color: white;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background: #218838;
    }
    .toggle-link {
      text-align: center;
      margin-top: 15px;
    }
    .toggle-link a {
      color: #007bff;
      text-decoration: none;
    }
    .toggle-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="login-container">
  <h2 id="formTitle">Sign In</h2>

  <!-- 🔹 Login Form -->
  <form id="loginForm" method="POST" action="authenticate.php">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
  </form>

  <!-- 🔹 Signup Form -->
  <form id="signupForm" method="POST" action="register.php" style="display:none;">
    <input type="text" name="name" placeholder="Full Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register">Create Account</button>
  </form>

  <div class="toggle-link">
    <span id="toggleText">
      Don't have an account? <a href="#" id="toggleForm">Sign up</a>
    </span>
  </div>
</div>

<script>
const toggleForm = document.getElementById('toggleForm');
const loginForm = document.getElementById('loginForm');
const signupForm = document.getElementById('signupForm');
const formTitle = document.getElementById('formTitle');
const toggleText = document.getElementById('toggleText');

toggleForm.addEventListener('click', (e) => {
  e.preventDefault();
  if (loginForm.style.display === 'none') {
    loginForm.style.display = 'block';
    signupForm.style.display = 'none';
    formTitle.innerText = 'Sign In';
    toggleText.innerHTML = `Don't have an account? <a href="#" id="toggleForm">Sign up</a>`;
  } else {
    loginForm.style.display = 'none';
    signupForm.style.display = 'block';
    formTitle.innerText = 'Sign Up';
    toggleText.innerHTML = `Already have an account? <a href="#" id="toggleForm">Sign in</a>`;
  }
});
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
