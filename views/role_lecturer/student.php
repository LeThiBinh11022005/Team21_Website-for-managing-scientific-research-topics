<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/student_functions.php';
checkLogin(__DIR__ . '/../../index.php');

$currentUser = getCurrentUser();
$students = getStudentsByLecturer($currentUser['id']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DNU - Sinh viên hướng dẫn</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<!-- Main content -->
<main class="flex-1 overflow-auto p-6">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Danh sách sinh viên hướng dẫn</h2>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4">STT</th>
                        <th class="py-3 px-4">Tên sinh viên</th>
                        <th class="py-3 px-4">Tên đề tài</th>
                        <th class="py-3 px-4">Trạng thái đề tài</th>
                        <th class="py-3 px-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if(!empty($students)): ?>
                        <?php $i=1; foreach($students as $s): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-2 px-4"><?= $i++ ?></td>
                            <td class="py-2 px-4 text-left"><?= htmlspecialchars($s['student_name']) ?></td>
                            <td class="py-2 px-4 text-left"><?= htmlspecialchars($s['topic_name']) ?></td>
                            <td class="py-2 px-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                    <?= $s['status'] === 'Hoan thanh' ? 'bg-green-100 text-green-700' :
                                        ($s['status'] === 'Dang thuc hien' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-200 text-gray-700') ?>">
                                    <?= htmlspecialchars($s['status']) ?>
                                </span>
                            </td>
                            <td class="py-2 px-4 flex justify-center gap-2">
                                <a href="#" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs">
                                    Xem chi tiết
                                </a>
                                <a href="#" class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-xs">
                                    Gửi nhận xét
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-6 text-gray-500 italic">Hiện chưa có sinh viên nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

</body>
</html>
