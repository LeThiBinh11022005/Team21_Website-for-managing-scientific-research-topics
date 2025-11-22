<?php
require '../functions/db_connection.php';

$action = $_GET['action'] ?? $_POST['action'] ?? null;

// Tạo hoặc sửa
if ($_SERVER['REQUEST_METHOD'] === "POST" && !$action) {
    $id = $_POST['id'];
    $name = $_POST['council_name'];
    $desc = $_POST['description'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE councils SET council_name=?, description=? WHERE id=?");
        $stmt->execute([$name, $desc, $id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO councils (council_name, description) VALUES (?, ?)");
        $stmt->execute([$name, $desc]);
    }

    header("Location: ../admin/council.php");
    exit;
}

// Xóa hội đồng
if ($action === "delete") {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM councils WHERE id=?");
    $stmt->execute([$id]);
    header("Location: ../admin/council.php");
    exit;
}

// Thêm thành viên
if ($action === "add_member") {

    $stmt = $conn->prepare("
        INSERT INTO council_members (council_id, teacher_id, role)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$_POST['council_id'], $_POST['teacher_id'], $_POST['role']]);

    header("Location: ../admin/council/council_assign.php?id=" . $_POST['council_id']);
    exit;
}

// Xóa thành viên
if ($action === "delete_member") {
    $id = $_GET['id'];
    $council_id = $_GET['council_id'];

    $stmt = $conn->prepare("DELETE FROM council_members WHERE id=?");
    $stmt->execute([$id]);

    header("Location: ../admin/council/council_assign.php?id=$council_id");
    exit;
}
