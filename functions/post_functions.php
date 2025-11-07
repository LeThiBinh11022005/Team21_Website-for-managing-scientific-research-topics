<?php
require_once __DIR__ . '/db_connection.php';

/**
 * Lấy tất cả thông báo
 */
function getAllPosts() {
    global $conn;
    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);

    $posts = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
    }
    return $posts;
}

/**
 * Lấy thông báo theo ID
 */
function getPostById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

/**
 * Tạo mới thông báo
 */
function createPost($title, $content, $author) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO posts (title, content, author) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $content, $author);
    return $stmt->execute();
}

/**
 * Cập nhật thông báo
 */
function updatePost($id, $title, $content) {
    global $conn;
    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);
    return $stmt->execute();
}

/**
 * Xóa thông báo
 */
function deletePost($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
?>
