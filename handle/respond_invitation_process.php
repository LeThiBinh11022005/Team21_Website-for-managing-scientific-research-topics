<?php
session_start();
require '../../functions/db_connection.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['account_id'])) {
    header("Location: ../../index.php");
    exit;
}

$student_id = $_SESSION['account_id'];

// Nhận dữ liệu POST
if (!isset($_POST['invitation_id']) || !isset($_POST['action'])) {
    die("Thiếu dữ liệu.");
}

$invitation_id = intval($_POST['invitation_id']);
$action = $_POST['action']; // accept | reject

if (!in_array($action, ['accept', 'reject'])) {
    die("Hành động không hợp lệ.");
}

// Cập nhật trạng thái lời mời
$stmt = $conn->prepare("
    UPDATE invitations 
    SET status = ? 
    WHERE id = ? AND student_id = ?
");

$stmt->bind_param("sii", $action, $invitation_id, $student_id);
$stmt->execute();

// Nếu accept → cập nhật đề tài cho sinh viên
if ($action === 'accept') {
    // Lấy topic_id của lời mời
    $topicQ = $conn->prepare("SELECT topic_id FROM invitations WHERE id = ?");
    $topicQ->bind_param("i", $invitation_id);
    $topicQ->execute();
    $topicRes = $topicQ->get_result()->fetch_assoc();

    if ($topicRes) {
        $topic_id = $topicRes['topic_id'];

        // Gán đề tài cho sinh viên
        $updateTopic = $conn->prepare("
            UPDATE topics 
            SET student_id = ?
            WHERE id = ?
        ");
        $updateTopic->bind_param("ii", $student_id, $topic_id);
        $updateTopic->execute();
    }
}

// Quay lại trang lời mời
header("Location: student_invitations.php");
exit;
?>
