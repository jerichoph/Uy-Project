<?php
session_start();
include "database.php";
include "crypto.php";

if(isset($_POST["login"])){

    $username_input = trim($_POST["username"]);
    $password_input = $_POST["password"];

    // Fetch all admins
    $result = $conn->query("SELECT * FROM admins");
    $found = false;

    while($admin = $result->fetch_assoc()){
        // Decrypt username from DB
        $dec_username = decryptData($admin["username"]);

        // Compare username and password
        if($dec_username === $username_input && password_verify($password_input, $admin["password"])){

            // Set session with decrypted info
            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_username"] = $dec_username;
            $_SESSION["admin_email"] = decryptData($admin["email"]);

            $found = true;
            header("Location: ../templates/admin_dashboard.php");
            exit();
        }
    }

    if(!$found){
        $_SESSION["error"] = "Invalid admin login.";
        header("Location: ../templates/admin_login.php");
        exit();
    }
}
?>