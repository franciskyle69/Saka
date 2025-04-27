<?php
session_start();
include '../includes/db.php'; // Your DB connection (must use MySQLi)

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

$cart = $_SESSION['cart'];

try {
    // Calculate total amount
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Insert into orders table
    $stmt = $conn->prepare("INSERT INTO orders (order_date, total_amount) VALUES (NOW(), ?)");
    $stmt->bind_param("d", $total); // "d" = double (for decimal/float)
    $stmt->execute();

    $orderId = $conn->insert_id; // Get the ID of the newly inserted order

    // Insert each cart item into order_items table
    $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");

    foreach ($cart as $item) {
        $productName = $item['name'];
        $quantity = $item['quantity'];
        $price = $item['price'];

        $stmtItem->bind_param("isid", $orderId, $productName, $quantity, $price);
        $stmtItem->execute();
    }

    // Clear the cart after successful checkout
    unset($_SESSION['cart']);

    header('Location: checkout_success.php?order_id=' . $orderId);
    exit();

} catch (Exception $e) {
    echo "Checkout failed: " . $e->getMessage();
}
?>