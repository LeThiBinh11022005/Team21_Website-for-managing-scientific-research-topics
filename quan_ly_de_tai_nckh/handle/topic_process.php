<?php
require_once __DIR__ . '/../functions/topic_functions.php';
require_once __DIR__ . '/../functions/db.php';

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'add':
        addTopic(
            $conn,
            $_POST['topic_name'],
            $_POST['description'],
            $_POST['field'],
            $_POST['created_by']
        );
        header("Location: ../views/admin/topic_list.php?success=Đã thêm đề tài");
        break;

    case 'edit':
        updateTopic(
            $conn,
            $_POST['id'],
            $_POST['topic_name'],
            $_POST['description'],
            $_POST['field'],
            $_POST['status']
        );
        header("Location: ../views/admin/topic_list.php?success=Cập nhật thành công");
        break;

    case 'delete':
        deleteTopic($conn, $_GET['id']);
        header("Location: ../views/admin/topic_list.php?success=Đã xóa đề tài");
        break;

    default:
        header("Location: ../views/admin/topic_list.php?error=Lỗi thao tác");
}
exit;
