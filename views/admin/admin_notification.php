<?php
session_start();
require '../../functions/notifications_functions.php';

$user_id = $_SESSION['account_id'] ?? null;

if (!$user_id) {
    die("Lỗi: không tìm thấy session account_id");
}

// ĐÚNG
$notiList = getNotificationsByUser($user_id);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin - Thông báo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
        <?php include __DIR__ . '/../menu.php'; ?>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6 overflow-y-auto">

        <h2 class="text-2xl font-bold mb-4 text-orange-600">Thông báo dành cho Admin</h2>

        <div class="bg-white shadow rounded p-4">

            <?php if (empty($notiList)): ?>
                <p class="text-gray-500">Không có thông báo nào.</p>
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

                            <span class="text-xs text-gray-400">
                                📅 <?= $n['created_at'] ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        </div>

    </main>

</body>
</html>
