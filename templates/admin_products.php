<!DOCTYPE html>
<html>
<head>
    <title>Admin Products - CampusMart</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
session_start();
include "../actions/database.php";

// Ensure admin is logged in
if(!isset($_SESSION['admin_id'])){
    header("Location: admin_login.php");
    exit();
}

// Get all products
$result = $conn->query("SELECT * FROM products");
?>

<h1>CampusMart Admin - Manage Products</h1>

<a href="admin_dashboard.php">Back to Dashboard</a> | 
<a href="../actions/logout.php">Logout</a>

<hr>

<h2>Add New Product</h2>

<form action="../actions/add_product.php" method="POST">

Product Name:<br>
<input type="text" name="name" required><br><br>

Price:<br>
<input type="number" name="price" required><br><br>

Description:<br>
<textarea name="description" required></textarea><br><br>

<button type="submit">Add Product</button>

</form>

<hr>

<h2>Product List</h2>

<table border="1" cellpadding="5" cellspacing="0">
<tr>
<th>ID</th>
<th>Name</th>
<th>Price</th>
<th>Description</th>
<th>Action</th>
</tr>

<?php
while($row = $result->fetch_assoc()){
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['price']."</td>";
    echo "<td>".$row['description']."</td>";
    echo "<td>
        <a href='../actions/delete_product.php?id=".$row['id']."' 
           onclick=\"return confirm('Are you sure you want to delete this product?')\">Delete</a>
    </td>";
    echo "</tr>";
}
?>

</table>
</body>
</html>