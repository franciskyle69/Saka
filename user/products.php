<?php
include '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>

  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="styles/styles.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
  <link rel="icon" type="image/png" href="../assets/images/logo.png">
</head>
<body>
<?php include '../includes/navbar.php'; ?>
  <div class="dashboard">
   

    <div class="main-content">
     

      <div class="content">
        <h1>Welcome to the Products</h1>
        <p>Browse and add products to your cart.</p>

        <div class="container mt-4">
          <div class="row">
            <?php
            $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
            while ($row = $stmt->fetch()) {
              echo '
              <div class="col-md-4 mb-4">
                <div class="card" style="width: 90%;">
                  <img class="card-img-top" src="' . htmlspecialchars($row["image"]) . '" alt="Product Image">
                  <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row["name"]) . '</h5>
                    <p class="card-text">Category: ' . htmlspecialchars($row["category"]) . '</p>
                    <p class="price"><strong>₱' . number_format($row["price"], 2) . '</strong></p>
                    <button class="btn btn-primary add-to-cart-btn"
                      data-id="' . $row['id'] . '"
                      data-name="' . htmlspecialchars($row["name"]) . '"
                      data-price="' . $row['price'] . '"
                      data-image="' . htmlspecialchars($row["image"]) . '"
                      data-bs-toggle="modal"
                      data-bs-target="#addToCartModal">
                      Add to Cart
                    </button>
                  </div>
                </div>
              </div>';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add to Cart Modal -->
  <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form method="POST" action="cart.php" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addToCartModalLabel">Add to Cart</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="product_id" id="modalProductId">
          <input type="hidden" name="product_name" id="modalProductName">
          <input type="hidden" name="product_price" id="modalProductPrice">
          <input type="hidden" name="product_image" id="modalProductImage">

          <div class="mb-3">
            <label for="productQuantity" class="form-label">Quantity</label>
            <input type="number" name="product_quantity" id="productQuantity" class="form-control" min="1" value="1" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Add to Cart</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal Script -->
  <script>
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
      button.addEventListener('click', () => {
        document.getElementById('modalProductId').value = button.dataset.id;
        document.getElementById('modalProductName').value = button.dataset.name;
        document.getElementById('modalProductPrice').value = button.dataset.price;
        document.getElementById('modalProductImage').value = button.dataset.image;
      });
    });
  </script>
</body>
</html>