<?php
if (!isset($_GET['order_id'])) {
    header('Location: products.php');
    exit();
}

$orderId = intval($_GET['order_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout Successful</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="alert alert-success">
            <h4 class="alert-heading">✅ Thank you for your purchase!</h4>
            <p>Your order ID is <strong>#<?= htmlspecialchars($orderId) ?></strong>.</p>
            <a href="products.php" class="btn btn-primary">Shop Again</a>
        </div>
    </div>
</body>

</html>