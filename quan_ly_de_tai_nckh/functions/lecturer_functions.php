<?php
require_once __DIR__ . '/db_connection.php';

function getLecturerTopicStats($lecturer_id) {
    global $conn;

    $stats = [
        'total' => 0,
        'pending' => 0,
        'in_progress' => 0,
        'completed' => 0
    ];

    // Tổng số đề tài
    $sql = "SELECT COUNT(*) AS total FROM topics WHERE created_by = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $stats['total'] = $stmt->get_result()->fetch_assoc()['total'];

    // Pending
    $sql = "SELECT COUNT(*) AS total FROM topics WHERE created_by = ? AND status = 'pending'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $stats['pending'] = $stmt->get_result()->fetch_assoc()['total'];

    // In progress
    $sql = "SELECT COUNT(*) AS total FROM topics WHERE created_by = ? AND status = 'in_progress'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $stats['in_progress'] = $stmt->get_result()->fetch_assoc()['total'];

    // Completed
    $sql = "SELECT COUNT(*) AS total FROM topics WHERE created_by = ? AND status = 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturer_id);
    $stmt->execute();
    $stats['completed'] = $stmt->get_result()->fetch_assoc()['total'];

    return $stats;
}
