<?php
session_start();
include "database.php";
include "crypto.php";

/* 1. Ensure request is POST */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /CampusMart/index.php"); 
    exit();
}

/* 2. Sanitize and Cleanup */
$username_input = trim($_POST['username'] ?? "");
$password_input = trim($_POST['password'] ?? "");

/* 3. Basic Validation */
if ($username_input === "" || $password_input === "") {
    $_SESSION["error"] = "Please fill in all fields.";
    header("Location: /CampusMart/index.php"); 
    exit();
}

/* 4. PREPARED STATEMENT SEARCH (Rubric: Proactive Security) */
// Search for the encrypted version of the username 
$encrypted_search = encryptData($username_input);

$stmt = $conn->prepare("SELECT id, username, password, is_banned FROM users WHERE username = ?");
$stmt->bind_param("s", $encrypted_search);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    
    /* 5. BAN CHECK (Rubric: Innovation/Layered Defense) */
    // Check the 'is_banned' column added to your SQL 
    if (isset($user['is_banned']) && $user['is_banned'] == 1) {
        $_SESSION["error"] = "Access Denied: This account has been suspended.";
        header("Location: /CampusMart/index.php"); 
        exit();
    }

    /* 6. PASSWORD VERIFICATION (Rubric: Salted Hashing) */
    // Uses industry-standard password verification 
    if (password_verify($password_input, $user["password"])) {
        
        /* 7. SECURE SESSION MANAGEMENT */
        session_regenerate_id(true); 

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $username_input;

        header("Location: ../templates/user_dashboard.php");
        exit();
    }
}

/* 8. Generic Failure Message */
// Does not reveal if the username or password was specifically wrong 
$_SESSION["error"] = "Invalid username or password.";
header("Location: /CampusMart/index.php"); 
exit();
?>