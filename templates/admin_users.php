<!DOCTYPE html>
<html>
<head>
    <title>Admin - User List | CampusMart</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<?php
session_start();
include "../actions/database.php";
include "../actions/crypto.php";

/* Optional: check if admin is logged in */
if(!isset($_SESSION["admin_id"])){
    header("Location: admin_login.php");
    exit();
}

/* Fetch users */
$result = $conn->query("SELECT * FROM users");
?>

<nav class="navbar">
    <h2>CampusMart Admin</h2>
    <div>
        <a href="admin_dashboard.php">Dashboard</a>
        <a href="../actions/logout.php">Logout</a>
    </div>
</nav>

<div class="container">

<h1>User List</h1>

<!-- Success/Error messages -->
<?php
if(isset($_SESSION["error"])){
    echo "<div class='alert error'>".$_SESSION["error"]."</div>";
    unset($_SESSION["error"]);
}

if(isset($_SESSION["success"])){
    echo "<div class='alert success'>".$_SESSION["success"]."</div>";
    unset($_SESSION["success"]);
}
?>

<table class="styled-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars(decryptData($row['username'])); ?></td>
            <td><?php echo htmlspecialchars(decryptData($row['email'])); ?></td>
            <td><?php echo htmlspecialchars(decryptData($row['phone'])); ?></td>
            <td>
                <!-- Example action button -->
                <a href="../actions/ban_user.php?id=<?php echo $row['id']; ?>" class="action-btn ban-btn" onclick="return confirm('Are you sure you want to ban this user?');">Ban</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

</div>

</body>
</html>