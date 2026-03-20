<?php
session_start();

if(isset($_SESSION["error"])){
    echo "<div class='alert error'>".$_SESSION["error"]."</div>";
    unset($_SESSION["error"]);
}

if(isset($_SESSION["success"])){
    echo "<div class='alert success'>".$_SESSION["success"]."</div>";
    unset($_SESSION["success"]);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Products - CampusMart</title>
    <link rel="stylesheet" href="/CampusMart/css/style.css">
</head>
<body>
    <h2>User Login</h2>

    <form action="../actions/login.php" method="POST">

        Username<br>
        <input type="text" name="username" required>

        Password<br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>

    </form>
</body>
</html>