<?php
$host = "localhost";
$dbname = "service_marketplace";
$username = "root";
$password = "";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset to utf8
mysqli_set_charset($conn, "utf8");
?>