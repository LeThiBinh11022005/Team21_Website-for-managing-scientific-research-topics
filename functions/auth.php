<?php
// functions/auth.php (chỉ phần authenticateUser hiển thị ở đây)

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Authenticate user using accounts table with plaintext password.
 *
 * @param mysqli $conn
 * @param string $username
 * @param string $password
 * @return array|false
 */
function authenticateUser($conn, $username, $password) {
    $sql = "SELECT id AS account_id, username, password, fullname, role
            FROM accounts
            WHERE username = ? AND status = 1
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        error_log("Prepare failed: " . mysqli_error($conn));
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) return false;

    $user = mysqli_fetch_assoc($result);
    if (!$user) return false;

    // PLAIN TEXT comparison (as requested)
    if ($user['password'] === $password) {
        return $user;
    }

    // Optionally: allow hashed passwords too (uncomment to support both)
    // if (password_verify($password, $user['password'])) {
    //     return $user;
    // }

    return false;
}
/**
 * Ngăn truy cập khi chưa đăng nhập.
 *
 * @param string $redirectPage Đường dẫn tuyệt đối redirect khi chưa đăng nhập.
 */
function checkLogin($redirectPage = '/index.php') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['account_id'])) {
        header("Location: " . $redirectPage);
        exit();
    }
}
function getCurrentUser() {
    return [
        'account_id' => $_SESSION['account_id'] ?? null,
        'username'   => $_SESSION['username'] ?? null,
        'fullname'   => $_SESSION['fullname'] ?? null,
        'role'       => $_SESSION['role'] ?? null
    ];
}

/* keep other helper functions (checkLogin, logout, getCurrentUser) as before */
