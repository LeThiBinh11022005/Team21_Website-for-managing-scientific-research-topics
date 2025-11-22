<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/progress_uploads_functions.php';
checkLogin('../../index.php');

$current = getCurrentUser();
$lecturer_id = $current['account_id'];

$uploads = getProgressUploadsByLecturer($lecturer_id);
?>
<!doctype html>
<html lang="vi">
<head><meta charset="utf-8"><title>Báo cáo sinh viên nộp</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-gray-100 flex h-screen">
<aside class="w-64 bg-white"><?php include __DIR__ . '/../menu.php'; ?></aside>
<main class="flex-1 p-6">
  <h1 class="text-2xl mb-4">Báo cáo sinh viên nộp</h1>
  <div class="bg-white p-4 rounded shadow">
    <?php if (empty($uploads)): ?>
      <p>Chưa có file nào.</p>
    <?php else: foreach ($uploads as $u): ?>
      <div class="border-b py-3">
        <p class="font-semibold"><?= htmlspecialchars($u['topic_name']) ?> — <?= htmlspecialchars($u['student_name']) ?></p>
        <p class="text-sm text-gray-600"><?= $u['created_at'] ?></p>
        <p class="mt-2"><?= htmlspecialchars($u['description']) ?></p>
        <p class="mt-2">
          <a class="text-blue-600" href="../../uploads/<?= htmlspecialchars($u['file_path']) ?>" target="_blank">Tải file</a>
          |
          <a href="lec_progress_detail.php?upload_id=<?= $u['id'] ?>" class="text-green-600">Đánh giá / Cập nhật tiến độ</a>
        </p>
      </div>
    <?php endforeach; endif; ?>
  </div>
</main>
</body>
</html>
