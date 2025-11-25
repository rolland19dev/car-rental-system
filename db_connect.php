<?php
$conn = mysqli_connect("localhost", "root", "", "cars");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
