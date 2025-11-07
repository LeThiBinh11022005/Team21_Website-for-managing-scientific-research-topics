<?php
require_once __DIR__ . '/../functions/account_functions.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'add':
        $name = $_POST['account_name'];
        $email = $_POST['email'];
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        addAccount($name, $email, $pass, $role);
        header("Location: ../views/role_admin/account.php?success=Thêm tài khoản thành công");
        break;

    case 'edit':
        $id = $_POST['id'];
        $name = $_POST['account_name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $pass = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        updateAccount($id, $name, $email, $role, $pass);
        header("Location: ../views/role_admin/account.php?success=Cập nhật thành công");
        break;

    case 'delete':
        $id = $_GET['id'];
        deleteAccount($id);
        header("Location: ../views/role_admin/account.php?success=Đã xóa tài khoản");
        break;

    default:
        header("Location: ../views/role_admin/account.php?error=Thao tác không hợp lệ");
}
exit;
