<?php
require_once __DIR__ . '/db_connection.php';

/**
 * Lấy danh sách tài khoản (có thể lọc theo role)
 */
function getAllAccounts($role = '') {
    global $conn;
    $sql = "SELECT id, account_name, email, role FROM accounts";

    if (!empty($role)) {
        $sql .= " WHERE role = '" . mysqli_real_escape_string($conn, $role) . "'";
    }

    $sql .= " ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);

    $accounts = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $accounts[] = $row;
        }
    }
    return $accounts;
}

/**
 * Lấy thông tin tài khoản theo ID
 */
function getAccountById($id) {
    global $conn;
    $id = intval($id);
    $sql = "SELECT * FROM accounts WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    return ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : null;
}

/**
 * Thêm tài khoản mới
 */
function addAccount($account_name, $email, $password, $role) {
    global $conn;
    $account_name = mysqli_real_escape_string($conn, $account_name);
    $email = mysqli_real_escape_string($conn, $email);
    $role = mysqli_real_escape_string($conn, $role);
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO accounts (account_name, email, password, role)
            VALUES ('$account_name', '$email', '$hashedPassword', '$role')";
    return mysqli_query($conn, $sql);
}

/**
 * Cập nhật tài khoản
 */
function updateAccount($id, $account_name, $email, $role, $password = null) {
    global $conn;
    $id = intval($id);
    $account_name = mysqli_real_escape_string($conn, $account_name);
    $email = mysqli_real_escape_string($conn, $email);
    $role = mysqli_real_escape_string($conn, $role);

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "UPDATE accounts SET account_name='$account_name', email='$email', role='$role', password='$hashedPassword' WHERE id=$id";
    } else {
        $sql = "UPDATE accounts SET account_name='$account_name', email='$email', role='$role' WHERE id=$id";
    }

    return mysqli_query($conn, $sql);
}

/**
 * Xóa tài khoản theo ID
 */
function deleteAccount($id) {
    global $conn;
    $id = intval($id);
    $sql = "DELETE FROM accounts WHERE id = $id";
    return mysqli_query($conn, $sql);
}
?>
