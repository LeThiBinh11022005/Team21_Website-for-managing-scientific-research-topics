<?php
require_once __DIR__ . '/../../functions/db_connection.php';
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../../index.php');


// Lấy thống kê từ DB
$totalAccounts     = getCount("SELECT COUNT(*) FROM accounts");
$totalTopics       = getCount("SELECT COUNT(*) FROM topics");
$pendingTopics     = getCount("SELECT COUNT(*) FROM topics WHERE status = 'pending'");
$approvedTopics    = getCount("SELECT COUNT(*) FROM topics WHERE status = 'approved'");
$inProgressTopics  = getCount("SELECT COUNT(*) FROM topics WHERE status = 'in_progress'");
$completedTopics   = getCount("SELECT COUNT(*) FROM topics WHERE status = 'completed'");

function getCount($query) {
    global $conn;
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->get_result()->fetch_row()[0];
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Thống kê hệ thống</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/css/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex h-screen">

  <!-- Sidebar -->
  <?php include __DIR__ . '/../menu.php'; ?>

  <main class="flex-1 overflow-auto p-6">

    <!-- Tiêu đề -->
    <h1 class="text-3xl font-bold text-orange-600 mb-6">Dashboard thống kê</h1>

    <!-- Hàng 1: Tài khoản & Đề tài -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

      <!-- Tổng tài khoản -->
      <div class="bg-white p-6 rounded-lg shadow flex items-center gap-4">
        <i class="fas fa-users fa-3x text-blue-600"></i>
        <div>
          <p class="text-gray-500 text-sm">Tổng số tài khoản</p>
          <h2 class="text-2xl font-bold"><?= $totalAccounts ?></h2>
        </div>
      </div>

      <!-- Tổng đề tài -->
      <div class="bg-white p-6 rounded-lg shadow flex items-center gap-4">
        <i class="fas fa-book fa-3x text-green-600"></i>
        <div>
          <p class="text-gray-500 text-sm">Tổng số đề tài</p>
          <h2 class="text-2xl font-bold"><?= $totalTopics ?></h2>
        </div>
      </div>

      <!-- Đề tài chờ duyệt -->
      <div class="bg-white p-6 rounded-lg shadow flex items-center gap-4">
        <i class="fas fa-hourglass-half fa-3x text-yellow-600"></i>
        <div>
          <p class="text-gray-500 text-sm">Đề tài chờ duyệt</p>
          <h2 class="text-2xl font-bold"><?= $pendingTopics ?></h2>
        </div>
      </div>
    </div>

    <!-- Hàng 2: Đã duyệt / Đang thực hiện / Hoàn thành -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-6">

      <!-- Đề tài đã duyệt -->
      <div class="bg-white p-6 rounded-lg shadow flex items-center gap-4">
        <i class="fas fa-check-circle fa-3x text-blue-500"></i>
        <div>
          <p class="text-gray-500 text-sm">Đề tài đã duyệt</p>
          <h2 class="text-2xl font-bold"><?= $approvedTopics ?></h2>
        </div>
      </div>

      <!-- Đề tài đang thực hiện -->
      <div class="bg-white p-6 rounded-lg shadow flex items-center gap-4">
        <i class="fas fa-spinner fa-3x text-indigo-500"></i>
        <div>
          <p class="text-gray-500 text-sm">Đang thực hiện</p>
          <h2 class="text-2xl font-bold"><?= $inProgressTopics ?></h2>
        </div>
      </div>

      <!-- Đề tài đã hoàn thành -->
      <div class="bg-white p-6 rounded-lg shadow flex items-center gap-4">
        <i class="fas fa-trophy fa-3x text-green-500"></i>
        <div>
          <p class="text-gray-500 text-sm">Đã hoàn thành</p>
          <h2 class="text-2xl font-bold"><?= $completedTopics ?></h2>
        </div>
      </div>

    </div>

  </main>

</body>
</html>
