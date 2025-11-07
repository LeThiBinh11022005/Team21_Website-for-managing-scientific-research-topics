<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../../index.php');

// Lấy thông tin người dùng hiện tại
$currentUser = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DNU - Bảng điều khiển Sinh viên</title>
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

        <!-- Alerts -->
        <div class="max-w-7xl mx-auto mb-4">
            <?php if (isset($_GET['success'])): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <?= htmlspecialchars($_GET['success']) ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>
        </div>

        <script>
            setTimeout(() => {
                document.querySelectorAll('[role="alert"]').forEach(el => el.remove());
            }, 3000);
        </script>

        <!-- Hero Section -->
        <section class="bg-white rounded-lg shadow-md py-10 mb-8 max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row items-center gap-8">
                <div class="md:w-2/3">
                    <h1 class="text-3xl md:text-4xl font-bold text-green-600 mb-4">
                        Xin chào, <?= htmlspecialchars($currentUser['username']) ?>
                    </h1>
                    <p class="text-gray-700 mb-6">
                        Chào mừng bạn đến với hệ thống quản lý đề tài nghiên cứu khoa học.
                        Tại đây bạn có thể xem thông tin đề tài, cập nhật tiến độ và gửi báo cáo định kỳ cho giảng viên hướng dẫn.
                    </p>
                    <a href="my_topic.php"
                       class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded shadow-md">
                       Xem đề tài của tôi
                    </a>
                </div>
                <div class="md:w-1/3 flex justify-center">
                    <img src="../../images/sayhi.png" alt="Student Dashboard" class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover border border-gray-200">
                </div>
            </div>
        </section>

        <!-- Feature Cards -->
        <section class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <?php
            $features = [
                ['icon'=>'fas fa-book-open text-green-500','title'=>'Thông tin đề tài','desc'=>'Xem chi tiết đề tài bạn đang tham gia, giảng viên hướng dẫn và nhóm thực hiện.','link'=>'my_topic.php'],
                ['icon'=>'fas fa-file-alt text-yellow-500','title'=>'Báo cáo tiến độ','desc'=>'Gửi và cập nhật báo cáo tiến độ thực hiện đề tài cho giảng viên hướng dẫn.','link'=>'report_submit.php'],
                ['icon'=>'fas fa-comment-dots text-blue-500','title'=>'Phản hồi giảng viên','desc'=>'Xem nhận xét, phản hồi hoặc yêu cầu điều chỉnh từ giảng viên hướng dẫn.','link'=>'feedback.php'],
                ['icon'=>'fas fa-envelope text-red-500','title'=>'Liên hệ','desc'=>'Gửi tin nhắn hoặc trao đổi trực tiếp với giảng viên và các thành viên trong nhóm.','link'=>'contact.php'],
            ];
            foreach($features as $f):
            ?>
            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center h-full">
                <div class="mb-4">
                    <i class="<?= $f['icon'] ?> fa-2x"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2"><?= $f['title'] ?></h3>
                <p class="text-gray-600 text-sm mb-3"><?= $f['desc'] ?></p>
                <a href="<?= $f['link'] ?>" class="text-green-600 font-semibold hover:underline">Truy cập</a>
            </div>
            <?php endforeach; ?>
        </section>

    </main>

</body>
</html>
