<?php
require '../../functions/db_connection.php';

$sql = "
    SELECT 
        t.id AS topic_id,
        t.topic_name,
        a.fullname AS lecturer,
        e.score,
        e.status AS defense_status
    FROM topics t
    LEFT JOIN accounts a ON t.created_by = a.id
    LEFT JOIN evaluations e ON e.topic_id = t.id
    WHERE t.status = 'completed'
    ORDER BY t.id DESC
";

$result = $conn->query($sql);
$topics = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo trạng thái bảo vệ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a2e860f7f5.js" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<?php include __DIR__ . '/../menu.php'; ?>

<main class="flex-1 p-6 overflow-auto">

    <h1 class="text-2xl font-bold mb-4">Danh sách bảo vệ đề tài</h1>

    <div class="bg-white p-4 rounded shadow">

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-700 text-white">
                    <th class="border p-3">ID</th>
                    <th class="border p-3">Tên đề tài</th>
                    <th class="border p-3">Chủ nhiệm</th>
                    <th class="border p-3">Điểm</th>
                    <th class="border p-3">Trạng thái</th>
                    <th class="border p-3">Hành động</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($topics as $t): ?>

                <tr class="border hover:bg-gray-100">

                    <td class="p-3"><?= $t['topic_id'] ?></td>
                    <td class="p-3"><?= htmlspecialchars($t['topic_name']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($t['lecturer']) ?></td>

                    <!-- Điểm -->
                    <td class="p-3">
                        <?php 
                            if ($t['score'] === null) {
                                echo "<i>Chưa nhập</i>";
                            } else {
                                echo $t['score'] . "/10";
                            }
                        ?>
                    </td>

                    <!-- Trạng thái -->
                    <td class="p-3">
                        <?php 
                            if ($t['defense_status'] === null) {
                                echo '<span class="text-gray-500 italic">Chưa có</span>';
                            } elseif ($t['defense_status'] === "passed") {
                                echo '<span class="text-green-600 font-semibold">Bảo vệ thành công</span>';
                            } else {
                                echo '<span class="text-red-600 font-semibold">Chưa đạt</span>';
                            }
                        ?>
                    </td>

                    <td class="p-3 text-center">
                        <a href="/quan_ly_de_tai_nckh/views/admin/defense/defense_detail.php?id=<?= $t['topic_id'] ?>"
                           class="text-blue-600 hover:text-blue-800 text-xl" title="Xem chi tiết">
                           <i class="fa-solid fa-circle-info"></i>
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
