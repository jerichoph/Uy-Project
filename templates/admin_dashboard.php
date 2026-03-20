<?php
session_start();

/* 1. ADMIN SECURITY: Check if admin is logged in */
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include "../actions/database.php";

/* 2. OPTIONAL: Get quick stats for the dashboard */
$userCount = $conn->query("SELECT COUNT(id) as total FROM users")->fetch_assoc()['total'];
$productCount = $conn->query("SELECT COUNT(id) as total FROM products")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | CampusMart</title>
    <link rel="stylesheet" href="/CampusMart/css/style.css">
</head>
<body class="admin-body">

    <nav class="navbar" style="border-bottom: 2px solid #ff4d4d33;">
        <div class="nav-container">
            <a href="admin_dashboard.php" class="logo">ADMIN<span>PANEL</span></a>
            <div class="nav-links">
                <span style="color: var(--text-dim); margin-right: 15px;">System Administrator</span>
                <a href="../actions/logout.php" class="btn-secondary" style="border-color: #ff4d4d; color: #ff4d4d !important;">Secure Logout</a>
            </div>
        </div>
    </nav>

    <main class="container">
        <header class="dashboard-header">
            <div class="admin-badge">SYSTEM OVERVIEW</div>
            <h1 style="margin-top: 10px;">Control Center</h1>
            <p style="color: var(--text-dim);">Monitor campus activity and manage marketplace listings.</p>
        </header>

        <div class="feature-grid" style="margin-bottom: 40px;">
            <div class="feature-card" style="border-left: 4px solid var(--accent);">
                <div class="icon" style="background: rgba(0, 255, 136, 0.1); color: var(--accent);">👥</div>
                <h3><?php echo $userCount; ?></h3>
                <p>Registered Students</p>
            </div>
            <div class="feature-card" style="border-left: 4px solid #00d4ff;">
                <div class="icon" style="background: rgba(0, 212, 255, 0.1); color: #00d4ff;">📦</div>
                <h3><?php echo $productCount; ?></h3>
                <p>Active Listings</p>
            </div>
            <div class="feature-card" style="border-left: 4px solid #ffcc00;">
                <div class="icon" style="background: rgba(255, 204, 0, 0.1); color: #ffcc00;">🛡️</div>
                <h3>System</h3>
                <p>Status: Operational</p>
            </div>
        </div>

        <h2 style="font-size: 1.1rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; color: var(--text-dim);">Management Modules</h2>
        
        <div class="product-grid" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
            
            <div class="card" style="padding: 40px;">
                <h2 style="margin-bottom: 10px;">User Database</h2>
                <p style="margin-bottom: 25px;">View, edit, or restrict student accounts. Monitor user registration and verify student status.</p>
                <a href="admin_users.php" class="btn-primary" style="background: #30363d; color: white !important; width: 100%; text-align: center; border: 1px solid var(--border);">Open User Manager</a>
            </div>

            <div class="card" style="padding: 40px;">
                <h2 style="margin-bottom: 10px;">Inventory Control</h2>
                <p style="margin-bottom: 25px;">Review all items listed on CampusMart. Remove prohibited items or resolve listing reports.</p>
                <a href="admin_products.php" class="btn-primary" style="background: #30363d; color: white !important; width: 100%; text-align: center; border: 1px solid var(--border);">Open Product Manager</a>
            </div>

        </div>

    </main>

    <footer style="margin-top: 100px; padding: 40px 0; border-top: 1px solid var(--border); text-align: center;">
        <p style="color: var(--text-dim); font-size: 0.8rem; letter-spacing: 1px;">CAMPUSMART ADMIN v1.0.4 | ENCRYPTED SESSION</p>
    </footer>

</body>
</html>