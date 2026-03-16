<?php
session_start();
include "../actions/database.php";
include "../actions/crypto.php";

if(!isset($_SESSION['user_id'])){
    header("Location: user_login.html");
    exit();
}

$id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username,email,phone FROM users WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$username = decryptData($user['username']);
$email = decryptData($user['email']);
$phone = decryptData($user['phone']);
?>

<!DOCTYPE html>
    <html>
    <head>
    <title>User Profile</title>
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>

    <div class="container">
        <a href="user_dashboard.php" class="back-btn">← Back</a>

        <h1>My Profile</h1>

        <div class="card">
            <p><b>Username:</b> <?php echo htmlspecialchars($username); ?></p>
            <p><b>Email:</b> <?php echo htmlspecialchars($email); ?></p>
            <p><b>Phone:</b> <?php echo htmlspecialchars($phone); ?></p>
        </div>

        <h2>Update Profile</h2>

        <form action="../actions/update_profile.php" method="POST">

            Username
            <input type="text" name="username" value="<?php echo $username ?>">

            Phone
            <input type="text" name="phone" value="<?php echo $phone ?>">

            New Password
            <input type="password" name="password">

        <button type="submit">Update</button>

        </form>

    </div>

</body>
</html>