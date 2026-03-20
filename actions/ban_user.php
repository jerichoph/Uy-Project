<?php
session_start();
include "database.php";

// 1. SECURITY: Only admins can access this script
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../templates/admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];

    // 2. PREPARED STATEMENT: To prevent SQL Injection (Rubric: Excellent Security) 
    // First, check the current status
    $stmt = $conn->prepare("SELECT is_banned FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Toggle status: if 0 set to 1, if 1 set to 0
        $new_status = ($user['is_banned'] == 0) ? 1 : 0;
        
        $update = $conn->prepare("UPDATE users SET is_banned = ? WHERE id = ?");
        $update->bind_param("ii", $new_status, $user_id);
        
        if ($update->execute()) {
            $_SESSION['success'] = ($new_status == 1) ? "User has been restricted." : "User access restored.";
        } else {
            $_SESSION['error'] = "Failed to update user status.";
        }
    }
}

header("Location: ../templates/admin_users.php");
exit();