<?php
require_once __DIR__ . '/db_connection.php';

/**
 * Lấy danh sách đề tài của giảng viên theo lecturer_id
 */
function getTopicsByLecturer($lecturer_id) {
    global $conn;
    $sql = "SELECT t.*, 
                   GROUP_CONCAT(s.account_name SEPARATOR ', ') AS students
            FROM topics t
            LEFT JOIN topic_student ts ON t.id = ts.topic_id
            LEFT JOIN accounts s ON ts.student_id = s.id
            WHERE t.lecturer_id = ?
            GROUP BY t.id
            ORDER BY t.id DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $lecturer_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Cập nhật trạng thái đề tài
 */
function updateTopicStatus($topic_id, $status) {
    global $conn;
    $stmt = mysqli_prepare($conn, "UPDATE topics SET status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "si", $status, $topic_id);
    return mysqli_stmt_execute($stmt);
}
