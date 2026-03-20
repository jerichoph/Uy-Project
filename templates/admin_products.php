<?php
session_start();
include "../actions/database.php";

/* 1. ADMIN SECURITY CHECK */
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

/* 2. FETCH PRODUCTS */
$result = $conn->query("SELECT id, name, price, description FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products | CampusMart Admin</title>
    <link rel="stylesheet" href="/CampusMart/css/style.css">
</head>
<body class="admin-body">

    <nav class="navbar">
        <div class="nav-container">
            <a href="admin_dashboard.php" class="logo">ADMIN<span>PANEL</span></a>
            <div class="nav-links">
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="../actions/logout.php" class="btn-secondary">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container">
        <header class="dashboard-header">
            <div class="admin-badge">INVENTORY CONTROL</div>
            <h1>Product Management</h1>
            <p style="color: var(--text-dim);">Add new campus essentials or moderate existing listings.</p>
        </header>

        <div class="admin-grid" style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; align-items: start;">
            
            <section class="card">
                <h2 style="margin-bottom: 20px; font-size: 1.2rem; color: var(--accent);">Add New Listing</h2>
                <form action="../actions/add_product.php" method="POST" class="modal-form" style="margin-top: 0;">
                    
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="name" placeholder="e.g. Calculus Textbook" required>
                    </div>

                    <div class="form-group">
                        <label>Price (₱)</label>
                        <input type="number" name="price" placeholder="0.00" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label>Item Description</label>
                        <textarea name="description" placeholder="Condition, edition, etc..." required 
                                  style="width: 100%; padding: 14px; background: #0d1117; border: 1px solid var(--border); border-radius: 12px; color: white; min-height: 100px; font-family: inherit;"></textarea>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%;">Post to Marketplace</button>
                </form>
            </section>

            <section class="card" style="padding: 0; overflow: hidden;">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Info</th>
                            <th>Price</th>
                            <th style="text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): 
                                $id = (int)$row['id'];
                                $name = htmlspecialchars($row['name']);
                                $price = number_format($row['price'], 2);
                                $desc = htmlspecialchars($row['description']);
                            ?>
                                <tr>
                                    <td class="id-column">#<?php echo $id; ?></td>
                                    <td>
                                        <div style="font-weight: 600; color: var(--text-main);"><?php echo $name; ?></div>
                                        <div style="font-size: 0.75rem; color: var(--text-dim); margin-top: 4px;">
                                            <?php echo (strlen($desc) > 50) ? substr($desc, 0, 47) . '...' : $desc; ?>
                                        </div>
                                    </td>
                                    <td style="font-weight: 700; color: var(--accent);">₱<?php echo $price; ?></td>
                                    <td style="text-align: right;">
                                        <a href="../actions/delete_product.php?id=<?php echo $id; ?>" 
                                           class="btn-restrict"
                                           onclick="return confirm('Permanently remove this listing?')">
                                            Remove
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 60px; color: var(--text-dim);">
                                    No products currently listed.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>

    <footer style="margin-top: 80px; text-align: center; padding-bottom: 40px;">
        <p style="color: var(--text-dim); font-size: 0.8rem;">CampusMart Inventory System &copy; 2026</p>
    </footer>

</body>
</html>