<?php
// functions/invitation_functions.php
require_once __DIR__ . '/db_connection.php';
require_once __DIR__ . '/notifications_functions.php';

function sendInvitation($topic_id, $student_id, $lecturer_id) {
    global $conn;
    // kiểm tra topic tồn tại & lecturer là chủ đề tài
    $q = $conn->prepare("SELECT id FROM topics WHERE id=? AND created_by=?");
    $q->bind_param("ii", $topic_id, $lecturer_id);
    $q->execute();
    if ($q->get_result()->num_rows === 0) return false;

    // tránh duplicate pending
    $sql = "SELECT id FROM invitations WHERE topic_id=? AND student_id=? AND status='pending'";
    $s = $conn->prepare($sql);
    $s->bind_param("ii", $topic_id, $student_id);
    $s->execute();
    if ($s->get_result()->num_rows > 0) return false;

    $ins = $conn->prepare("INSERT INTO invitations (topic_id, student_id) VALUES (?, ?)");
    $ins->bind_param("ii", $topic_id, $student_id);
    $ok = $ins->execute();

    if ($ok) {
        createNotification($student_id, "Bạn được mời tham gia đề tài (ID: $topic_id). Vui lòng kiểm tra Lời mời.");
    }
    return $ok;
}

function listInvitationsForStudent($student_id) {
    global $conn;
    $sql = "SELECT i.*, t.topic_name, a.fullname AS lecturer_name
            FROM invitations i
            JOIN topics t ON i.topic_id = t.id
            JOIN accounts a ON t.created_by = a.id
            WHERE i.student_id = ?
            ORDER BY i.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getInvitation($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM invitations WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateInvitationStatus($invitation_id, $status) {
    // status: accepted / declined
    global $conn;
    $allowed = ['accepted','declined','pending'];
    if (!in_array($status, $allowed)) return false;

    // Cập nhật trạng thái
    $u = $conn->prepare("UPDATE invitations SET status = ? WHERE id = ?");
    $u->bind_param("si", $status, $invitation_id);
    $ok = $u->execute();
    if (!$ok) return false;

    // Lấy thông tin invitation
    $stmt = $conn->prepare("SELECT topic_id, student_id FROM invitations WHERE id = ?");
    $stmt->bind_param("i", $invitation_id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if (!$row) return true;

    $topic_id = (int)$row['topic_id'];
    $student_id = (int)$row['student_id'];

    // Khi accepted: gán student vào topics nếu chưa có
    if ($status === 'accepted') {
        $q = $conn->prepare("UPDATE topics SET student_id = ?, status = 'in_progress' WHERE id = ? AND (student_id IS NULL OR student_id = 0)");
        $q->bind_param("ii", $student_id, $topic_id);
        $q->execute();

        // notify lecturer
        $q2 = $conn->prepare("SELECT created_by FROM topics WHERE id = ?");
        $q2->bind_param("i", $topic_id);
        $q2->execute();
        $t = $q2->get_result()->fetch_assoc();
        if ($t) createNotification($t['created_by'], "Sinh viên đã chấp nhận lời mời cho đề tài ID: $topic_id.");
    } else {
        // declined -> notify lecturer
        $q2 = $conn->prepare("SELECT created_by FROM topics WHERE id = ?");
        $q2->bind_param("i", $topic_id);
        $q2->execute();
        $t = $q2->get_result()->fetch_assoc();
        if ($t) createNotification($t['created_by'], "Sinh viên đã từ chối lời mời cho đề tài ID: $topic_id.");
    }

    return true;
}

