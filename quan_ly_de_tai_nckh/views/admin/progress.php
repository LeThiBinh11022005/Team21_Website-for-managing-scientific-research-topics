<?php
require_once "../../functions/db_connection.php";

// Lấy từ khoá tìm kiếm
$search = isset($_GET['search']) ? trim($_GET['search']) : "";

// Tạo điều kiện tìm kiếm theo tên giảng viên
$whereSearch = "";
$params = [];
$types = "";

if ($search !== "") {
    $whereSearch = " AND a.fullname LIKE ? ";
    $params[] = "%".$search."%";
    $types .= "s";
}

// Truy vấn các đề tài đã duyệt, đang thực hiện, hoàn thành
$sql = "SELECT t.id, t.topic_name, t.status,
               COALESCE(p.progress, 0) AS progress,
               a.fullname AS teacher_name
        FROM topics t
        LEFT JOIN accounts a ON a.id = t.created_by
        LEFT JOIN progress_reports p ON p.topic_id = t.id
        WHERE t.status IN ('approved','in_progress','completed')
        $whereSearch
        ORDER BY t.id DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$topics = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Theo dõi tiến độ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex">
    
    <!-- Sidebar -->
    <?php include __DIR__ . '/../menu.php'; ?>

    <!-- Main content -->
    <main class="flex-1 p-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Theo dõi tiến độ đề tài
        </h1>

        <!-- Form tìm kiếm -->
        <form method="GET" class="mb-4 flex items-center gap-3">
            <input 
                type="text" 
                name="search" 
                placeholder="Tìm theo tên giảng viên..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                class="px-3 py-2 border rounded w-1/3 focus:ring focus:ring-blue-300 outline-none"
            >
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Tìm kiếm
            </button>

            <?php if ($search !== ""): ?>
            <a href="progress.php" class="px-4 py-2 bg-gray-300 rounded">
                Xoá lọc
            </a>
            <?php endif; ?>
        </form>

        <!-- Bảng hiển thị -->
        <div class="bg-white p-4 rounded shadow">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b font-semibold text-gray-700">
                        <th class="py-3">ID</th>
                        <th>Tên đề tài</th>
                        <th>Giảng viên</th>
                        <th class="w-1/3">Tiến độ</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $topics->fetch_assoc()): ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3"><?= $row['id'] ?></td>

                        <td><?= htmlspecialchars($row['topic_name']) ?></td>

                        <td class="text-gray-700">
                            <?= htmlspecialchars($row['teacher_name'] ?? "Không có") ?>
                        </td>

                        <!-- Thanh progress -->
                        <td>
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-blue-600 h-4 rounded-full text-xs text-white text-center"
                                     style="width: <?= intval($row['progress']) ?>%;">
                                    <?= intval($row['progress']) ?>%
                                </div>
                            </div>
                        </td>

                        <!-- Trạng thái -->
                        <td>
                            <?php
                                if ($row['status'] == 'approved') {
                                    echo '<span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded">Chưa bắt đầu</span>';
                                } elseif ($row['status'] == 'in_progress') {
                                    echo '<span class="px-3 py-1 bg-blue-200 text-blue-800 rounded">Đang thực hiện</span>';
                                } else {
                                    echo '<span class="px-3 py-1 bg-purple-200 text-purple-800 rounded">Hoàn thành</span>';
                                }
                            ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

    </main>

</body>
</html>
