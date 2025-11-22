<?php
$host = 'localhost';
$user = 'root';
$pass = '210925';
$db   = 'quan_ly_de_tai';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Kết nối database thất bại: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");
