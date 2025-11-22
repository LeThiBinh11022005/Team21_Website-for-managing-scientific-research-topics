<?php
session_start();
require_once '../functions/db_connection.php'; // $conn
require_once '../functions/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $_SESSION['error'] = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu!';
        header('Location: ../index.php');
        exit();
    }

    $user = authenticateUser($conn, $username, $password);

    if ($user) {
        // chống session fixation
        session_regenerate_id(true);

        $_SESSION['account_id'] = $user['account_id'];
        $_SESSION['username']   = $user['username'];
        $_SESSION['fullname']   = $user['fullname'];
        $_SESSION['role']       = $user['role'];

        $redirectMap = [
            'admin'    => '../views/admin/admin_dashboard.php',
            'lecturer' => '../views/lecturer/lecturer_dashboard.php',
            'student'  => '../views/student/student_dashboard.php'
        ];

        if (isset($redirectMap[$user['role']])) {
            header('Location: ' . $redirectMap[$user['role']]);
            exit();
        } else {
            $_SESSION['error'] = 'Vai trò người dùng không hợp lệ!';
            header('Location: ../index.php');
            exit();
        }
    }

    $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng!';
    header('Location: ../index.php');
    exit();
}
?>
