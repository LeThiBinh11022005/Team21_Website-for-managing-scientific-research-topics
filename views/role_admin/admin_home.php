<?php
require_once __DIR__ . '/../../functions/auth.php';
checkLogin(__DIR__ . '/../../index.php');
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DNU - Quản lý Đề tài</title>
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
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert" id="alert-success">
          <?= htmlspecialchars($_GET['success']) ?>
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert" id="alert-error">
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
          <h1 class="text-3xl md:text-4xl font-bold text-orange-600 mb-4">Quản lý Đề tài Nghiên cứu khoa học</h1>
          <p class="text-gray-700 mb-6">
            Nền tảng hỗ trợ quản lý sinh viên, đề tài nghiên cứu, giảng viên hướng dẫn và báo cáo.
            Dễ dàng theo dõi tiến độ, phân công hướng dẫn, và xuất báo cáo thống kê.
          </p>
          <a href="topic.php"
             class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-6 rounded shadow-md">
             Xem đề tài
          </a>
        </div>
        <div class="md:w-1/3 flex justify-center">
          <img src="../../images/logo.png" alt="Logo" class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover">
        </div>
      </div>
    </section>

    <!-- Feature Cards -->
    <section class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <?php
        $features = [
          ['icon'=>'fas fa-user-graduate text-blue-500','title'=>'Quản lý Sinh viên','desc'=>'Thêm/sửa/xóa thông tin sinh viên, tìm kiếm theo mã, tên, lớp.'],
          ['icon'=>'fas fa-chalkboard-teacher text-indigo-500','title'=>'Quản lý Giảng viên','desc'=>'Tìm kiếm giảng viên theo mã, tên.'],
          ['icon'=>'fas fa-book-open text-green-500','title'=>'Quản lý Đề tài','desc'=>'Tạo đề tài, gán nhóm, quản lý giảng viên hướng dẫn và trạng thái đề tài.'],
          ['icon'=>'fas fa-chart-line text-yellow-500','title'=>'Thống kê & Báo cáo','desc'=>'Báo cáo tổng hợp: số đề tài, số sinh viên theo trạng thái, xuất CSV/PDF.']
        ];
        foreach($features as $f):
      ?>
      <div class="bg-white rounded-lg shadow-md p-6 flex flex-col items-center text-center h-full">
        <div class="mb-4">
          <i class="<?= $f['icon'] ?> fa-2x"></i>
        </div>
        <h3 class="font-semibold text-lg mb-2"><?= $f['title'] ?></h3>
        <p class="text-gray-600 text-sm"><?= $f['desc'] ?></p>
      </div>
      <?php endforeach; ?>
    </section>

  </main>

</body>
</html>
