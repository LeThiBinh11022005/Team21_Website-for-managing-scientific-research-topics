<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/post_functions.php';
checkLogin(__DIR__ . '/../../index.php');

// Lấy danh sách thông báo
$posts = getAllPosts();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>DNU - Đăng Thông báo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
        <?php include __DIR__ . '/../menu.php'; ?>
    </aside>

    <!-- Main -->
    <main class="flex-1 overflow-auto p-6">
        <div class="max-w-6xl mx-auto">
            <h3 class="text-2xl font-bold mb-6 text-gray-800">DANH SÁCH THÔNG BÁO</h3>

            <a href="post/create_post.php"
               class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 transition">
               + Đăng thông báo mới
            </a>

            <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-3 px-4 text-center w-16">ID</th>
                            <th class="py-3 px-4 text-left w-48">Tiêu đề</th>
                            <th class="py-3 px-4 text-left w-[40%]">Nội dung</th>
                            <th class="py-3 px-4 w-32">Ngày đăng</th>
                            <th class="py-3 px-4 w-32">Người đăng</th>
                            <th class="py-3 px-4 w-40 text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (!empty($posts)): ?>
                            <?php foreach ($posts as $post): ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-3 px-4 text-center text-gray-600"><?= htmlspecialchars($post['id']) ?></td>
                                    <td class="py-3 px-4 font-medium text-gray-700"><?= htmlspecialchars($post['title']) ?></td>
                                    <td class="py-3 px-4 text-gray-600 text-justify max-w-md overflow-hidden text-ellipsis">
                                        <?= nl2br(htmlspecialchars($post['content'])) ?>
                                    </td>
                                    <td class="py-3 px-4 text-gray-500 text-center"><?= htmlspecialchars($post['created_at']) ?></td>
                                    <td class="py-3 px-4 text-gray-600 text-center"><?= htmlspecialchars($post['author'] ?? 'admin') ?></td>
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
                                <td colspan="6" class="py-6 text-center text-gray-500 italic">
                                    Chưa có thông báo nào
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
