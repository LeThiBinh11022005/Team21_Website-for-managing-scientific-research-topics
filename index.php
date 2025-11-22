<?php
session_start();
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QUẢN LÝ ĐỀ TÀI NGHIÊN CỨU KHOA HỌC</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

  <!-- Main content -->
  <main class="flex-grow flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md mx-4">
      <div class="flex justify-center mb-6">
        <img src="./images/logo.png" alt="Logo" class="w-36 h-36 object-cover rounded-full">
      </div>

      <h2 class="text-2xl font-bold text-center text-orange-600 mb-6">
        HỆ THỐNG QUẢN LÝ ĐỀ TÀI NGHIÊN CỨU KHOA HỌC
      </h2>

      <!-- Form login -->
      <form action="./handle/login_process.php" method="POST" class="space-y-4">
        <!-- Username -->
        <div>
          <label for="username" class="block font-semibold mb-1">Username</label>
          <input type="text" name="username" id="username" placeholder="Nhập username"
                 class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-orange-400" required>
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block font-semibold mb-1">Password</label>
          <input type="password" name="password" id="password" placeholder="Nhập mật khẩu"
                 class="w-full border border-gray-300 rounded p-2 focus:ring-2 focus:ring-orange-400" required>
        </div>

        <!-- Session messages -->
        <?php if (isset($_SESSION['error'])): ?>
          <div class="text-red-600 font-semibold">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
          </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <div class="text-green-600 font-semibold">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
          </div>
        <?php endif; ?>

        <!-- Login button -->
        <div class="text-center">
          <button type="submit" name="login"
                  class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-6 rounded w-full">
            Đăng nhập
          </button>
        </div>
      </form>
    </div>
  </main>

</body>
</html>
