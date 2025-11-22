<?php
require '../../functions/db_connection.php';

// Lấy danh sách đề tài đã hoàn thành
$sql = "SELECT t.id, t.topic_name, a.fullname AS lecturer
        FROM topics t
        LEFT JOIN accounts a ON t.created_by = a.id
        WHERE t.status = 'completed'";

$result = $conn->query($sql);
$topics = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Nghiệm thu đề tài</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <?php include __DIR__ . '/../menu.php'; ?>

    <main class="flex-1 overflow-auto p-6">

        <h1 class="text-2xl font-bold mb-4">Danh sách nghiệm thu đề tài</h1>

        <div class="bg-white p-4 rounded shadow">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-700 text-white">
                        <th class="border p-3">ID</th>
                        <th class="border p-3">Tên đề tài</th>
                        <th class="border p-3">Giảng viên</th>
                        <th class="border p-3">Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($topics as $t): ?>
                        <tr class="border hover:bg-gray-100">
                            <td class="p-3"><?= $t['id'] ?></td>
                            <td class="p-3"><?= htmlspecialchars($t['topic_name']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($t['lecturer']) ?></td>

                            <td class="p-3 flex gap-4 text-xl">
                                <a href="evaluation/evaluation_input.php?id=<?= $t['id'] ?>"
                                class="text-blue-600 hover:text-blue-800" title="Nhập điểm & nhận xét">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <a href="evaluation/evaluation_report.php?id=<?= $t['id'] ?>"
                                class="text-green-600 hover:text-green-800" title="Xem biên bản nghiệm thu">
                                <i class="fa-solid fa-file-pdf"></i>
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
