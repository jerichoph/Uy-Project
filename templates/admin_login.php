<?php
session_start();

// If already logged in, skip the login page
if(isset($_SESSION["admin_id"])){
    header("Location: admin_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | CampusMart</title>
    <link rel="stylesheet" href="/CampusMart/css/style.css">
</head>
<body class="admin-body">

    <div class="container" style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
        
        <div class="card admin-login-card" style="max-width: 400px; width: 100%;">
            
            <div class="center-text" style="margin-bottom: 30px;">
                <div class="admin-badge">ADMIN PORTAL</div>
                <h2 style="margin-top: 15px;">Secure Access</h2>
                <p style="color: var(--text-dim); font-size: 0.9rem;">Please enter administrative credentials.</p>
            </div>

            <?php
            if(isset($_SESSION["error"])){
                echo "<p class='error-text'>" . htmlspecialchars($_SESSION["error"]) . "</p>";
                unset($_SESSION["error"]);
            }
            ?>

            <form action="../actions/admin_login.php" method="POST" class="modal-form">
                
                <div class="form-group">
                    <label>Admin Username</label>
                    <input type="text" name="username" pattern="[A-Za-z0-9]+" required placeholder="e.g. sys_admin">
                </div>

                <div class="form-group">
                    <label>Secret Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>

                <button type="submit" name="login" class="btn-primary" style="width: 100%; background: #ff4d4d; color: white !important;">
                    Authorize Access
                </button>

            </form>

            <div class="center-text" style="margin-top: 25px;">
                <a href="index.php" style="color: var(--text-dim); text-decoration: none; font-size: 0.8rem;">← Return to Main Site</a>
            </div>

        </div>

    </div>

</body>
</html>