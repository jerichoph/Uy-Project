<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Login | CampusMart</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container center">

    <h2>Admin Login</h2>

    <?php
    session_start();
    if(isset($_SESSION["error"])){
        echo "<div class='alert error'>".$_SESSION["error"]."</div>";
        unset($_SESSION["error"]);
    }
    ?>

    <form action="../actions/admin_login.php" method="POST">

        Username<br>
        <input type="text" name="username" required><br><br>

        Password<br>
        <input type="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>

    </form>

</div>

</body>
</html>