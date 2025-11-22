<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/db_connection.php';
require_once __DIR__ . '/../../functions/notifications_functions.php';
checkLogin('../../index.php');

$current = getCurrentUser();
$lecturer_id = $current['account_id'];

$topic_id = intval($_POST['topic_id'] ?? 0);
$progress = intval($_POST['progress'] ?? 0);
$note = trim($_POST['note'] ?? '');

// verify ownership
$q = $conn->prepare("SELECT id, student_id FROM topics WHERE id = ? AND created_by = ?");
$q->bind_param("ii", $topic_id, $lecturer_id);
$q->execute();
if ($q->get_result()->num_rows === 0) {
    header("Location: ../../views/lecturer/lec_progress_uploads.php?error=no_permission");
    exit;
}

// insert vào progress_reports
$s = $conn->prepare("INSERT INTO progress_reports (topic_id, progress, note) VALUES (?, ?, ?)");
$s->bind_param("iis", $topic_id, $progress, $note);
$s->execute();

// gửi notification cho student nếu có
$r = $conn->prepare("SELECT student_id FROM topics WHERE id=?");
$r->bind_param("i", $topic_id);
$r->execute();
$row = $r->get_result()->fetch_assoc();
if ($row && $row['student_id']) {
    createNotification($row['student_id'], "Giảng viên đã cập nhật tiến độ đề tài ID $topic_id: $progress%.");
}

header("Location: ../../views/lecturer/lec_progress_uploads.php?updated=1");
exit;
