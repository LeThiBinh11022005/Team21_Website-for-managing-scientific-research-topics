<?php
require '../../../functions/db_connection.php';

$topic_id = $_GET['id'];

// Lấy thông tin đề tài
$sql = "SELECT t.*, a.fullname AS lecturer, c.council_name
        FROM topics t
        LEFT JOIN councils c ON t.council_id = c.id
        LEFT JOIN accounts a ON t.created_by = a.id
        WHERE t.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$topic = $stmt->get_result()->fetch_assoc();

// Lấy danh sách hội đồng
$sql_cm = "SELECT cm.role, acc.fullname
           FROM council_members cm
           JOIN accounts acc ON cm.teacher_id = acc.id
           WHERE cm.council_id = ?";
$stmt2 = $conn->prepare($sql_cm);
$stmt2->bind_param("i", $topic['council_id']);
$stmt2->execute();
$members = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Chi tiết bảo vệ đề tài</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<?php include __DIR__ . '/../../menu.php'; ?>

<main class="flex-1 p-8 overflow-auto">

    <div class="bg-white p-6 rounded shadow max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-4 text-center">CHI TIẾT KẾT QUẢ BẢO VỆ</h1>

        <h2 class="font-semibold mt-4">1. Thông tin đề tài</h2>
        <p><b>Tên đề tài:</b> <?= htmlspecialchars($topic['topic_name']) ?></p>
        <p><b>Chủ nhiệm:</b> <?= htmlspecialchars($topic['lecturer']) ?></p>

        <h2 class="font-semibold mt-6">2. Hội đồng bảo vệ</h2>

        <?php if (count($members) > 0): ?>
            <ul class="list-disc ml-6">
                <?php foreach ($members as $m): ?>
                    <li><b><?= $m['role'] ?>:</b> <?= htmlspecialchars($m['fullname']) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p><i>Chưa phân công hội đồng</i></p>
        <?php endif; ?>

        <h2 class="font-semibold mt-6">3. Nhận xét</h2>
        <p><?= $topic['defense_comment'] ? nl2br(htmlspecialchars($topic['defense_comment'])) : "<i>Chưa có nhận xét</i>" ?></p>

        <h2 class="font-semibold mt-6">4. Kết luận</h2>
        <p>
            <?php if ($topic['defense_status'] == "success"): ?>
                <span class="text-green-600 font-bold">Bảo vệ thành công</span>
            <?php else: ?>
                <span class="text-red-600 font-bold">Không đạt yêu cầu</span>
            <?php endif; ?>
        </p>

        <h2 class="font-semibold mt-6">5. Biên bản bảo vệ</h2>
        <?php if (!empty($topic['defense_file'])): ?>
            <a class="text-blue-600 underline" 
               href="/quan_ly_de_tai_nckh/uploads/defense/<?= $topic['defense_file'] ?>" 
               target="_blank">
               📄 Xem biên bản
            </a>
        <?php else: ?>
            <p><i>Chưa có biên bản</i></p>
        <?php endif; ?>

    </div>

</main>

</body>
</html>
