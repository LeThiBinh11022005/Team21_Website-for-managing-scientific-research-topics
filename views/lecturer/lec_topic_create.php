<?php
error_reporting(E_ALL & ~E_WARNING);
session_start();

require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/topic_functions.php';

// Kiểm tra đăng nhập
checkLogin(__DIR__ . '/../../../index.php');

$currentUser = getCurrentUser();

// Giảng viên ID = account_id
$lecturer_id = $currentUser['account_id'] ?? null;

if (!$lecturer_id) {
    header("Location: ../../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Tạo đề tài mới</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<!-- SIDEBAR -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<!-- MAIN -->
<main class="flex-1 p-6 overflow-auto">

    <a href="lec_topic.php" class="text-blue-600 underline mb-4 block">
        ← Quay lại
    </a>

    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tạo đề tài mới</h2>

        <form action="../../handle/lecturer/create_topic_handle.php" method="POST" class="space-y-5">
            <input type="hidden" name="lecturer_id" value="<?= $lecturer_id ?>">

            <div>
                <label class="block mb-1 font-medium">Tên đề tài</label>
                <input type="text" name="topic_name"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"
                       required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Mô tả</label>
                <textarea name="description" rows="5"
                          class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                Tạo đề tài
            </button>
        </form>
    </div>

</main>
</body>
</html>
