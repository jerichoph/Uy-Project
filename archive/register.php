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
    <title>CampusMart Register</title>
    <link rel="stylesheet" href="/CampusMart/css/style.css">
</head>

<body>

<div class="container center">

    <h1>Create Account</h1>

        <form action="../actions/register.php" method="POST">

            Username
            <input type="text" name="username" required>

            Email
            <input type="email" name="email" required>

            Phone
            <input type="text" name="phone">

            Password
            <input type="password" name="password" pattern="[A-Za-z0-9]{8,}" required>

            <button type="submit">Register</button>

        </form>

    <a href="user_login.php">Already have an account?</a>

</div>

</body>
</html>