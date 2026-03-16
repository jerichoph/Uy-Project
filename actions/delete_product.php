<?php
session_start();
include "database.php";

// Check if admin is logged in
if(!isset($_SESSION['admin_id'])){
    header("Location: ../templates/admin_login.php");
    exit();
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Redirect back to admin products page
header("Location: ../templates/admin_products.php");
exit();
?>