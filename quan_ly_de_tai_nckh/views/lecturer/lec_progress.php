<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/topic_functions.php';

checkLogin('../../index.php');

$currentUser = getCurrentUser();
$lecturer_id = $currentUser['account_id'];

$progressList = getLecturerProgress($lecturer_id);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo Tiến độ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<!-- Main -->
<main class="flex-1 p-6 overflow-auto">

    <h2 class="text-2xl font-bold mb-4">Báo cáo Tiến độ</h2>

    <div class="bg-white p-4 shadow rounded-lg">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="p-3">Đề tài</th>
                    <th class="p-3">Sinh viên</th>
                    <th class="p-3">Tiến độ</th>
                    <th class="p-3">Ghi chú</th>
                    <th class="p-3">Cập nhật</th>
                    <th class="p-3">Hành động</th>
                </tr>
            </thead>
            <tbody>

                <?php if (empty($progressList)) : ?>
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">
                        Chưa có báo cáo tiến độ nào
                    </td>
                </tr>

                <?php else : foreach ($progressList as $p): ?>
                <tr class="border-b">
                    <td class="p-3"><?= htmlspecialchars($p['topic_name']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($p['student_name'] ?? 'Chưa có') ?></td>
                    <td class="p-3 font-semibold text-blue-600"><?= $p['progress'] ?>%</td>
                    <td class="p-3"><?= htmlspecialchars($p['note']) ?></td>
                    <td class="p-3"><?= $p['updated_at'] ?></td>

                    <td class="p-3">
                        <a class="text-green-600" 
                           href="lec_progress_detail.php?id=<?= $p['id'] ?>">
                            Chi tiết
                        </a>
                    </td>
                </tr>
                <?php endforeach; endif; ?>

            </tbody>
        </table>
    </div>

</main>

</body>
</html>
