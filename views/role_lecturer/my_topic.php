<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/my_topic_functions.php';
checkLogin(__DIR__ . '/../../index.php');

$currentUser = getCurrentUser();
$topics = getTopicsByLecturer($currentUser['id']);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Đề tài của tôi</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen">

<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<main class="flex-1 overflow-auto p-6">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Danh sách đề tài của tôi</h2>

        <?php if(isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4">ID</th>
                        <th class="py-3 px-4">Mã đề tài</th>
                        <th class="py-3 px-4">Tên đề tài</th>
                        <th class="py-3 px-4">Sinh viên</th>
                        <th class="py-3 px-4">Trạng thái</th>
                        <th class="py-3 px-4">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if(!empty($topics)): ?>
                        <?php foreach($topics as $t): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="py-3 px-4"><?= $t['id'] ?></td>
                            <td class="py-3 px-4 font-medium text-gray-700"><?= htmlspecialchars($t['topic_code']) ?></td>
                            <td class="py-3 px-4 text-gray-800"><?= htmlspecialchars($t['topic_name']) ?></td>
                            <td class="py-3 px-4 text-gray-600 text-left truncate max-w-xs"><?= htmlspecialchars($t['students'] ?? 'Chưa phân công') ?></td>
                            <td class="py-3 px-4">
                                <form method="POST" action="../../handle/process_topic.php">
                                    <input type="hidden" name="topic_id" value="<?= $t['id'] ?>">
                                    <select name="status" onchange="this.form.submit()"
                                        class="px-2 py-1 rounded border border-gray-300 text-sm">
                                        <option value="Chua phan cong" <?= $t['status']=='Chua phan cong'?'selected':'' ?>>Chưa phân công</option>
                                        <option value="Dang thuc hien" <?= $t['status']=='Dang thuc hien'?'selected':'' ?>>Đang thực hiện</option>
                                        <option value="Hoan thanh" <?= $t['status']=='Hoan thanh'?'selected':'' ?>>Hoàn thành</option>
                                    </select>
                                </form>
                            </td>
                            <td class="py-3 px-4">
                                <a href="view_topic.php?id=<?= $t['id'] ?>" class="text-blue-600 hover:underline text-sm">Xem chi tiết</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-6 text-gray-500 italic">Chưa có đề tài nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</body>
</html>
