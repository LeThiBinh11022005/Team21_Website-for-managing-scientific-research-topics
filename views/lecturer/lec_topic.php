<?php
error_reporting(E_ALL & ~E_WARNING); 
session_start();

require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/topic_functions.php';

// Kiểm tra login
checkLogin(__DIR__ . '/../../index.php');

$currentUser = getCurrentUser();

if (!$currentUser || !isset($currentUser['account_id'])) {
    header("Location: ../../index.php");
    exit;
}

$lecturer_id = $currentUser['account_id'];
$topics = getLecturerTopics($lecturer_id);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đề tài của tôi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<!-- SIDEBAR -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<!-- MAIN -->
<main class="flex-1 p-6 overflow-auto">

    <h2 class="text-2xl font-bold mb-4">Đề tài của tôi</h2>

    <a href="lec_topic_create.php"
       class="bg-blue-600 text-white px-4 py-2 rounded shadow">
       + Tạo đề tài mới
    </a>
    <?php if (isset($_GET['success'])): ?>
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            Tạo đề tài thành công! Chờ admin phê duyệt.
        </div>
        <?php endif; ?>

    <div class="mt-6 bg-white shadow rounded-lg">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="p-3">Tên đề tài</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3">Sinh viên</th>
                    <th class="p-3">Hành động</th>
                </tr>
            </thead>

            <tbody>
                <?php if (empty($topics)) : ?>
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">
                        Chưa có đề tài nào
                    </td>
                </tr>

                <?php else : foreach ($topics as $t): ?>
                <tr class="border-b">
                    <td class="p-3"><?= htmlspecialchars($t['topic_name']) ?></td>
                    <td class="p-3"><?= translateStatus($t['status']) ?></td>
                    <td class="p-3">
                        <?= $t['student_id'] ? "Đã có sinh viên" : "Chưa có" ?>
                    </td>
                    <td class="p-3">
                        <a href="lec_student.php?topic_id=<?= $t['id'] ?>"
                           class="text-blue-600">Sinh viên</a>
                        |
                        <a href="lec_progress.php?topic_id=<?= $t['id'] ?>"
                           class="text-green-600">Tiến độ</a>
                    </td>
                </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>
    </div>

</main>
</body>
</html>
