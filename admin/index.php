<?php 
include '../includes/navbar.php'; ?>   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <!-- External Stylesheets -->
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">


    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/logo.png">
</head>
<body>

        
        <!-- Main Content Section -->
     
        <div class="container mt-4">
            <!-- Dashboard Overview Content -->
            <div class="content p-4">
                <h1>Welcome to the Dashboard</h1>
                <p>Overview</p>

                <!-- Cards Side by Side -->
                <div class="row">
                    <!-- Sales Card -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <img src="/images/sales.png" class="card-img-top img-fluid p-3" alt="Sales">
                            <div class="card-body">
                                <h5 class="card-title">Sales</h5>
                                <p class="card-text fw-bold">₱500,000,000</p>
                                <p class="card-text"><small class="text-muted">Last updated 5 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Users Card -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <img src="/images/users.png" class="card-img-top img-fluid p-3" alt="Total Users">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <p class="card-text fw-bold">2,000 Users</p>
                                <p class="card-text"><small class="text-muted">Last updated 5 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Revenue Card -->
                    <div class="col-md-4">
                        <div class="card text-center">
                            <img src="/images/revenue.png" class="card-img-top img-fluid p-3" alt="Revenue">
                            <div class="card-body">
                                <h5 class="card-title">Revenue</h5>
                                <p class="card-text fw-bold">₱300,000,000</p>
                                <p class="card-text"><small class="text-muted">Last updated 5 mins ago</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Cards -->
                <form method="POST" action="../admin/simple_print.php" target="_blank" class="container mt-5">
                    <button type="submit" class="btn btn-primary">
                        Print Products
                    </button>
                </form>
            </div>
            </div>
            
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
