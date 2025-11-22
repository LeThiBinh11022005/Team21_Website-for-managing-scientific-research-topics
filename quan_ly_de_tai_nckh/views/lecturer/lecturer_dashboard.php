<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/lecturer_functions.php';

checkLogin(__DIR__ . '/../../index.php');
$currentUser = getCurrentUser();
$lec_id = $currentUser['account_id'];

$stats = getLecturerTopicStats($lec_id);

$total_topics = $stats['total'];
$pending = $stats['pending'];
$inprogress = $stats['in_progress'];
$completed = $stats['completed'];

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giảng viên - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
        <?php include __DIR__ . '/../menu.php'; ?>
    </aside>

    <!-- MAIN content -->
    <main class="flex-1 p-6 overflow-auto">

        <h1 class="text-2xl font-bold mb-6">Bảng điều khiển (Giảng viên)</h1>

        <!-- THỐNG KÊ -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-gray-500">Tổng số đề tài của tôi</p>
                <h2 class="text-3xl font-bold mt-2"><?= $total_topics ?></h2>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-gray-500">Đề tài chờ duyệt</p>
                <h2 class="text-3xl font-bold mt-2"><?= $pending ?></h2>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-gray-500">Đề tài đang thực hiện</p>
                <h2 class="text-3xl font-bold mt-2"><?= $inprogress ?></h2>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <p class="text-gray-500">Đề tài đã hoàn thành</p>
                <h2 class="text-3xl font-bold mt-2"><?= $completed ?></h2>
            </div>

        </div>

        <!-- LỐI TẮT -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="create_topic.php"
                class="bg-blue-600 text-white p-4 rounded-lg shadow text-center font-semibold">
                + Tạo đề tài mới
            </a>

            <a href="my_topics.php"
                class="bg-gray-700 text-white p-4 rounded-lg shadow text-center font-semibold">
                Xem danh sách đề tài
            </a>

            <a href="students.php"
                class="bg-green-600 text-white p-4 rounded-lg shadow text-center font-semibold">
                Quản lý sinh viên
            </a>

        </div>

    </main>
</body>

</html>
