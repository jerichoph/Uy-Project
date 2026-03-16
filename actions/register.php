<?php
session_start();
include "database.php";
include "crypto.php";

if(isset($_POST["username"], $_POST["email"], $_POST["password"])){

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"] ?? '');
    $password = $_POST["password"];

    /* Validate password length */
    if(strlen($password) < 8){
        $_SESSION["error"] = "Password must be at least 8 characters.";
        header("Location: ../templates/register.php");
        exit();
    }

    /* Require alphanumeric password */
    if(!preg_match("/^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]+$/", $password)){
        $_SESSION["error"] = "Password must contain letters and numbers only.";
        header("Location: ../templates/register.php");
        exit();
    }

    /* Encrypt fields for comparison */
    $enc_email = encryptData($email);
    $enc_username = encryptData($username);
    $enc_phone = encryptData($phone);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $enc_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $_SESSION["error"] = "Email already exists!";
        header("Location: ../templates/register.php");
        exit();
    }

    // Check if username already exists
    $stmt2 = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt2->bind_param("s", $enc_username);
    $stmt2->execute();
    $res2 = $stmt2->get_result();

    if($res2->num_rows > 0){
        $_SESSION["error"] = "Username already exists!";
        header("Location: ../templates/register.php");
        exit();
    }

    // Check if phone already exists (optional if phone is required to be unique)
    if(!empty($phone)){
        $stmt3 = $conn->prepare("SELECT * FROM users WHERE phone=?");
        $stmt3->bind_param("s", $enc_phone);
        $stmt3->execute();
        $res3 = $stmt3->get_result();

        if($res3->num_rows > 0){
            $_SESSION["error"] = "Phone number already exists!";
            header("Location: ../templates/register.php");
            exit();
        }
    }

    /* Hash password */
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    /* Insert user into DB */
    $stmt4 = $conn->prepare("INSERT INTO users (username,email,phone,password) VALUES (?,?,?,?)");
    $stmt4->bind_param("ssss",$enc_username,$enc_email,$enc_phone,$password_hash);
    $stmt4->execute();

    $_SESSION["success"] = "Registered Successfully!";
    header("Location: ../templates/user_login.php");
    exit();
}
?>