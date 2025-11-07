<?php
require_once __DIR__ . '/../../../functions/post_functions.php';

$id = $_GET['id'] ?? null;

if ($id && deletePost($id)) {
    header("Location: ../post.php");
    exit;
} else {
    die("Không thể xóa hoặc không tìm thấy thông báo.");
}
?>
