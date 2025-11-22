<?php
require __DIR__ . '/../functions/db_connection.php';

$topic_id = $_POST['topic_id'];
$score = $_POST['score'];
$comment = $_POST['comment'];

// Kiểm tra đã có bản ghi chưa
$sql_check = "SELECT * FROM evaluations WHERE topic_id = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$exists = $stmt->get_result()->fetch_assoc();

if ($exists) {
    // Update
    $sql_update = "UPDATE evaluations SET score = ?, comment = ? WHERE topic_id = ?";
    $stmt2 = $conn->prepare($sql_update);
    $stmt2->bind_param("d", $score, $comment, $topic_id);
    $stmt2->execute();
} else {
    // Insert mới
    $sql_insert = "INSERT INTO evaluations (topic_id, score, comment) VALUES (?, ?, ?)";
    $stmt3 = $conn->prepare($sql_insert);
    $stmt3->bind_param("ids", $topic_id, $score, $comment);
    $stmt3->execute();
}

// Quay lại trang danh sách
header("Location: /quan_ly_de_tai_nckh/views/admin/evaluation.php");
exit;
