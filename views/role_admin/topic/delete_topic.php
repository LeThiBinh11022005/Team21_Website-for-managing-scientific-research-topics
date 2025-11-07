<?php
require_once __DIR__ . '/../../../functions/auth.php';
require_once __DIR__ . '/../../../functions/topic_functions.php';
checkLogin(__DIR__ . '/../../../index.php');

// Lấy ID đề tài
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../topic.php?error=invalid_id");
    exit;
}

$id = intval($_GET['id']);

// Gọi hàm xóa
$deleted = deleteTopic($id);

if ($deleted) {
    header("Location: ../topic.php?success=deleted");
} else {
    header("Location: ../topic.php?error=delete_failed");
}
exit;
