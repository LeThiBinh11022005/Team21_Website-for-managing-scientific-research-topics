<?php
require_once __DIR__ . '/../../functions/db_connection.php';
require_once __DIR__ . '/../../functions/topic_functions.php';

$statusFilter = $_GET['status'] ?? '';
$topics = getAllTopics($conn, $statusFilter);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quản lý đề tài</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<!-- Content -->
<main class="flex-1 p-6 overflow-auto">

    <h2 class="text-2xl font-bold mb-6">Danh sách đề tài</h2>

    <!-- Filter -->
    <form method="GET" class="mb-5 flex gap-3 items-center">
        <label class="font-semibold">Trạng thái:</label>

        <select name="status" onchange="this.form.submit()" class="border px-3 py-2 rounded">
            <option value="">Tất cả</option>
            <option value="pending"   <?= $statusFilter=='pending'?'selected':'' ?>>Chờ duyệt</option>
            <option value="approved"  <?= $statusFilter=='approved'?'selected':'' ?>>Đã duyệt</option>
            <option value="rejected"  <?= $statusFilter=='rejected'?'selected':'' ?>>Từ chối</option>
            <option value="in_progress" <?= $statusFilter=='in_progress'?'selected':'' ?>>Đang thực hiện</option>
            <option value="completed" <?= $statusFilter=='completed'?'selected':'' ?>>Hoàn thành</option>
        </select>
    </form>

    <!-- Add button -->
    <a href="topic_create.php"
       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Thêm đề tài
    </a>

    <!-- Table -->
    <div class="mt-4 bg-white shadow rounded-lg overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-300 text-center">
            <thead class="bg-gray-700 text-white">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Tên đề tài</th>
                    <th class="py-3 px-4">Giảng viên tạo</th>
                    <th class="py-3 px-4">Sinh viên</th>
                    <th class="py-3 px-4">Trạng thái</th>
                    <th class="py-3 px-4">Thao tác</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                <?php foreach ($topics as $t): ?>
                <tr class="hover:bg-gray-100">

                    <td class="py-2"><?= $t['id'] ?></td>

                    <td class="py-2"><?= htmlspecialchars($t['topic_name']) ?></td>

                    <td class="py-2"><?= htmlspecialchars($t['creator']) ?></td>

                    <td class="py-2">
                        <?= $t['student'] ? htmlspecialchars($t['student']) : '<span class="text-gray-400">Chưa giao</span>' ?>
                    </td>
                    <td class="py-2">
                        <span class="px-2 py-1 rounded text-white <?= getStatusColor($t['status']) ?>">
                            <?= translateStatus($t['status']) ?>
                        </span>
                    </td>
                    <td class="py-3 flex justify-center gap-2">
                        <!-- Nút sửa -->
                        <a href="topic_edit.php?id=<?= $t['id'] ?>"
                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536M4 20h4l11-11-4-4-11 11v4z"/>
                            </svg>
                        </a>
                        <!-- Nút xóa -->
                        <a href="../../handle/topic_process.php?action=delete&id=<?= $t['id'] ?>"
                        onclick="return confirm('Bạn chắc chắn muốn xóa đề tài này?')"
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1
                                    1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</main>

</body>
</html>
