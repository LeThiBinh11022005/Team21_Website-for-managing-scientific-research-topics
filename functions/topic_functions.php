<?php
require_once __DIR__ . '/db_connection.php';

/**
 * Lấy danh sách tất cả đề tài (kèm tên giảng viên & sinh viên)
 */
function getAllTopics() {
    global $conn;

    $sql = "
        SELECT t.*, a.account_name AS lecturer_name
        FROM topics t
        LEFT JOIN accounts a ON t.lecturer_id = a.id
        ORDER BY t.id ASC
    ";

    $result = mysqli_query($conn, $sql);
    $topics = [];

    while ($row = mysqli_fetch_assoc($result)) {
        // Lấy danh sách sinh viên thuộc đề tài
        $row['students'] = getStudentsByTopicId($row['id']);
        $topics[] = $row;
    }

    return $topics;
}

/**
 * Lấy thông tin chi tiết 1 đề tài theo ID
 */
function getTopicById($id) {
    global $conn;

    $sql = "
        SELECT t.*, a.account_name AS lecturer_name
        FROM topics t
        LEFT JOIN accounts a ON t.lecturer_id = a.id
        WHERE t.id = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $topic = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($topic) {
        $topic['students'] = getStudentsByTopicId($topic['id']);
    }

    return $topic;
}

/**
 * Lấy danh sách sinh viên thuộc 1 đề tài
 */
function getStudentsByTopicId($topic_id) {
    global $conn;

    $sql = "
        SELECT a.id, a.account_name AS student_name
        FROM topic_student ts
        JOIN accounts a ON ts.student_id = a.id
        WHERE ts.topic_id = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $topic_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $students = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    return $students;
}

/**
 * Lấy danh sách giảng viên (role = 'lecturer')
 */
function getAllLecturers() {
    global $conn;
    $sql = "SELECT id, account_name AS lecturer_name FROM accounts WHERE role = 'lecturer'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Lấy danh sách sinh viên (role = 'student')
 */
function getAllStudents() {
    global $conn;
    $sql = "SELECT id, account_name AS student_name FROM accounts WHERE role = 'student'";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

/**
 * Thêm đề tài mới + gán giảng viên & sinh viên (nếu có)
 */
function createTopic($topic_code, $topic_name, $lecturer_id = null, $student_ids = [], $status = 'Chua phan cong') {
    global $conn;

    $sql = "INSERT INTO topics (topic_code, topic_name, lecturer_id, status) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssis", $topic_code, $topic_name, $lecturer_id, $status);
    $ok = mysqli_stmt_execute($stmt);
    $topic_id = mysqli_insert_id($conn);
    mysqli_stmt_close($stmt);

    if ($ok && !empty($student_ids)) {
        foreach ($student_ids as $sid) {
            assignStudentToTopic($topic_id, $sid);
        }
    }

    return $ok;
}

/**
 * Cập nhật đề tài
 */
function updateTopic($id, $topic_code, $topic_name, $lecturer_id = null, $student_ids = [], $status = 'Chua phan cong') {
    global $conn;

    $sql = "UPDATE topics SET topic_code=?, topic_name=?, lecturer_id=?, status=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssisi", $topic_code, $topic_name, $lecturer_id, $status, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Cập nhật danh sách sinh viên
    if ($ok) {
        // Xóa sinh viên cũ
        $del = mysqli_prepare($conn, "DELETE FROM topic_student WHERE topic_id = ?");
        mysqli_stmt_bind_param($del, "i", $id);
        mysqli_stmt_execute($del);
        mysqli_stmt_close($del);

        // Gán lại sinh viên mới
        foreach ($student_ids as $sid) {
            assignStudentToTopic($id, $sid);
        }
    }

    return $ok;
}

/**
 * Xóa đề tài
 */
function deleteTopic($id) {
    global $conn;

    // Xóa sinh viên liên quan trước
    $delStu = mysqli_prepare($conn, "DELETE FROM topic_student WHERE topic_id = ?");
    mysqli_stmt_bind_param($delStu, "i", $id);
    mysqli_stmt_execute($delStu);
    mysqli_stmt_close($delStu);

    // Xóa đề tài
    $sql = "DELETE FROM topics WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $ok;
}

/**
 * Gán sinh viên vào đề tài
 */
function assignStudentToTopic($topic_id, $student_id) {
    global $conn;
    $sql = "INSERT INTO topic_student (topic_id, student_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $topic_id, $student_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
?>
