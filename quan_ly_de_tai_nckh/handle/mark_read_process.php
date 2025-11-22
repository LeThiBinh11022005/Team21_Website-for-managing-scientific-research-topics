<?php
require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/notifications_functions.php';

checkLogin('/quan_ly_de_tai_nckh/views/index.php');

if (!isset($_GET['id'])) {
    die("Thiếu ID");
}

$id = intval($_GET['id']);
markNotificationRead($id);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
