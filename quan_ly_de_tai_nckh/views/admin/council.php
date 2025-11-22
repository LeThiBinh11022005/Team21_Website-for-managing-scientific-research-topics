<?php
require '../../functions/db_connection.php';

$stmt = $conn->prepare("SELECT * FROM councils");
$stmt->execute();
$result = $stmt->get_result();
$councils = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Danh sách hội đồng</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="/css/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex h-screen">

  <!-- Sidebar -->
  <?php include __DIR__ . '/../menu.php'; ?>

  <main class="flex-1 overflow-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Danh sách hội đồng</h1>

    <a href="council/council_create.php"
      class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
      <i class="fa-solid fa-plus"></i> Tạo hội đồng
    </a>

    <div class="mt-6 bg-white rounded shadow p-4">
      <table class="w-full border-collapse">
        <thead>
          <tr class="bg-gray-200 text-left">
            <th class="border p-3">ID</th>
            <th class="border p-3">Tên hội đồng</th>
            <th class="border p-3">Mô tả</th>
            <th class="border p-3">Hành động</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($councils as $c): ?>
            <tr class="border">
              <td class="p-3"><?= $c['id'] ?></td>
              <td class="p-3"><?= $c['council_name'] ?></td>
              <td class="p-3"><?= $c['description'] ?></td>

              <td class="p-3 flex gap-3">

                <!-- Edit -->
                <a href="council/council_create.php?id=<?= $c['id'] ?>"
                  class="text-yellow-600 hover:text-yellow-800 text-xl">
                  <i class="fa-solid fa-pen-to-square"></i>
                </a>

                <!-- Assign -->
                <a href="council/council_assign.php?id=<?= $c['id'] ?>"
                  class="text-blue-600 hover:text-blue-800 text-xl">
                  <i class="fa-solid fa-users"></i>
                </a>

                <!-- Delete -->
                <a href="../handle/council_process.php?action=delete&id=<?= $c['id'] ?>"
                  onclick="return confirm('Xóa hội đồng này?')"
                  class="text-red-600 hover:text-red-800 text-xl">
                  <i class="fa-solid fa-trash"></i>
                </a>

              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

  </main>
</body>

</html>
