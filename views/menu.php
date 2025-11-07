<?php
require_once __DIR__ . '/../functions/auth.php';
checkLogin(__DIR__ . '/../index.php');
$currentUser = getCurrentUser();
$currentPage = basename($_SERVER['PHP_SELF']);
$role = $currentUser['role'];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DNU - Hệ thống Quản lý Đề tài Nghiên cứu Khoa học</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">

        <!-- Logo -->
        <?php
            $homeLink = '#';
            switch ($role) {
                case 'admin': $homeLink = 'admin_home.php'; break;
                case 'lecturer': $homeLink = 'lecturer_home.php'; break;
                case 'student': $homeLink = 'student_home.php'; break;
            }
        ?>
        <a href="<?= $homeLink ?>" class="flex items-center p-4 border-b">
            <img src="/QlyNCKH/images/logo.png" alt="Logo" class="h-10 w-10 rounded-full object-cover mr-2">
            <span class="font-bold text-xl text-orange-600">DNU NCKH</span>
        </a>

        <!-- Menu -->
        <nav class="flex-1 p-4 overflow-y-auto space-y-1">

            <?php if ($role === 'admin'): ?>
                <!-- Quản lý Sinh viên -->
                <a href="account.php" 
                class="flex items-center gap-2 py-2 px-3 rounded <?= $currentPage=='account.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'text-gray-700 hover:bg-gray-200' ?>">
                <i class="fas fa-chalkboard-teacher"></i> Quản lý Tài khoản
                </a>

                <!-- Quản lý Đề tài -->
                <a href="topic.php" 
                class="flex items-center gap-2 py-2 px-3 rounded <?= $currentPage=='topic.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'text-gray-700 hover:bg-gray-200' ?>">
                <i class="fas fa-chalkboard-teacher"></i> Quản lý Đề tài
                </a>

                <!-- Đăng Thông báo -->
                <a href="post.php" 
                class="flex items-center gap-2 py-2 px-3 rounded <?= $currentPage=='post.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'text-gray-700 hover:bg-gray-200' ?>">
                <i class="fas fa-bullhorn"></i> Đăng Thông báo
                </a>

                <!-- Thống kê & Báo cáo -->
                <a href="report.php" 
                class="flex items-center gap-2 py-2 px-3 rounded <?= $currentPage=='report.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'text-gray-700 hover:bg-gray-200' ?>">
                <i class="fas fa-chart-line"></i> Thống kê & Báo cáo
                </a>

                <script>
                    // Giữ trạng thái submenu khi đang ở trang con
                    ['student','topic'].forEach(menu => {
                        const pages = {
                            student: ['student.php','create_student.php','edit_student.php'],
                            topic: ['topic.php','create_topic.php','edit_topic.php','assign_lecturer.php','assign_students.php']
                        };
                        if(pages[menu].includes('<?= $currentPage ?>')){
                            document.getElementById(menu+'-submenu').classList.remove('hidden');
                        }
                    });
                </script>
            <?php elseif ($role === 'lecturer'): ?>
                <a href="my_topic.php" class="block py-2 px-3 rounded <?= $currentPage=='my_topics.php'?'bg-orange-100 text-orange-600 font-semibold':'text-gray-700 hover:bg-gray-200' ?>">Đề tài của tôi</a>
                <a href="student.php" class="block py-2 px-3 rounded <?= $currentPage=='students.php'?'bg-orange-100 text-orange-600 font-semibold':'text-gray-700 hover:bg-gray-200' ?>">Sinh viên hướng dẫn</a>
                <a href="reports.php" class="block py-2 px-3 rounded <?= $currentPage=='reports.php'?'bg-orange-100 text-orange-600 font-semibold':'text-gray-700 hover:bg-gray-200' ?>">Báo cáo tiến độ</a>
            <?php elseif ($role === 'student'): ?>
                <a href="topics.php" class="block py-2 px-3 rounded <?= $currentPage=='topics.php'?'bg-orange-100 text-orange-600 font-semibold':'text-gray-700 hover:bg-gray-200' ?>">Đề tài đăng ký</a>
                <a href="progress.php" class="block py-2 px-3 rounded <?= $currentPage=='progress.php'?'bg-orange-100 text-orange-600 font-semibold':'text-gray-700 hover:bg-gray-200' ?>">Tiến độ của tôi</a>
                <a href="contact.php" class="block py-2 px-3 rounded <?= $currentPage=='contact.php'?'bg-orange-100 text-orange-600 font-semibold':'text-gray-700 hover:bg-gray-200' ?>">Liên hệ giảng viên</a>
            <?php endif; ?>

            <!-- User dropdown dưới menu -->
            <div class="mt-6 relative">
                <button id="user-btn" class="flex items-center w-full py-2 px-3 text-gray-700 rounded hover:bg-gray-200 focus:outline-none">
                    <img src="/QlyNCKH/images/user.png" class="h-8 w-8 rounded-full object-cover" alt="User Avatar">
                    <span class="ml-2 font-medium"><?= htmlspecialchars($currentUser['username']) ?></span>
                    <i class="fas fa-chevron-down ml-auto text-gray-600"></i>
                </button>
                <ul id="user-menu" class="hidden absolute left-0 mt-1 w-full bg-white border rounded shadow-md py-1 z-10">
                    <li><a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Thông tin cá nhân</a></li>
                    <li><a href="/QlyNCKH/handle/logout_process.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Đăng xuất</a></li>
                </ul>
            </div>

        </nav>
    </aside>

    <script>
        // Toggle user dropdown
        const userBtn = document.getElementById('user-btn');
        const userMenu = document.getElementById('user-menu');

        userBtn.addEventListener('click', e => {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');
        });

        // Click ngoài sidebar để đóng dropdown
        window.addEventListener('click', e => {
            if (!userBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
