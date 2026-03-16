<?php
include "database.php";
include "crypto.php";

/* ID of the admin account to encrypt/update */
$admin_id = 1; // change if needed

/* Fetch existing admin data */
$stmt = $conn->prepare("SELECT * FROM admins WHERE id=?");
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0){
    die("Admin not found.");
}

$admin = $result->fetch_assoc();

/* Encrypt email */
$enc_email = encryptData($admin["email"]);

/* Set a username for login (replace 'admin' with your desired username) and encrypt it */
$admin_username = "admin"; // the login username you want
$enc_username = encryptData($admin_username);

/* Update the admin account with encrypted username and email */
$update = $conn->prepare("UPDATE admins SET username=?, email=? WHERE id=?");
$update->bind_param("ssi", $enc_username, $enc_email, $admin_id);
$update->execute();

echo "Admin account updated with encrypted username and email!";
?>