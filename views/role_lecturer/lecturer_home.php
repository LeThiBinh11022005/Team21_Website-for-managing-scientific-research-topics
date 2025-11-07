<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../../index.php');

// Lấy thông tin giảng viên hiện tại
$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DNU - Bảng điều khiển Giảng viên</title>
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

    <!-- Hero Section -->
    <section class="bg-white rounded-lg shadow-md py-10 mb-8 max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="md:w-2/3">
                <h1 class="text-3xl md:text-4xl font-bold text-blue-600 mb-4">
                    Xin chào, Giảng viên <?= htmlspecialchars($currentUser['username']) ?>
                </h1>
                <p class="text-gray-700 mb-6">
                    Chào mừng bạn đến với hệ thống quản lý đề tài nghiên cứu khoa học. 
                    Tại đây bạn có thể quản lý các đề tài hướng dẫn, theo dõi sinh viên và gửi báo cáo tiến độ.
                </p>
                <a href="my_topic.php"
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded shadow-md">
                   Xem đề tài
                </a>
            </div>
            <div class="md:w-1/3 flex justify-center">
                <img src="../../images/lecturer.png" alt="Lecturer" class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover">
            </div>
        </div>
    </section>

    <!-- Feature Cards -->
    <section class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <?php
            $features = [
                ['icon'=>'fas fa-book-open text-blue-500','title'=>'Đề tài hướng dẫn','desc'=>'Xem và quản lý danh sách đề tài bạn đang hướng dẫn, cập nhật tiến độ.','link'=>'my_topics.php'],
                ['icon'=>'fas fa-user-graduate text-green-500','title'=>'Sinh viên hướng dẫn','desc'=>'Theo dõi danh sách sinh viên thuộc đề tài bạn phụ trách, cập nhật nhận xét định kỳ.','link'=>'students.php'],
                ['icon'=>'fas fa-file-alt text-yellow-500','title'=>'Báo cáo tiến độ','desc'=>'Gửi hoặc duyệt báo cáo tiến độ của các nhóm sinh viên đang thực hiện đề tài.','link'=>'reports.php'],
                ['icon'=>'fas fa-envelope text-red-500','title'=>'Liên hệ sinh viên','desc'=>'Gửi thông báo, phản hồi hoặc nhắn tin đến sinh viên trong nhóm nghiên cứu.','link'=>'contact.php'],
            ];
            foreach($features as $f):
        ?>
        <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center h-full">
            <div class="mb-4">
                <i class="<?= $f['icon'] ?> fa-2x"></i>
            </div>
            <h3 class="font-semibold text-lg mb-2"><?= $f['title'] ?></h3>
            <p class="text-gray-600 text-sm mb-3"><?= $f['desc'] ?></p>
            <a href="<?= $f['link'] ?>" class="text-blue-600 font-semibold hover:underline">Truy cập</a>
        </div>
        <?php endforeach; ?>
    </section>

</main>

</body>
</html>
