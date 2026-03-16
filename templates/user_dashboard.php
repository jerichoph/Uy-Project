<!DOCTYPE html>
<html>
<head>
    <title>Admin Products - CampusMart</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav class="navbar">
    <h2>CampusMart</h2>

    <div>
        <a href="user_dashboard.php">Home</a>
        <a href="profile.php">Profile</a>

        <a href="../actions/logout.php">Logout</a>
    </div>
</nav>

<h1>CampusMart Marketplace</h1>

<h2>Available Products</h2>

<?php

session_start();
include "../actions/database.php";

$result = $conn->query("SELECT * FROM products");

while($row=$result->fetch_assoc()){
    echo "<h3>".$row['name']."</h3>";
    echo "Price: ".$row['price']."<br>";
    echo $row['description']."<br><br>";
}

?>


</body>
</html>