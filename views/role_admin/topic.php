<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/topic_functions.php';
checkLogin(__DIR__ . '/../../index.php');

$topics = getAllTopics();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>DNU - Quản lý Đề tài</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<main class="flex-1 overflow-auto p-6">
    <div class="max-w-7xl mx-auto">
        <h3 class="text-2xl font-bold mb-6 text-gray-800">DANH SÁCH ĐỀ TÀI NGHIÊN CỨU</h3>

        <!-- Nút thêm & xóa nhiều -->
        <div class="mb-4 flex gap-3">
            <a href="topic/create_topic.php" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Thêm đề tài
            </a>
            <button id="deleteSelected" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 hidden"
                    onclick="deleteSelectedTopics()">Xóa nhiều</button>
        </div>

        <!-- Bảng -->
        <form id="topicsForm" method="POST" action="../../handle/topic_process.php?action=delete_multiple">
        <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-3">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Mã đề tài</th>
                        <th class="py-3 px-4">Tên đề tài</th>
                        <th class="py-3 px-4">Mô tả</th>
                        <th class="py-3 px-4">Giảng viên</th>
                        <th class="py-3 px-4">Trạng thái</th>
                        <th class="py-3 px-4">Ngày bắt đầu</th>
                        <th class="py-3 px-4">Ngày kết thúc</th>
                        <th class="py-3 px-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if (!empty($topics)): ?>
                        <?php foreach ($topics as $topic): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-3">
                                <input type="checkbox" class="selectItem" name="ids[]" value="<?= $topic['id'] ?>">
                            </td>
                            <td class="py-3 px-4"><?= htmlspecialchars($topic['id']) ?></td>
                            <td class="py-3 px-4 font-medium text-gray-700"><?= htmlspecialchars($topic['topic_code']) ?></td>
                            <td class="py-3 px-4 text-gray-800"><?= htmlspecialchars($topic['topic_name']) ?></td>
                            <td class="py-3 px-4 text-gray-600 text-left truncate max-w-xs">
                                <?= nl2br(htmlspecialchars($topic['description'] ?? '')) ?>
                            </td>
                            <td class="py-3 px-4 text-gray-600"><?= htmlspecialchars($topic['lecturer_name'] ?? 'Chưa phân công') ?></td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                    <?= $topic['status'] === 'Hoan thanh' ? 'bg-green-100 text-green-700' :
                                        ($topic['status'] === 'Dang thuc hien' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-200 text-gray-700') ?>">
                                    <?= htmlspecialchars($topic['status']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 text-gray-500"><?= htmlspecialchars($topic['start_date'] ?? '-') ?></td>
                            <td class="py-3 px-4 text-gray-500"><?= htmlspecialchars($topic['end_date'] ?? '-') ?></td>
                            <td class="py-3 px-4 flex justify-center space-x-2">
                                <!-- Nút Sửa -->
                                <a href="topic/edit_topic.php?id=<?= $topic['id'] ?>" 
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs flex items-center gap-1">
                                <!-- Icon bút sửa -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20h4l11-11-4-4-11 11v4z"/>
                                </svg>
                                </a>

                                <!-- Nút Xóa -->
                                <a href="topic/delete_topic.php?id=<?= $topic['id'] ?>" 
                                onclick="return confirm('Bạn có chắc muốn xóa đề tài này?');"
                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs flex items-center justify-center">
                                <!-- Icon thùng rác -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1 1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                </svg>
                                </a>
                            </td>


                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="py-6 text-gray-500 italic">Chưa có đề tài nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        </form>
    </div>
</main>

<script>
const selectAll = document.getElementById('selectAll');
const items = document.querySelectorAll('.selectItem');
const deleteBtn = document.getElementById('deleteSelected');

// Chọn tất cả
selectAll.addEventListener('change', function(){
    items.forEach(i => i.checked = this.checked);
    toggleDeleteButton();
});

// Bật/tắt nút Xóa nhiều
items.forEach(i => i.addEventListener('change', toggleDeleteButton));

function toggleDeleteButton(){
    const anyChecked = Array.from(items).some(i => i.checked);
    deleteBtn.classList.toggle('hidden', !anyChecked);
}

// Xóa nhiều
function deleteSelectedTopics(){
    if(confirm('Bạn có chắc chắn muốn xóa các đề tài đã chọn?')){
        document.getElementById('topicsForm').submit();
    }
}
</script>

</body>
</html>
