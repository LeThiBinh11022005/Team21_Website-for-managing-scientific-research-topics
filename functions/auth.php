<?php
/**
 * Hàm kiểm tra xem user đã đăng nhập chưa
 * Nếu chưa đăng nhập, chuyển hướng về trang login
 * 
 * @param string $redirectPath Đường dẫn để chuyển hướng về trang login (mặc định: '../index.php')
 */
function checkLogin($redirectPath = '../index.php') {
    // Khởi tạo session nếu chưa có
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Kiểm tra xem user đã đăng nhập chưa
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
        // Nếu chưa đăng nhập, set thông báo lỗi và chuyển hướng
        $_SESSION['error'] = 'Bạn cần đăng nhập để truy cập trang này!';
        header('Location: ' . $redirectPath);
        exit();
    }
}

/**
 * Hàm đăng xuất user
 * Xóa tất cả session và chuyển hướng về trang login
 * 
 * @param string $redirectPath Đường dẫn để chuyển hướng sau khi logout (mặc định: '../index.php')
 */
function logout($redirectPath = '../index.php') {
    // Khởi tạo session nếu chưa có
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Hủy tất cả session
    session_unset();
    session_destroy();
    
    // Khởi tạo session mới để lưu thông báo
    session_start();
    $_SESSION['success'] = 'Đăng xuất thành công!';
    
    // Chuyển hướng về trang đăng nhập
    header('Location: ' . $redirectPath);
    exit();
}

/**
 * Hàm lấy thông tin user hiện tại
 * 
 * @return array|null Trả về thông tin user nếu đã đăng nhập, null nếu chưa đăng nhập
 */
function getCurrentUser() {
    // Khởi tạo session nếu chưa có
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_SESSION['user_id']) && isset($_SESSION['username'])) {
        return [
            'id' => $_SESSION['user_id'],
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role'] ?? null
        ];
    }
    
    return null;
}

/**
 * Hàm kiểm tra xem user đã đăng nhập chưa (không redirect)
 * 
 * @return bool True nếu đã đăng nhập, False nếu chưa
 */
function isLoggedIn() {
    // Khởi tạo session nếu chưa có
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

/**
 * Hàm xác thực đăng nhập
 * @param mysqli $conn
 * @param string $username
 * @param string $password
 * @return array|false Trả về thông tin user nếu đúng, false nếu sai
 */
function authenticateUser($conn, $username, $password) {
    $sql = "SELECT u.id AS user_id, u.username, u.password, a.id AS account_id, a.account_name, a.role
            FROM users u
            JOIN accounts a ON u.account_id = a.id
            WHERE u.username = ? LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        // So sánh plain text
        if ($user['password'] === $password) {
            return $user;
        }
    }

    return false;
}


?>


