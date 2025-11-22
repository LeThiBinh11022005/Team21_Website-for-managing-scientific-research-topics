<?php
require_once __DIR__ . '/db_connection.php';

/**
 * Lấy danh sách thông báo theo tài khoản (account_id)
 */
function getNotificationsByUser($user_id) {
    global $conn;

    $sql = "SELECT id, message, is_read, created_at 
            FROM notifications 
            WHERE user_id = ?
            ORDER BY created_at DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Tạo thông báo (dành cho hệ thống gửi GV/SV/Admin)
 */
function createNotification($account_id, $message)
{
    global $conn;

    $sql = "INSERT INTO notifications (account_id, message, is_read)
            VALUES (?, ?, 0)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $account_id, $message);

    $stmt->execute();
    $stmt->close();
}


/**
 * Đánh dấu thông báo đã đọc
 */
function markNotificationRead($id)
{
    global $conn;

    $sql = "UPDATE notifications SET is_read = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $stmt->close();
}
