<?php

include "database.php";

$name = sanitize($_POST['name']);
$price = sanitize($_POST['price']);
$desc = sanitize($_POST['description']);

$stmt = $conn->prepare("INSERT INTO products(name,price,description) VALUES(?,?,?)");

$stmt->bind_param("sis",$name,$price,$desc);

$stmt->execute();

header("Location: ../templates/admin_products.php");

?>