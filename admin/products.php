<?php
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_name'])) {
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $category = $_POST['product_category'];

    $image = $_FILES['product_image'];
    $imageName = time() . "_" . basename($image["name"]);
    $imagePath = "../assets/images/" . $imageName;

    if (!is_dir("../assets/images")) {
        mkdir("../assets/images", 0777, true);
    }

    move_uploaded_file($image["tmp_name"], $imagePath);

    $stmt = $pdo->prepare("SELECT * FROM products WHERE name = ?");
    $stmt->execute([$name]);
    $existingProduct = $stmt->fetch();

    if ($existingProduct) {
        $newStock = $existingProduct['stock'] + 1;
        $stmt = $pdo->prepare("UPDATE products SET stock = ?, price = ?, category = ?, image = ? WHERE name = ?");
        $stmt->execute([$newStock, $price, $category, $imagePath, $name]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO products (name, price, category, image, stock) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $price, $category, $imagePath, 1]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = (int) $_POST['quantity'];

    if ($quantity > 0) {
        $stmt = $pdo->prepare("UPDATE products SET stock = stock + ? WHERE id = ?");
        $stmt->execute([$quantity, $productId]);
    }

    header("Location: products.php");
    exit;

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product_id'])) {
    $productId = $_POST['delete_product_id'];

    // Optional: Delete the image file from server
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if ($product && file_exists($product['image'])) {
        unlink($product['image']);
    }

    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$productId]);

    header("Location: products.php");
    exit;
}
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
                <p>Products</p>

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
                                        <p class="card-text">Stock: ' . htmlspecialchars($row["stock"]) . '</p>
                                        <p class="price"><strong>₱' . number_format($row["price"], 2) . '</strong></p>
                                        <button type="button" class="btn btn-secondary mt-2" data-bs-toggle="modal" data-bs-target="#addStockModal' . $row['id'] . '">Add Stock</button>

                                        <form method="POST" action="products.php" onsubmit="return confirm(\'Are you sure you want to delete this product?\');" style="display:inline;">
                                            <input type="hidden" name="delete_product_id" value="' . $row['id'] . '">
                                            <button type="submit" class="btn btn-danger mt-2">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Stock Modal -->
                            <div class="modal fade" id="addStockModal' . $row['id'] . '" tabindex="-1" aria-labelledby="addStockModalLabel' . $row['id'] . '" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="products.php">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addStockModalLabel' . $row['id'] . '">Add Stock for ' . htmlspecialchars($row['name']) . '</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="product_id" value="' . $row['id'] . '">
                                                <div class="mb-3">
                                                    <label for="quantity' . $row['id'] . '" class="form-label">Quantity</label>
                                                    <input type="number" class="form-control" id="quantity' . $row['id'] . '" name="quantity" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Add Stock</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>';
                        }
                        ?>

                        <!-- Add New Product Card -->
                        <div class="col-md-4">
                            <div class="card"
                                style="border: 2px dashed #ccc; background-color: #f9f9f9; cursor: pointer; width: 90%;"
                                data-bs-toggle="modal" data-bs-target="#addProductModal">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Add Product</h5>
                                    <p class="card-text">Click here to add a new product.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="products.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" id="productName" name="product_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Price (₱)</label>
                            <input type="number" id="productPrice" name="product_price" class="form-control" required
                                step="0.01">
                        </div>
                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Category</label>
                            <select id="productCategory" name="product_category" class="form-select" required>
                                <option value="" disabled selected>Select category</option>
                                <option value="submariner">Submariner</option>
                                <option value="date_just">Date Just</option>
                                <option value="gmt">GMT</option>
                                <option value="explorer">Explorer</option>
                                <option value="daytona">Daytona</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="productImage" class="form-label">Product Image</label>
                            <input type="file" id="productImage" name="product_image" class="form-control"
                                accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>