<?php
session_start();
require_once __DIR__ . '/../functions/auth.php';
require_once __DIR__ . '/../functions/topic_functions.php';
checkLogin(__DIR__ . '/../index.php');

$currentUser = getCurrentUser();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic_id = $_POST['topic_id'];
    $status = $_POST['status'];

    // Kiểm tra xem đề tài thuộc giảng viên hiện tại
    $topics = getTopicsByLecturer($currentUser['id']);
    $topic_ids = array_column($topics, 'id');
    if(!in_array($topic_id, $topic_ids)){
        $_SESSION['error'] = "Bạn không có quyền chỉnh sửa đề tài này!";
        header("Location: ../views/role_lecturer/my_topics.php");
        exit();
    }

    if(updateTopicStatus($topic_id, $status)){
        $_SESSION['success'] = "Cập nhật trạng thái đề tài thành công.";
    } else {
        $_SESSION['error'] = "Cập nhật thất bại!";
    }

    header("Location: ../views/role_lecturer/my_topics.php");
    exit();
}
