<?php

$conn = new mysqli("localhost","root","","campusmart");

if($conn->connect_error){
die("Database Connection Failed");
}

function sanitize($data){
return htmlspecialchars(trim($data));
}

?>