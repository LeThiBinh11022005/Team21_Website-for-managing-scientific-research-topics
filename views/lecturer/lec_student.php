<?php
session_start();
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/topic_functions.php';

checkLogin('../../index.php');

$currentUser = getCurrentUser();
$lecturer_id = $currentUser['account_id'];

$students = getLecturerStudents($lecturer_id);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sinh viên hướng dẫn</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<!-- Main -->
<main class="flex-1 p-6 overflow-auto">

    <h2 class="text-2xl font-bold mb-4">Sinh viên hướng dẫn</h2>

    <div class="bg-white p-4 shadow rounded-lg overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b bg-gray-100">
                    <th class="p-3">Sinh viên</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Đề tài</th>
                    <th class="p-3">Trạng thái</th>
                    <th class="p-3">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($students)) : ?>
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">
                        Chưa có sinh viên nào được phân công
                    </td>
                </tr>
                <?php else : foreach ($students as $s): ?>
                <tr class="border-b">
                    <td class="p-3"><?= htmlspecialchars($s['student_name']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($s['student_email']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($s['topic_name']) ?></td>
                    <td class="p-3"><?= translateStatus($s['status']) ?></td>
                    <td class="p-3">
                        <a href="lec_student_detail.php?student_id=<?= $s['student_id'] ?>"
                           class="text-blue-600 hover:underline">
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
