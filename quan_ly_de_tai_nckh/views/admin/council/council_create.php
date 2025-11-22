<?php
require '../../../functions/db_connection.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM councils WHERE id=?");
    $stmt->execute([$id]);
    $council = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $id ? "Sửa hội đồng" : "Tạo hội đồng" ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/css/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex h-screen">

  <!-- Sidebar -->
  <?php include __DIR__ . '/../../menu.php'; ?>

  <main class="flex-1 overflow-auto p-6">

    <h1 class="text-2xl font-bold mb-4">
      <?= $id ? "Sửa hội đồng" : "Tạo hội đồng" ?>
    </h1>

    <div class="bg-white shadow p-6 rounded w-full max-w-xl">

      <form action="../../handle/ccouncil_process.php" method="POST">

        <input type="hidden" name="id" value="<?= $id ?>">

        <label class="font-semibold">Tên hội đồng</label>
        <input type="text" name="council_name"
          value="<?= $council['council_name'] ?? '' ?>"
          class="border w-full p-2 rounded mb-4" required>

        <label class="font-semibold">Mô tả</label>
        <textarea name="description"
          class="border w-full p-2 rounded mb-4"><?= $council['description'] ?? '' ?></textarea>

        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
          <?= $id ? "Cập nhật" : "Tạo mới" ?>
        </button>

      </form>

    </div>

  </main>
</body>
</html>
