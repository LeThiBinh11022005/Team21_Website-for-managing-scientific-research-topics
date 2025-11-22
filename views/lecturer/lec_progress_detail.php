<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/progress_uploads_functions.php';
require_once __DIR__ . '/../../functions/topic_functions.php';
checkLogin('../../index.php');

$current = getCurrentUser();
$lecturer_id = $current['account_id'];
$upload_id = intval($_GET['upload_id'] ?? 0);

// get upload
require_once __DIR__ . '/../../functions/db_connection.php';
$stmt = $conn->prepare("SELECT pu.*, t.topic_name, t.id AS topic_id, a.fullname AS student_name FROM progress_uploads pu JOIN topics t ON pu.topic_id=t.id JOIN accounts a ON pu.student_id=a.id WHERE pu.id=?");
$stmt->bind_param("i", $upload_id);
$stmt->execute();
$upload = $stmt->get_result()->fetch_assoc();
if (!$upload) die("Không tìm thấy.");

if ($upload['created_by'] ?? null) {} // ignore

// Security: ensure current lecturer owns the topic
$q = $conn->prepare("SELECT created_by FROM topics WHERE id = ?");
$q->bind_param("i", $upload['topic_id']);
$q->execute();
$t = $q->get_result()->fetch_assoc();
if (!$t || $t['created_by'] != $lecturer_id) {
    die("Bạn không có quyền truy cập.");
}
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Đánh giá tiến độ</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-100 flex h-screen">
<aside class="w-64 bg-white"><?php include __DIR__ . '/../menu.php'; ?></aside>
<main class="flex-1 p-6">
  <h1 class="text-2xl mb-4">Đánh giá báo cáo: <?= htmlspecialchars($upload['topic_name']) ?></h1>

  <div class="bg-white p-4 rounded shadow max-w-3xl">
    <p class="font-semibold">Sinh viên: <?= htmlspecialchars($upload['student_name']) ?></p>
    <p class="text-sm text-gray-500">Nộp: <?= $upload['created_at'] ?></p>
    <p class="mt-3"><?= htmlspecialchars($upload['description']) ?></p>
    <p class="mt-3"><a class="text-blue-600" href="../../uploads/<?= htmlspecialchars($upload['file_path']) ?>" target="_blank">Tải file</a></p>

    <hr class="my-4">

    <form action="../../handle/lecturer/update_progress.php" method="POST">
      <input type="hidden" name="topic_id" value="<?= $upload['topic_id'] ?>">
      <label class="block mb-2">Tiến độ (%)</label>
      <input type="number" name="progress" min="0" max="100" class="border p-2 w-32" required>

      <label class="block mt-3 mb-2">Ghi chú</label>
      <textarea name="note" class="w-full border p-2" rows="4"></textarea>

      <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded">Lưu đánh giá</button>
    </form>
  </div>
</main>
</body>
</html>
