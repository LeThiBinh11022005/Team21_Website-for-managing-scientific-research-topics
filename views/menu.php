<?php
require_once __DIR__ . '/../functions/auth.php';
checkLogin(__DIR__ . '/../index.php');

$user = getCurrentUser(); 
$role = $user['role'] ?? null;
$username = $user['username'] ?? 'User';

$currentPage = basename($_SERVER['PHP_SELF']);
?>

<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">

    <!-- Logo -->
    <?php
        $homeLink = match ($role) {
            'admin' => '/quan_ly_de_tai_nckh/views/admin/admin_dashboard.php',
            'lecturer' => '/quan_ly_de_tai_nckh/views/lecturer/lecturer_dashboard.php',
            'student' => '/quan_ly_de_tai_nckh/views/student/student_dashboard.php',
            default => '#'
        };
    ?>
    <a href="<?= $homeLink ?>" class="flex items-center p-4 border-b">
        <img src="/quan_ly_de_tai_nckh/images/logo.png" alt="Logo" class="h-10 w-10 rounded-full object-cover mr-2">
        <span class="font-bold text-xl text-orange-600">DNU NCKH</span>
    </a>

    <nav class="flex-1 p-4 overflow-y-auto space-y-1">

        <!-- ============ ADMIN MENU ============ -->
        <?php if ($role === 'admin'): ?>

            <a href="/quan_ly_de_tai_nckh/views/admin/account.php"
               class="flex items-center gap-2 py-2 px-3 rounded 
               <?= $currentPage=='account.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
               <i class="fas fa-users-cog"></i> Quản lý Tài khoản
            </a>

            <a href="/quan_ly_de_tai_nckh/views/admin/topic.php"
               class="flex items-center gap-2 py-2 px-3 rounded
               <?= $currentPage=='topic.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
               <i class="fas fa-book-open"></i> Quản lý Đề tài
            </a>
            <a href="/quan_ly_de_tai_nckh/views/admin/council.php"
               class="flex items-center gap-2 py-2 px-3 rounded
               <?= $currentPage=='council.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
               <i class="fas fa-book-open"></i> Quản lý Hội đồng
            </a>

            <a href="/quan_ly_de_tai_nckh/views/admin/progress.php"
               class="flex items-center gap-2 py-2 px-3 rounded
               <?= $currentPage=='progress.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
               <i class="fas fa-tasks"></i> Theo dõi Tiến độ
            </a>
            <a href="/quan_ly_de_tai_nckh/views/admin/evaluation.php"
               class="flex items-center gap-2 py-2 px-3 rounded
               <?= $currentPage=='evaluation.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
               <i class="fas fa-tasks"></i> Nghiệm thu Đề tài
            </a>

            <a href="/quan_ly_de_tai_nckh/views/admin/defense.php"
               class="flex items-center gap-2 py-2 px-3 rounded
               <?= $currentPage=='defense.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
               <i class="fas fa-gavel"></i> Báo cáo Trạng thái Bảo vệ
            </a>
            <a href="/quan_ly_de_tai_nckh/views/admin/admin_notification.php"
                class="flex items-center gap-2 py-2 px-3 rounded
                <?= $currentPage=='admin_notification.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
                <i class="fas fa-bell"></i> Thông báo
                </a>

        <?php endif; ?>


        <!-- ============ LECTURER MENU ============ -->
        <?php if ($role === 'lecturer'): ?>

            <a href="/quan_ly_de_tai_nckh/views/lecturer/lec_topic.php"
               class="flex items-center gap-2 py-2 px-3 rounded
               <?= $currentPage=='lec_topic.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
               <i class="fas fa-book-reader"></i> Đề tài của tôi
            </a>

            <a href="/quan_ly_de_tai_nckh/views/lecturer/lec_student.php"
               class="flex items-center gap-2 py-2 px-3 rounded
               <?= $currentPage=='lec_student.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
               <i class="fas fa-user-graduate"></i> Sinh viên Hướng dẫn
            </a>

            <a href="/quan_ly_de_tai_nckh/views/lecturer/lec_progress.php"
               class="flex items-center gap-2 py-2 px-3 rounded
               <?= $currentPage=='lec_progress.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
               <i class="fas fa-file-alt"></i> Báo cáo Tiến độ
            </a>
            <a href="/quan_ly_de_tai_nckh/views/lecturer/lec_notification.php"
            class="flex items-center gap-2 py-2 px-3 rounded
            <?= $currentPage=='lec_notification.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-200 text-gray-700' ?>">
            <i class="fas fa-bell"></i> Thông báo
            </a>
        <?php endif; ?>


        <!-- ============ STUDENT MENU ============ -->
        <?php if ($role === 'student'): ?>

            <!-- Dashboard -->
            <a href="/quan_ly_de_tai_nckh/views/student/student_dashboard.php"
            class="flex items-center gap-2 py-2 px-3 rounded 
                    <?= $currentPage=='student_dashboard.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-100' ?>">
                <i class="fas fa-home"></i> Bảng điều khiển
            </a>

            <!-- Lời mời (Thay cho: my_topic.php ?) -->
            <a href="/quan_ly_de_tai_nckh/views/student/student_invitations.php"
            class="flex items-center gap-2 py-2 px-3 rounded 
                    <?= $currentPage=='student_invitations.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-100' ?>">
                <i class="fas fa-envelope-open-text"></i> Lời mời hướng dẫn
            </a>

            <!-- Tiến độ cá nhân (trùng: student_upload_progress.php) -->
            <a href="/quan_ly_de_tai_nckh/views/student/student_upload_progress.php"
            class="flex items-center gap-2 py-2 px-3 rounded 
                    <?= $currentPage=='student_upload_progress.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-100' ?>">
                <i class="fas fa-tasks"></i> Nộp tiến độ
            </a>

            <!-- Đánh giá (evaluation) -->
            <a href="/quan_ly_de_tai_nckh/views/student/student_evaluation.php"
            class="flex items-center gap-2 py-2 px-3 rounded 
                    <?= $currentPage=='student_evaluation.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-100' ?>">
                <i class="fas fa-star-half-alt"></i> Đánh giá
            </a>

            <!-- Thông báo -->
            <a href="/quan_ly_de_tai_nckh/views/student/student_notification.php"
            class="flex items-center gap-2 py-2 px-3 rounded 
                    <?= $currentPage=='student_notification.php' ? 'bg-orange-100 text-orange-600 font-semibold' : 'hover:bg-gray-100' ?>">
                <i class="fas fa-bell"></i> Thông báo
            </a>

        <?php endif; ?>

        <!-- ============ USER DROPDOWN ============ -->
        <div class="mt-6 relative">
            <button id="user-btn" class="flex items-center w-full py-2 px-3 text-gray-700 rounded hover:bg-gray-200">
                <img src="/quan_ly_de_tai_nckh/images/user.png" class="h-8 w-8 rounded-full object-cover">
                <span class="ml-2 font-medium"><?= htmlspecialchars($username) ?></span>
                <i class="fas fa-chevron-down ml-auto"></i>
            </button>

            <ul id="user-menu"
                class="hidden absolute left-0 mt-1 w-full bg-white border rounded shadow-md py-1 z-10">
                <li><a href="/quan_ly_de_tai_nckh/views/profile.php" class="block px-4 py-2 hover:bg-gray-100">Thông tin cá nhân</a></li>
                <li><a href="/quan_ly_de_tai_nckh/handle/logout_process.php" class="block px-4 py-2 text-red-600 hover:bg-gray-100">Đăng xuất</a></li>
            </ul>
        </div>

    </nav>
</aside>

<script>
const userBtn = document.getElementById('user-btn');
const userMenu = document.getElementById('user-menu');

userBtn.addEventListener('click', e => {
    e.stopPropagation();
    userMenu.classList.toggle('hidden');
});

window.addEventListener('click', () => userMenu.classList.add('hidden'));
</script>
