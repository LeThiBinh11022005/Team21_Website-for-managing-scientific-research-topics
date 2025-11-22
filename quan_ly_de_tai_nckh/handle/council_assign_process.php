<?php
require_once dirname(__DIR__) . '/functions/db_connection.php';

$action = $_GET['action'] ?? '';

// Thêm thành viên
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $council_id = $_POST['council_id'];
    $teacher_id = $_POST['teacher_id'];

    if ($teacher_id != "") {
        $stmt = $conn->prepare("INSERT INTO council_members (council_id, teacher_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $council_id, $teacher_id);
        $stmt->execute();
    }

    header("Location: /views/admin/council/council_assign.php?id=$council_id");
    exit;
}

// Xoá thành viên
if ($action === 'remove') {
    $id = $_GET['id'];
    $council = $_GET['council'];

    $stmt = $conn->prepare("DELETE FROM council_members WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: /views/admin/council/council_assign.php?id=$council");
    exit;
}
