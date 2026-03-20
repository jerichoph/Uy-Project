<?php
session_start();
include "../actions/database.php";

/* 1. SESSION SECURITY: Redirect if not logged in */
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

/* 2. FETCH PRODUCTS: Reverted to your original columns to avoid SQL errors */
$query = "SELECT id, name, price, description FROM products ORDER BY id DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketplace | CampusMart</title>
    <link rel="stylesheet" href="/CampusMart/css/style.css">
</head>
<body class="dashboard-body">

    <nav class="navbar">
        <div class="nav-container">
            <a href="user_dashboard.php" class="logo">CAMPUS<span>MART</span></a>
            <div class="nav-links">
                <a href="user_dashboard.php" class="active">Home</a>
                <a href="profile.php">My Profile</a>
                <a href="orders.php">My Purchases</a>
                <a href="../actions/logout.php" class="btn-secondary">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container">
        <header class="dashboard-header">
            <h1>Campus Marketplace</h1>
            <p style="color: var(--text-dim);">Browse available items from your campus community.</p>

            <div class="search-wrap" style="margin-top: 30px;">
                <input type="text" placeholder="What are you looking for today?" style="max-width: 600px; width: 100%;">
            </div>
        </header>

        <section class="marketplace-section">
            <div class="section-title-bar">
                <h2 style="font-size: 1rem; text-transform: uppercase; letter-spacing: 1px;">Available Products</h2>
            </div>

            <div class="product-grid">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): 
                        $id = $row['id'];
                        $name = htmlspecialchars($row['name']);
                        $price = number_format($row['price'], 2);
                        $description = htmlspecialchars($row['description']);
                    ?>
                        <div class="card">
                            <h3><?php echo $name; ?></h3>
                            <span class="price-tag">₱<?php echo $price; ?></span>
                            
                            <p><?php echo (strlen($description) > 95) ? substr($description, 0, 92) . '...' : $description; ?></p>
                            
                            <div class="card-footer" style="margin-top: auto;">
                                <a href="product_details.php?id=<?php echo $id; ?>" class="btn-buy" style="display: block; width: 100%; text-align: center;">View Item</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state" style="grid-column: 1 / -1;">
                        <div style="font-size: 3rem; margin-bottom: 20px;">🛍️</div>
                        <h3>No Items Available</h3>
                        <p>Check back later! New items are added by students daily.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer style="padding: 60px 0; border-top: 1px solid var(--border); margin-top: 80px;">
        <div class="container center-text">
            <p style="color: var(--text-dim); font-size: 0.9rem;">&copy; 2026 CampusMart. For Student Use Only.</p>
        </div>
    </footer>

</body>
</html>