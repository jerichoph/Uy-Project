<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusMart | Student Marketplace</title>
    <link rel="stylesheet" href="/CampusMart/css/style.css">
</head>
<body onload="<?php 
    if(isset($_SESSION['error']) || isset($_SESSION['success'])) { 
        echo "openModal('loginModal')"; 
    } elseif(isset($_SESSION['reg_error'])) { 
        echo "openModal('regModal')"; 
    } 
?>">

    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">CAMPUS<span>MART</span></a>
            <div class="nav-links">
                <a href="javascript:void(0)" onclick="openModal('loginModal')">Login</a>
                <a href="javascript:void(0)" onclick="openModal('regModal')" class="btn-primary">Get Started</a>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="container">
            <h1>Upgrade Your <br><span class="highlight">Campus Lifestyle.</span></h1>
            <p>The exclusive hub for students to swap gear, sell textbooks, and find dorm essentials.</p>
            <div class="hero-btns">
                <a href="javascript:void(0)" onclick="openModal('loginModal')" class="btn-primary">Start Browsing</a>
            </div>
        </div>
    </header>

    <section class="features">
        <div class="container">
            <div class="feature-grid">
                <div class="feature-card">
                    <div class="icon">⚡</div>
                    <h3>Quick Trades</h3>
                    <p>Chat and meet up between classes. No shipping, no wait times.</p>
                </div>
                <div class="feature-card">
                    <div class="icon">💎</div>
                    <h3>Student Deals</h3>
                    <p>Access exclusive pricing on tech and textbooks from seniors.</p>
                </div>
                <div class="feature-card">
                    <div class="icon">🛡️</div>
                    <h3>Trusted Only</h3>
                    <p>Every seller is a verified student. No scammers, just campus peers.</p>
                </div>
            </div>
        </div>
    </section>

    <div id="loginModal" class="modal-overlay <?php if(isset($_SESSION['error']) || isset($_SESSION['success'])) echo 'no-anim'; ?>">
        <div class="modal-content <?php if(isset($_SESSION['error']) || isset($_SESSION['success'])) echo 'no-anim'; ?>">
            <span class="close-btn" onclick="closeModal('loginModal')">&times;</span>
            <div class="center-text">
                <h2>User Login</h2>
                <?php
                if(isset($_SESSION["success"])){
                    echo "<p class='success-text'>".$_SESSION["success"]."</p>";
                    unset($_SESSION["success"]);
                } elseif(isset($_SESSION["error"])){
                    echo "<p class='error-text'>".$_SESSION["error"]."</p>";
                    unset($_SESSION["error"]);
                } else {
                    echo "<p style='color: var(--text-dim);'>Welcome back! Please enter your details.</p>";
                }
                ?>
            </div>
            <form action="actions/login.php" method="POST" class="modal-form">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%;">Login</button>
            </form>
            <div class="center-text" style="margin-top: 20px;">
                <p style="font-size: 0.9rem; color: var(--text-dim);">
                    New here? <a href="javascript:void(0)" onclick="switchModal('loginModal', 'regModal')" style="color: var(--accent);">Create an account</a>
                </p>
            </div>
        </div>
    </div>

    <div id="regModal" class="modal-overlay <?php if(isset($_SESSION['reg_error'])) echo 'no-anim'; ?>">
        <div class="modal-content <?php if(isset($_SESSION['reg_error'])) echo 'no-anim'; ?>">
            <span class="close-btn" onclick="closeModal('regModal')">&times;</span>
            <div class="center-text">
                <h2>Create Account</h2>
                <?php
                if(isset($_SESSION["reg_error"])){
                    echo "<p class='error-text'>".$_SESSION["reg_error"]."</p>";
                    unset($_SESSION["reg_error"]);
                } else {
                    echo "<p style='color: var(--text-dim);'>Join the marketplace today.</p>";
                }
                ?>
            </div>
            <form action="actions/register.php" method="POST" class="modal-form">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="johndoe123" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="student@campus.edu" required>
                </div>
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone" placeholder="09123456789">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Min. 8 characters" pattern="[A-Za-z0-9]{8,}" required>
                </div>
                <button type="submit" class="btn-primary" style="width: 100%;">Register Now</button>
            </form>
            <div class="center-text" style="margin-top: 20px;">
                <p style="font-size: 0.9rem; color: var(--text-dim);">
                    Already have an account? <a href="javascript:void(0)" onclick="switchModal('regModal', 'loginModal')" style="color: var(--accent);">Login here</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.style.display = "flex";
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.style.display = "none";
            }
        }

        function switchModal(closeId, openId) {
            closeModal(closeId);
            openModal(openId);
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.style.display = "none";
            }
        };
    </script>
</body>
</html>