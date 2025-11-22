<?php
require_once __DIR__ . '/db_connection.php';

function getAllTopics($conn, $status = "")
{
    $sql = "
        SELECT t.*,
               a1.fullname AS creator,
               a2.fullname AS student
        FROM topics t
        LEFT JOIN accounts a1 ON t.created_by = a1.id
        LEFT JOIN accounts a2 ON t.student_id = a2.id
    ";

    if ($status !== "") {
        $sql .= " WHERE t.status = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $status);
    } else {
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
function translateStatus($status) {
    return match($status) {
        'pending'     => 'Chờ duyệt',
        'approved'    => 'Đã duyệt',
        'rejected'    => 'Từ chối',
        'in_progress' => 'Đang thực hiện',
        'completed'   => 'Hoàn thành',
        default       => $status
    };
}
function getStatusColor($status) {
    switch ($status) {
        case 'completed':
            return "bg-purple-200 text-purple-800"; // Hoàn thành
        case 'in_progress':
            return "bg-blue-200 text-blue-800"; // Đang thực hiện
        case 'approved':
            return "bg-yellow-200 text-yellow-800"; // Chưa bắt đầu
        case 'pending':
            return "bg-gray-400 text-white"; // Chờ duyệt (tuỳ bạn)
        case 'rejected':
            return "bg-red-300 text-red-800"; // Từ chối (giữ đỏ)
        default:
            return "bg-gray-300 text-gray-800";
    }
}

function getTopicById($conn, $id)
{
    $sql = "SELECT * FROM topics WHERE id = $id";
    return $conn->query($sql)->fetch_assoc();
}

function addTopic($conn, $name, $desc, $field, $created_by)
{
    $sql = "INSERT INTO topics(topic_name, description, field, created_by) 
            VALUES ('$name', '$desc', '$field', $created_by)";
    return $conn->query($sql);
}
function createTopic($lecturer_id, $topic_name, $description) {
    global $conn;

    $sql = "INSERT INTO topics (topic_name, description, lecturer_id, status) 
            VALUES (?, ?, ?, 'pending')";

    $stmt = $conn->prepare($sql);
    return $stmt->execute([$topic_name, $description, $lecturer_id]);
}

// Lấy toàn bộ đề tài của 1 giảng viên
function getLecturerTopics($lecturer_id) {
    global $conn;

    $sql = "
        SELECT t.*, a.fullname AS student_name
        FROM topics t
        LEFT JOIN accounts a ON t.student_id = a.id
        WHERE t.created_by = ?
        ORDER BY t.created_at DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Lấy 1 đề tài của giảng viên (dùng trong chi tiết)
function getLecturerTopic($lecturer_id, $topic_id) {
    global $conn;

    $sql = "
        SELECT t.*
        FROM topics t
        WHERE t.created_by = ? AND t.id = ?
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $lecturer_id, $topic_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateTopic($conn, $id, $name, $desc, $field, $status)
{
    $sql = "UPDATE topics SET 
            topic_name='$name',
            description='$desc',
            field='$field',
            status='$status'
            WHERE id=$id";

    return $conn->query($sql);
}

function deleteTopic($conn, $id)
{
    return $conn->query("DELETE FROM topics WHERE id = $id");
}
function getLecturerStudents($lecturer_id) {
    global $conn;

   $sql = "
    SELECT 
        a.id AS student_id,
        a.fullname AS student_name,
        a.username AS student_code,
        a.email AS student_email,    -- THÊM DÒNG NÀY
        t.topic_name,
        t.status
    FROM topics t
    JOIN accounts a ON a.id = t.student_id
    WHERE t.created_by = ?
    ORDER BY t.id DESC
    ";


    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $students = [];
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }

    return $students;
}
function getLecturerProgress($lecturer_id) {
    global $conn;

    $sql = "
        SELECT 
            pr.id,
            pr.topic_id,
            pr.progress,
            pr.note,
            pr.updated_at,
            t.topic_name,
            a.fullname AS student_name
        FROM progress_reports pr
        JOIN topics t ON pr.topic_id = t.id
        LEFT JOIN accounts a ON t.student_id = a.id
        WHERE t.created_by = ?
        ORDER BY pr.updated_at DESC
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}


