<?php
require_once __DIR__ . '/db_connection.php';

/**
 * Lấy danh sách đề tài kèm tên giảng viên và trạng thái
 */
function getAllTopicsWithStatus() {
    global $conn;
    $sql = "SELECT 
                t.id, 
                t.topic_code, 
                t.topic_name, 
                t.description,
                t.status, 
                t.start_date, 
                t.end_date, 
                t.created_at,
                a.account_name AS lecturer_name
            FROM topics t
            LEFT JOIN accounts a ON t.lecturer_id = a.id
            ORDER BY t.id ASC";
    $result = mysqli_query($conn, $sql);
    $topics = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $topics[] = $row;
        }
    }
    return $topics;
}

/**
 * Đếm tổng số lượng theo trạng thái
 */
function getTopicStats() {
    global $conn;
    $sql = "SELECT 
                COUNT(*) AS total,
                SUM(status = 'Chua phan cong') AS unassigned,
                SUM(status = 'Dang thuc hien') AS in_progress,
                SUM(status = 'Hoan thanh') AS completed
            FROM topics";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}
?>
