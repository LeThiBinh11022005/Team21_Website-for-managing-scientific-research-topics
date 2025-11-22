<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/progress_uploads_functions.php';
require_once __DIR__ . '/../../functions/db_connection.php';
checkLogin('../../index.php');

$current = getCurrentUser();
$student_id = $current['account_id'];
$topic_id = intval($_POST['topic_id'] ?? 0);
$desc = trim($_POST['description'] ?? '');

if (!isset($_FILES['report_file']) || $_FILES['report_file']['error'] != 0) {
    $_SESSION['upload_error'] = "Vui lòng chọn file để upload.";
    header("Location: ../../views/student/student_progress_upload.php?topic_id=$topic_id");
    exit;
}

$uploaddir = __DIR__ . '/../../uploads';
if (!is_dir($uploaddir)) mkdir($uploaddir, 0755, true);

$fname = time() . '_' . preg_replace('/[^A-Za-z0-9_\.\-]/', '_', basename($_FILES['report_file']['name']));
$target = $uploaddir . '/' . $fname;
if (move_uploaded_file($_FILES['report_file']['tmp_name'], $target)) {
    addProgressUpload($topic_id, $student_id, $fname, $desc);
    $_SESSION['upload_success'] = 1;
    header("Location: ../../views/student/student_progress_upload.php?topic_id=$topic_id");
    exit;
} else {
    $_SESSION['upload_error'] = "Upload thất bại.";
    header("Location: ../../views/student/student_progress_upload.php?topic_id=$topic_id");
    exit;
}
