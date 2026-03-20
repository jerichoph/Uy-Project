<?php
session_start();
include "database.php";
include "crypto.php";

/* Check login */
if(!isset($_SESSION['user_id'])){
    header("Location: ../templates/user_login.php");
    exit();
}

/* Ensure POST request */
if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: ../templates/profile.php");
    exit();
}

$id = $_SESSION['user_id'];

/* Sanitize inputs */
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);

/* Cleanup */
$username = trim($username ?? "");
$phone = trim($phone ?? "");
$password = trim($password ?? "");

/* Validate username */
if($username === ""){
    $_SESSION["error"] = "Username cannot be empty.";
    header("Location: ../templates/profile.php");
    exit();
}

if(!preg_match("/^[A-Za-z0-9]+$/", $username)){
    $_SESSION["error"] = "Username must be alphanumeric only.";
    header("Location: ../templates/profile.php");
    exit();
}

/* Validate phone (optional) */
if(!empty($phone) && !preg_match("/^[0-9]+$/", $phone)){
    $_SESSION["error"] = "Phone number must contain numbers only.";
    header("Location: ../templates/profile.php");
    exit();
}

/* Validate password if provided */
if(!empty($password)){
    if(strlen($password) < 8){
        $_SESSION["error"] = "Password must be at least 8 characters.";
        header("Location: ../templates/profile.php");
        exit();
    }

    if(!preg_match("/^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]+$/", $password)){
        $_SESSION["error"] = "Password must contain letters and numbers only.";
        header("Location: ../templates/profile.php");
        exit();
    }
}

/* Encrypt fields */
$enc_username = encryptData($username);
$enc_phone = encryptData($phone);

/* Update query */
if(!empty($password)){
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET username=?, phone=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $enc_username, $enc_phone, $password_hash, $id);
}else{
    $stmt = $conn->prepare("UPDATE users SET username=?, phone=? WHERE id=?");
    $stmt->bind_param("ssi", $enc_username, $enc_phone, $id);
}

$stmt->execute();

/* Update session (decrypted username for display) */
$_SESSION['username'] = $username;

$_SESSION['success'] = "Profile updated successfully!";
header("Location: ../templates/profile.php");
exit();
?>