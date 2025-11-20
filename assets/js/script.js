// JoshMart JavaScript
// Main application scripts

document.addEventListener('DOMContentLoaded', function() {
    console.log('JoshMart loaded');
    initializeCart();
});

function addToCart(productId) {
    fetch('api/add_to_cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({product_id: productId})
    }).then(res => res.json()).then(data => {
        alert('Product added to cart!');
    });
}

function removeFromCart(cartId) {
    fetch('api/remove_from_cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({cart_id: cartId})
    }).then(res => res.json()).then(data => {
        location.reload();
    });
}

function updateQuantity(cartId, qty) {
    fetch('api/update_qty.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({cart_id: cartId, quantity: qty})
    }).then(res => res.json()).then(data => {
        location.reload();
    });
}

function initializeCart() {
    const cartBtn = document.getElementById('cart-btn');
    if(cartBtn) {
        cartBtn.addEventListener('click', showCart);
    }
}

function showCart() {
    window.location.href = 'pages/cart.php';
}
