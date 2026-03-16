<?php
session_start();
include "database.php";
include "crypto.php"; 

$username_input = trim($_POST["username"]);
$password_input = $_POST["password"];

/* Fetch all users */
$result = $conn->query("SELECT * FROM users");

$found = false;

while($user = $result->fetch_assoc()){
    // Decrypt username from database
    $dec_username = decryptData($user["username"]);

    // Check username and password
    if($dec_username === $username_input && password_verify($password_input, $user["password"])){

        // Set session with decrypted username
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $dec_username;

        $found = true;
        header("Location: ../templates/user_dashboard.php");
        exit();
    }
}

if(!$found){
    $_SESSION["error"] = "Invalid login.";
    header("Location: ../templates/user_login.php");
    exit();
}
?>