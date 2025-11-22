<?php
session_start();
require_once __DIR__ . '/../../functions/db_connection.php';
require_once __DIR__ . '/../../functions/notifications_functions.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['account_id'])) {
    header("Location: /quan_ly_de_tai_nckh/views/index.php");
    exit();
}

$lecturer_id = $_SESSION['account_id'];

// Lấy danh sách thông báo
$notiList = getNotificationsByUser($lecturer_id);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo của Giảng viên</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
        <?php include __DIR__ . '/../menu.php'; ?>
    </aside>

    <!-- Nội dung -->
    <main class="flex-1 p-6">
        <h2 class="text-2xl font-bold mb-4 text-orange-600">Thông báo dành cho Giảng viên</h2>

        <div class="bg-white shadow rounded p-4">
            <?php if (empty($notiList)): ?>
                <p class="text-gray-500">Chưa có thông báo mới.</p>
            <?php else: ?>
                <ul class="space-y-3">
                    <?php foreach ($notiList as $n): ?>
                        <li class="p-3 border rounded <?= $n['is_read'] ? 'bg-gray-50' : 'bg-orange-50' ?>">
                            <div class="flex justify-between">
                                <p><?= htmlspecialchars($n['message']) ?></p>

                                <?php if (!$n['is_read']): ?>
                                    <a href="/quan_ly_de_tai_nckh/handle/mark_read.php?id=<?= $n['id'] ?>"
                                       class="text-blue-600 text-sm hover:underline">
                                        Đánh dấu đã đọc
                                    </a>
                                <?php endif; ?>
                            </div>

                            <span class="text-xs text-gray-400">⏱ <?= $n['created_at'] ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
