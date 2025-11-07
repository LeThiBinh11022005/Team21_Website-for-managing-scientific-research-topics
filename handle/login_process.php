<?php
session_start();
require_once '../functions/db_connection.php'; // có sẵn $conn
require_once '../functions/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    handleLogin();
}

function handleLogin() {
    global $conn;

    // Lấy dữ liệu từ form
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Kiểm tra rỗng
    if ($username === '' || $password === '') {
        $_SESSION['error'] = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu!';
        header('Location: ../index.php');
        exit();
    }

    // Xác thực người dùng
    $user = authenticateUser($conn, $username, $password); // hàm trả về mảng user hoặc false

    if ($user) {
        // Lưu session
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['account_id'] = $user['account_id'];
        $_SESSION['username'] = $user['account_name'];
        $_SESSION['role'] = $user['role'];

        // Chuyển hướng theo role
        $redirectMap = [
            'admin' => '../views/role_admin/admin_home.php',
            'lecturer' => '../views/role_lecturer/lecturer_home.php',
            'student' => '../views/role_student/student_home.php'
        ];

        if (isset($redirectMap[$user['role']])) {
            header('Location: ' . $redirectMap[$user['role']]);
        } else {
            $_SESSION['error'] = 'Vai trò người dùng không hợp lệ!';
            header('Location: ../index.php');
        }
        exit();
    }

    // Sai thông tin đăng nhập
    $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng!';
    header('Location: ../index.php');
    exit();
}
?>
