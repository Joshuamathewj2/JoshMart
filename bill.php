<?php
session_start();
date_default_timezone_set("Asia/Kolkata");

// Customer / bill meta (you can replace customer name with real logged-in user)
$customer_name = "Joshua";
$bill_id = rand(1000, 9999);
$date = date("d-m-Y h:i A");

// Read cart from session (safe)
$raw_cart = $_SESSION['cart'] ?? [];

// Normalize items: accept both 'qty' and 'quantity' keys and ensure required fields exist
$items = [];
foreach ($raw_cart as $key => $it) {
    // If cart was stored as indexed array, $key might be numeric index or product id
    $quantity = 0;
    if (isset($it['quantity'])) {
        $quantity = (int)$it['quantity'];
    } elseif (isset($it['qty'])) {
        $quantity = (int)$it['qty'];
    } elseif (isset($it['q'])) { // extra fallback
        $quantity = (int)$it['q'];
    }

    $name = isset($it['name']) ? $it['name'] : (isset($it['title']) ? $it['title'] : 'Unknown Item');
    $price = isset($it['price']) ? (float)$it['price'] : (isset($it['rate']) ? (float)$it['rate'] : 0.0);
    $image = isset($it['image']) ? $it['image'] : '';

    // If quantity is zero skip the item (optional)
    if ($quantity <= 0) {
        continue;
    }

    $items[] = [
        'id' => $key,
        'name' => $name,
        'quantity' => $quantity,
        'price' => $price,
        'image' => $image
    ];
}

// Grand total
$total = 0.0;
foreach ($items as $item) {
    $total += $item['quantity'] * $item['price'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>JoshMart Bill</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --green: #2d6a4f;
      --light-green: #d8f3dc;
    }
    body {
      font-family: "Poppins", sans-serif;
      background: linear-gradient(to bottom right, #f6fff6, #ffffff);
      margin: 0;
      padding: 30px;
      -webkit-print-color-adjust: exact;
    }

    /* Container + entrance animation */
    .bill-container {
      max-width: 720px;
      margin: 0 auto;
      background: white;
      padding: 22px;
      border-radius: 12px;
      box-shadow: 0 6px 22px rgba(0,0,0,0.08);
      animation: slideUp 0.6s ease-out;
    }
    @keyframes slideUp {
      from { transform: translateY(20px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    h2 { text-align: center; color: var(--green); margin: 4px 0; }
    h4 { text-align: center; color: #4a4a4a; margin: 4px 0 12px 0; font-weight: 400; }

    .meta {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-bottom: 10px;
      flex-wrap: wrap;
    }
    .meta div { font-size: 0.95rem; color: #333; }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 14px;
    }
    thead th {
      text-align: left;
      padding: 10px;
      background: var(--light-green);
      color: var(--green);
      font-weight: 600;
    }
    tbody td {
      padding: 12px;
      border-bottom: 1px solid #eee;
      vertical-align: middle;
    }

    /* Small product thumbnail */
    .prod-thumb {
      width: 56px;
      height: 56px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 12px;
      vertical-align: middle;
    }
    .prod-name {
      display: inline-block;
      vertical-align: middle;
      font-weight: 600;
      color: #2f5233;
    }

    .qty, .price, .sub {
      text-align: center;
      min-width: 70px;
    }

    tfoot td {
      padding: 12px;
      font-weight: 700;
      font-size: 1.05rem;
      text-align: right;
    }

    .actions {
      display: flex;
      gap: 10px;
      margin-top: 18px;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .print-btn {
      background: var(--green);
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 600;
      box-shadow: 0 6px 14px rgba(46,139,87,0.18);
      transition: transform .15s, box-shadow .15s;
    }
    .print-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(46,139,87,0.24); }

    .back-btn {
      background: transparent;
      color: var(--green);
      border: 2px solid var(--green);
      padding: 8px 14px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: 600;
    }

    .footer-note {
      text-align: center;
      margin-top: 18px;
      color: #2f3e2f;
      font-size: 0.95rem;
    }

    /* Print styles */
    @media print {
      body { background: white; }
      .print-btn, .back-btn { display: none; }
      .bill-container { box-shadow: none; border-radius: 0; padding: 0; }
    }

    /* Empty cart message */
    .empty {
      text-align: center;
      color: #777;
      padding: 30px 10px;
    }
  </style>
</head>
<body>

<div class="bill-container">
  <h2>🌿 JoshMart</h2>
  <h4>Nature Fresh Grocery</h4>
  <hr>

  <div class="meta">
    <div><strong>Bill ID:</strong> <?php echo htmlspecialchars($bill_id); ?></div>
    <div><strong>Customer:</strong> <?php echo htmlspecialchars($customer_name); ?></div>
    <div><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></div>
  </div>

  <hr>

  <?php if (empty($items)): ?>
    <div class="empty">
      <p>🛒 Your cart is empty. Add items from the shop to generate a bill.</p>
      <div style="text-align:center; margin-top:10px;">
        <a class="back-btn" href="index.php">Continue Shopping</a>
      </div>
    </div>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Item</th>
          <th class="qty">Qty</th>
          <th class="price">Price (₹)</th>
          <th class="sub">Total (₹)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($items as $it): 
          $lineTotal = $it['quantity'] * $it['price'];
        ?>
          <tr>
            <td>
              <?php if (!empty($it['image'])): ?>
                <img src="<?php echo htmlspecialchars('assets/images/' . $it['image']); ?>" alt="" class="prod-thumb">
              <?php endif; ?>
              <span class="prod-name"><?php echo htmlspecialchars($it['name']); ?></span>
            </td>
            <td class="qty"><?php echo (int)$it['quantity']; ?></td>
            <td class="price">₹<?php echo number_format((float)$it['price'], 2); ?></td>
            <td class="sub">₹<?php echo number_format((float)$lineTotal, 2); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3">Grand Total</td>
          <td>₹<?php echo number_format((float)$total, 2); ?></td>
        </tr>
      </tfoot>
    </table>

    <div class="actions">
      <div>
        <button class="print-btn" onclick="window.print()">🧾 Print Bill</button>
        <a class="back-btn" href="categories.php">Continue Shopping</a>
      </div>

      <div style="color: #2f5233; font-weight: 600;">
        Paid via: <span style="background: #e9f7ee; padding: 6px 10px; border-radius: 8px;">Cash / Card</span>
      </div>
    </div>

    <div class="footer-note">
      Thank you for shopping with JoshMart! 🌱 Freshness Delivered Daily 🥗
    </div>
  <?php endif; ?>
</div>

</body>
</html>
