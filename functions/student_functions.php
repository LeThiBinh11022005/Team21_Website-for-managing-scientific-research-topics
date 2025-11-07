<?php
require_once __DIR__ . '/db_connection.php';

/**
 * Lấy danh sách sinh viên thuộc các đề tài của giảng viên
 * @param int $lecturer_id
 * @return array
 */
function getStudentsByLecturer($lecturer_id) {
    global $conn;
    $sql = "SELECT s.id AS student_id, s.account_name AS student_name, t.topic_name, t.status
            FROM accounts s
            INNER JOIN topic_student ts ON s.id = ts.student_id
            INNER JOIN topics t ON ts.topic_id = t.id
            WHERE t.lecturer_id = ?
            ORDER BY t.id, s.account_name";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $lecturer_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}
