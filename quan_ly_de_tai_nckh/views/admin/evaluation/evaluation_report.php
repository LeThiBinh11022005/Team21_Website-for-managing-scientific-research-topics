<?php
require '../../../functions/db_connection.php';

$topic_id = $_GET['id'] ?? 0;

// Lấy thông tin đề tài
$sql_topic = "SELECT t.*, a.fullname AS lecturer 
              FROM topics t 
              LEFT JOIN accounts a ON t.created_by = a.id
              WHERE t.id = ?";
$stmt = $conn->prepare($sql_topic);
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$topic = $stmt->get_result()->fetch_assoc();

// Nếu đề tài không tồn tại
if (!$topic) {
    die("<h2 style='color:red; text-align:center;'>Không tìm thấy đề tài!</h2>");
}

// Lấy kết quả nghiệm thu
$sql_eval = "SELECT * FROM evaluations WHERE topic_id = ?";
$stmt2 = $conn->prepare($sql_eval);
$stmt2->bind_param("i", $topic_id);
$stmt2->execute();
$evaluation = $stmt2->get_result()->fetch_assoc();

// Gán biến an toàn
$score   = $evaluation['score']   ?? null;
$comment = $evaluation['comment'] ?? null;

// Tính trạng thái hiển thị
if ($score === null) {
    $status = "<span class='text-gray-500 italic'>Chưa có kết quả</span>";
} else {
    $status = ($score >= 5)
        ? "<span class='text-green-600 font-bold'>Đạt yêu cầu nghiệm thu</span>"
        : "<span class='text-red-600 font-bold'>Không đạt yêu cầu nghiệm thu</span>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Biên bản nghiệm thu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<?php include __DIR__ . '/../../menu.php'; ?>

<main class="flex-1 p-8 overflow-auto">

    <div class="bg-white p-6 rounded shadow max-w-3xl mx-auto">

        <h1 class="text-2xl font-bold mb-4 text-center">BIÊN BẢN NGHIỆM THU ĐỀ TÀI</h1>

        <!-- 1. Thông tin -->
        <h2 class="font-semibold mt-4">1. Thông tin đề tài</h2>
        <p><b>Tên đề tài:</b> <?= htmlspecialchars($topic['topic_name']) ?></p>
        <p><b>Chủ nhiệm:</b> <?= htmlspecialchars($topic['lecturer']) ?></p>

        <!-- 2. Kết quả -->
        <h2 class="font-semibold mt-6">2. Kết quả nghiệm thu</h2>
        <p><b>Điểm:</b>
            <?= $score !== null ? $score : "<i>Chưa có dữ liệu</i>" ?>/10
        </p>

        <!-- 3. Nhận xét -->
        <h2 class="font-semibold mt-6">3. Nhận xét của hội đồng</h2>
        <p>
            <?= $comment !== null ? nl2br(htmlspecialchars($comment)) : "<i>Chưa có nhận xét</i>" ?>
        </p>

        <!-- 4. Kết luận -->
        <h2 class="font-semibold mt-6">4. Kết luận</h2>
        <p><?= $status ?></p>

    </div>

</main>

</body>
</html>
