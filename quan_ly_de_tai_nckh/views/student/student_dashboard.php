<?php
session_start();
require '../../functions/db_connection.php';

// Lấy ID sinh viên từ session
$user_id = $_SESSION['account_id'];

// Lấy đề tài sinh viên đang tham gia
$sql = "
    SELECT t.topic_name, t.status, a.fullname AS lecturer
    FROM topics t
    LEFT JOIN accounts a ON t.created_by = a.id
    WHERE t.student_id = ?
    LIMIT 1
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // <-- SỬA Ở ĐÂY
$stmt->execute();
$stmt->bind_result($topic_name, $topic_status, $lecturer_name);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Sinh viên - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
        <?php include __DIR__ . '/../menu.php'; ?>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 p-8 overflow-y-auto">

        <h2 class="text-2xl font-bold mb-6">Bảng điều khiển sinh viên</h2>

        <?php if ($topic_name): ?>
            <div class="bg-white p-6 rounded-xl shadow-md border">
                <h3 class="text-xl font-semibold mb-3">Đề tài của bạn</h3>

                <p class="mb-2">
                    <strong>Tên đề tài:</strong> <?= htmlspecialchars($topic_name) ?>
                </p>

                <p class="mb-2">
                    <strong>Giảng viên hướng dẫn:</strong>
                    <?= $lecturer_name ? htmlspecialchars($lecturer_name) : 'Chưa có' ?>
                </p>

                <p class="mb-2">
                    <strong>Trạng thái:</strong>
                    <span class="px-3 py-1 rounded-lg bg-blue-100 text-blue-600 font-medium">
                        <?= htmlspecialchars($topic_status) ?>
                    </span>
                </p>
            </div>

        <?php else: ?>
            <div class="bg-red-100 text-red-700 px-6 py-4 rounded-lg shadow-md border border-red-200">
                <strong>⚠ Bạn chưa được phân công đề tài nào.</strong>
            </div>
        <?php endif; ?>

    </main>

</body>
</html>

