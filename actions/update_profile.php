<?php
session_start();
include "database.php";
include "crypto.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../templates/user_login.php");
    exit();
}

$id = $_SESSION['user_id'];

$username = trim($_POST['username']);
$phone = trim($_POST['phone']);
$password = $_POST['password'];

/* Encrypt username and phone before saving */
$enc_username = encryptData($username);
$enc_phone = encryptData($phone);

if(!empty($password)){
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET username=?, phone=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $enc_username, $enc_phone, $password_hash, $id);
}else{
    $stmt = $conn->prepare("UPDATE users SET username=?, phone=? WHERE id=?");
    $stmt->bind_param("ssi", $enc_username, $enc_phone, $id);
}

$stmt->execute();

/* Update session username to show updated name */
$_SESSION['username'] = $username; // store decrypted version in session for display

$_SESSION['success'] = "Profile updated successfully!";
header("Location: ../templates/profile.php");
exit();
?>