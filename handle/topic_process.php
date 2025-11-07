<?php
require_once __DIR__ . '/../functions/topic_functions.php';
require_once __DIR__ . '/../functions/db_connection.php';

$action = $_GET['action'] ?? '';

if ($action === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Xóa liên kết với sinh viên trước
    mysqli_query($conn, "DELETE FROM topic_student WHERE topic_id = $id");

    // Xóa đề tài
    mysqli_query($conn, "DELETE FROM topics WHERE id = $id");

    header("Location: ../views/role_admin/topic.php?success=Đã xóa đề tài thành công");
    exit;
}

// Thêm hoặc sửa đề tài có thể viết tiếp như này
