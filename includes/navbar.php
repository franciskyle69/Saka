<?php
ini_set('session.cookie_path', '/');

session_start();
include 'db.php'; // Ensure this connects to your DB

$role = $_SESSION['role'] ?? null;


?>
<head> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-2 shadow-sm">
  <a class="navbar-brand d-flex align-items-center text-white fw-bold" href="#">
    <img src="../assets/images/logo.png" alt="Logo" width="40" class="me-2">
    SAKA BUKIT
  </a>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

      <li class="nav-item">
        <a class="nav-link text-white" href="<?= $role === 'admin' ? '../admin/index.php' : '../user/index.php' ?>">Dashboard</a>
      </li>

      <?php if ($role === 'admin'): ?>
        <li class="nav-item"><a class="nav-link text-white" href="../admin/products.php">Products</a></li>
        
        <li class="nav-item"><a class="nav-link text-white" href="../admin/accounts.php">Accounts</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="../admin/settings.php">Settings</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="../admin/reports.php">Reports</a></li>
        
      <?php elseif ($role === 'user'): ?>
        <li class="nav-item"><a class="nav-link text-white" href="../user/products.php">Products</a></li>
        
      
        <li class="nav-item"><a class="nav-link text-white" href="../user/settings.php">Settings</a></li>

        

      <?php endif; ?>

    </ul>

    <div class="d-flex align-items-center text-white">
      <a href="<?= $role === 'admin' ? '../admin/cart.php' : '../user/cart.php' ?>" class="me-3 text-white">
        <i class="bi bi-cart" style="font-size: 1.4rem;"></i>
      </a>

      <span class="me-2 fw-semibold"><?= htmlspecialchars($role); ?></span>
      <i class="bi bi-person-circle me-3" style="font-size: 1.6rem;"></i>

      <a href="#" class="btn btn-outline-light btn-sm" onclick="confirmLogout(event)">Logout</a>
      <script>
function confirmLogout(e) {
    e.preventDefault();
    if (confirm("Are you sure you want to log out?")) {
        window.location.href = "../logout.php";
    }
}
</script>


    </div>
  </div>
</nav>
