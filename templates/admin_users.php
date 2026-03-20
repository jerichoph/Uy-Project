<?php
session_start();
include "../actions/database.php";
include "../actions/crypto.php";

/* 1. ADMIN SECURITY CHECK */
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

/* 2. FETCH USERS (Added 'is_banned' to the SELECT statement) */
$result = $conn->query("SELECT id, username, email, phone, is_banned FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users | CampusMart Admin</title>
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
            <div class="admin-badge">USER DATABASE</div>
            <h1>Registered Students</h1>
            <p style="color: var(--text-dim);">Review account details and manage system access.</p>
        </header>

        <?php if (isset($_SESSION["error"])): ?>
            <div class="error-text" style="margin-bottom: 20px;">
                <?php echo htmlspecialchars($_SESSION["error"]); unset($_SESSION["error"]); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION["success"])): ?>
            <div class="success-text" style="margin-bottom: 20px;">
                <?php echo htmlspecialchars($_SESSION["success"]); unset($_SESSION["success"]); ?>
            </div>
        <?php endif; ?>

        <div class="card" style="padding: 0; overflow: hidden; border-radius: 15px;">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Username</th>
                        <th>Email Address</th>
                        <th>Contact Number</th>
                        <th style="text-align: right;">Management</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <?php 
                                // This logic MUST stay inside the while loop to access $row
                                $is_banned = $row['is_banned'] ?? 0; 
                                $btn_text = ($is_banned == 1) ? "Unban User" : "Restrict Access";
                                
                                // If banned, we make the button look like a "restore" button (Green/Accent)
                                // If not banned, it stays the default "Restrict" look (Red)
                                $btn_style = ($is_banned == 1) ? "border-color: var(--accent); color: var(--accent);" : "";
                            ?>
                            <tr>
                                <td class="id-column">#<?php echo $row['id']; ?></td>
                                <td style="font-weight: 600; color: var(--accent);">
                                    <?php echo htmlspecialchars(decryptData($row['username'])); ?>
                                </td>
                                <td style="color: var(--text-main); opacity: 0.9;">
                                    <?php echo htmlspecialchars(decryptData($row['email'])); ?>
                                </td>
                                <td style="color: var(--text-dim);">
                                    <?php echo htmlspecialchars(decryptData($row['phone'])); ?>
                                </td>
                                <td style="text-align: right;">
                                    <a href="../actions/ban_user.php?id=<?php echo $row['id']; ?>" 
                                       class="btn-restrict" 
                                       style="<?php echo $btn_style; ?>"
                                       onclick="return confirm('Are you sure you want to change this student\'s access?');">
                                        <?php echo $btn_text; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: var(--text-dim);">
                                No registered students found in database.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer style="margin-top: 60px; text-align: center; padding-bottom: 40px;">
        <p style="color: var(--text-dim); font-size: 0.8rem;">Authorized Personnel Only</p>
    </footer>

</body>
</html>