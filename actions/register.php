<?php
session_start();
include "database.php";
include "crypto.php";

if($_SERVER["REQUEST_METHOD"] !== "POST"){
    header("Location: /CampusMart/index.php");
    exit();
}

$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$phone = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, "password", FILTER_UNSAFE_RAW);

$username = trim($username ?? "");
$email = trim($email ?? "");
$phone = trim($phone ?? "");
$password = trim($password ?? "");

if($username === "" || $email === "" || $password === ""){
    $_SESSION["reg_error"] = "Please fill in all required fields.";
    header("Location: /CampusMart/index.php");
    exit();
}

if(!preg_match("/^[A-Za-z0-9]+$/", $username)){
    $_SESSION["reg_error"] = "Username must be alphanumeric only.";
    header("Location: /CampusMart/index.php");
    exit();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $_SESSION["reg_error"] = "Invalid email format.";
    header("Location: /CampusMart/index.php");
    exit();
}

if(strlen($password) < 8){
    $_SESSION["reg_error"] = "Password must be at least 8 characters.";
    header("Location: /CampusMart/index.php");
    exit();
}

if(!preg_match("/^(?=.*[A-Za-z])(?=.*[0-9])[A-Za-z0-9]+$/", $password)){
    $_SESSION["reg_error"] = "Password must contain letters and numbers only.";
    header("Location: /CampusMart/index.php");
    exit();
}

if(!empty($phone) && !preg_match("/^[0-9]+$/", $phone)){
    $_SESSION["reg_error"] = "Phone number must contain numbers only.";
    header("Location: /CampusMart/index.php");
    exit();
}

$enc_username = encryptData($username);
$enc_email = encryptData($email);
$enc_phone = encryptData($phone);

$stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
$stmt->bind_param("s", $enc_email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $_SESSION["reg_error"] = "Email already exists!";
    header("Location: /CampusMart/index.php");
    exit();
}

$stmt2 = $conn->prepare("SELECT id FROM users WHERE username=?");
$stmt2->bind_param("s", $enc_username);
$stmt2->execute();
$res2 = $stmt2->get_result();

if($res2->num_rows > 0){
    $_SESSION["reg_error"] = "Username already exists!";
    header("Location: /CampusMart/index.php");
    exit();
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$stmt4 = $conn->prepare("INSERT INTO users (username,email,phone,password) VALUES (?,?,?,?)");
$stmt4->bind_param("ssss", $enc_username, $enc_email, $enc_phone, $password_hash);
$stmt4->execute();

if ($registration_successful) {
    $_SESSION['success'] = "Account created! You can now login.";
    header("Location: /CampusMart/index.php");
    exit();
} else {
    $_SESSION['reg_error'] = "Something went wrong.";
    header("Location: /CampusMart/index.php");
    exit();
}
?>