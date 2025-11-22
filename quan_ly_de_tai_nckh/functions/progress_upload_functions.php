<?php
// functions/progress_uploads_functions.php
require_once __DIR__ . '/db_connection.php';
require_once __DIR__ . '/notifications_functions.php';

function addProgressUpload($topic_id, $student_id, $file_path, $description = null) {
    global $conn;
    $sql = "INSERT INTO progress_uploads (topic_id, student_id, file_path, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $topic_id, $student_id, $file_path, $description);
    $ok = $stmt->execute();
    if ($ok) {
        // notify lecturer (topic.created_by)
        $q = $conn->prepare("SELECT created_by FROM topics WHERE id = ?");
        $q->bind_param("i", $topic_id);
        $q->execute();
        $row = $q->get_result()->fetch_assoc();
        if ($row) {
            createNotification($row['created_by'], "Sinh viên đã nộp báo cáo tiến độ cho đề tài ID: $topic_id.");
        }
    }
    return $ok;
}

function getProgressUploadsByLecturer($lecturer_id) {
    global $conn;
    $sql = "SELECT pu.*, t.topic_name, a.fullname AS student_name
            FROM progress_uploads pu
            JOIN topics t ON pu.topic_id = t.id
            JOIN accounts a ON pu.student_id = a.id
            WHERE t.created_by = ?
            ORDER BY pu.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getProgressUploadsByStudent($student_id) {
    global $conn;
    $sql = "SELECT pu.*, t.topic_name
            FROM progress_uploads pu
            JOIN topics t ON pu.topic_id = t.id
            WHERE pu.student_id = ?
            ORDER BY pu.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
