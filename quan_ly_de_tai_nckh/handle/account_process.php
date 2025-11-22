<?php
require_once __DIR__ . '/../functions/account_functions.php';

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'add':
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $fullname = $_POST['fullname'] ?? '';
        $email    = $_POST['email'] ?? '';
        $role     = $_POST['role'] ?? '';

        addAccount($username, $password, $fullname, $email, $role);

        header("Location: ../views/admin/account.php?success=Thêm tài khoản thành công");
        exit;

    case 'edit':
        $id       = $_POST['id'];
        $username = $_POST['username'];
        $fullname = $_POST['fullname'];
        $email    = $_POST['email'];
        $role     = $_POST['role'];
        $password = $_POST['password']; // rỗng thì không cập nhật

        updateAccount($id, $username, $password, $fullname, $email, $role);

        header("Location: ../views/admin/account.php?success=Cập nhật thành công");
        exit;

    case 'delete':
        $id = $_GET['id'];
        deleteAccount($id);
        header("Location: ../views/admin/account.php?success=Đã xóa tài khoản");
        exit;

    default:
        header("Location: ../views/admin/account.php?error=Thao tác không hợp lệ");
        exit;
}
