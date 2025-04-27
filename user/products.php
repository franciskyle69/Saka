<?php
include '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Products</title>

  <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="styles/styles.css">
  <link rel="icon" type="image/png" href="../assets/images/logo.png">

  <style>
    .product-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .product-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-title {
      font-size: 1rem;
      font-weight: 600;
    }

    .btn-block {
      font-weight: bold;
    }

    .sidebar-categories {
      background-color: rgba(200, 200, 200, 0.3);
      padding: 1rem;
      border-radius: 10px;
    }

    .category-link {
      color: #333;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s ease-in-out;
    }

    .category-link:hover {
      color: #007bff;
      text-decoration: underline;
    }
  </style>
</head>

<body>

  <?php include '../includes/navbar.php'; ?>

  <div class="container mt-5">
    <h2 class="text-center mb-4 font-weight-bold">Products</h2>

    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 mb-4">
        <div class="sidebar-categories">
          <h5 class="font-weight-bold mb-3">Categories</h5>
          <ul class="list-unstyled">
            <li class="mb-2"><a href="#" class="category-link">All</a></li>
            <li class="mb-2"><a href="#" class="category-link">Jackets</a></li>
            <li class="mb-2"><a href="#" class="category-link">Backpacks</a></li>
            <li class="mb-2"><a href="#" class="category-link">Footwear</a></li>
            <li class="mb-2"><a href="#" class="category-link">Accessories</a></li>
          </ul>
        </div>
      </div>

      <!-- Product Listing -->
      <div class="col-md-9">
        <div class="row">
          <?php
          $stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
          while ($row = $stmt->fetch()) {
            echo '
            <div class="col-md-4 mb-4">
              <div class="card h-100 shadow-sm border-0 product-card">
                <img src="' . htmlspecialchars($row["image"]) . '" class="card-img-top" alt="Product Image">
                <div class="card-body d-flex flex-column justify-content-between">
                  <div>
                    <h5 class="card-title">' . htmlspecialchars($row["name"]) . '</h5>
                    <p class="text-muted mb-1">₱' . number_format($row["price"], 2) . '</p>
                    <div class="text-warning mb-2">★★★★☆</div>
                  </div>
                  <form method="POST" action="cart.php" class="mt-auto">
                    <input type="hidden" name="product_id" value="' . $row["id"] . '">
                    <input type="hidden" name="product_name" value="' . htmlspecialchars($row["name"]) . '">
                    <input type="hidden" name="product_price" value="' . $row["price"] . '">
                    <input type="hidden" name="product_image" value="' . htmlspecialchars($row["image"]) . '">
                    <input type="hidden" name="product_quantity" value="1">
                    <button type="submit" class="btn btn-primary btn-block">Add to Cart</button>
                  </form>
                </div>
              </div>
            </div>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>

</body>

</html>