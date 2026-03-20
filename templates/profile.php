<?php
session_start();
include "../actions/database.php";
include "../actions/crypto.php";

/* 1. SESSION SECURITY */
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$id = $_SESSION['user_id'];

/* 2. FETCH USER DATA */
$stmt = $conn->prepare("SELECT username, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

/* 3. DECRYPT FOR DISPLAY */
$username = decryptData($user['username']);
$email = decryptData($user['email']);
$phone = decryptData($user['phone']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | CampusMart</title>
    <link rel="stylesheet" href="/CampusMart/css/style.css">
</head>
<body class="dashboard-body">

    <nav class="navbar">
        <div class="nav-container">
            <a href="user_dashboard.php" class="logo">CAMPUS<span>MART</span></a>
            <div class="nav-links">
                <a href="user_dashboard.php">Home</a>
                <a href="profile.php" class="active">My Profile</a>
                <a href="../actions/logout.php" class="btn-secondary">Logout</a>
            </div>
        </div>
    </nav>

    <main class="container" style="max-width: 800px;">
        <header class="dashboard-header">
            <a href="user_dashboard.php" class="btn-secondary" style="margin-bottom: 20px; display: inline-block; padding: 8px 15px;">← Back to Marketplace</a>
            <h1>Account Settings</h1>
            <p style="color: var(--text-dim);">Manage your personal information and security.</p>
        </header>

        <div class="profile-grid" style="display: grid; gap: 30px;">
            
            <section class="card">
                <h2 style="margin-bottom: 20px; font-size: 1.2rem; color: var(--accent);">Current Information</h2>
                <div class="info-group" style="margin-bottom: 15px;">
                    <label style="color: var(--text-dim); font-size: 0.8rem; text-transform: uppercase;">Username</label>
                    <p style="font-size: 1.1rem; font-weight: 600;"><?php echo htmlspecialchars($username); ?></p>
                </div>
                <div class="info-group" style="margin-bottom: 15px;">
                    <label style="color: var(--text-dim); font-size: 0.8rem; text-transform: uppercase;">Email Address</label>
                    <p style="font-size: 1.1rem; font-weight: 600;"><?php echo htmlspecialchars($email); ?></p>
                </div>
                <div class="info-group">
                    <label style="color: var(--text-dim); font-size: 0.8rem; text-transform: uppercase;">Phone Number</label>
                    <p style="font-size: 1.1rem; font-weight: 600;"><?php echo htmlspecialchars($phone); ?></p>
                </div>
            </section>

            <section class="card">
                <h2 style="margin-bottom: 20px; font-size: 1.2rem; color: var(--accent);">Update Profile</h2>
                
                <form action="../actions/update_profile.php" method="POST" class="modal-form" style="margin-top: 0;">
                    
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                    </div>

                    <div style="margin: 20px 0; border-top: 1px solid var(--border); padding-top: 20px;">
                        <h2 style="margin-bottom: 15px; font-size: 1.1rem;">Security</h2>
                        <div class="form-group">
                            <label>New Password (Leave blank to keep current)</label>
                            <input type="password" name="password" placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%;">Save Changes</button>
                </form>
            </section>

        </div>
    </main>

    <footer style="padding: 60px 0; text-align: center;">
        <p style="color: var(--text-dim); font-size: 0.9rem;">CampusMart &copy; 2026</p>
    </footer>

</body>
</html>