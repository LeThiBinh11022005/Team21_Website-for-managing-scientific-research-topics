<?php
require '../../../functions/db_connection.php';

// Lấy ID đề tài
$topic_id = $_GET['id'] ?? 0;

// Lấy thông tin đề tài
$sql = "SELECT t.*, a.fullname AS lecturer
        FROM topics t
        LEFT JOIN accounts a ON t.created_by = a.id
        WHERE t.id = $topic_id";
$result = $conn->query($sql);
$topic = $result->fetch_assoc();

// Nếu không tìm thấy
if (!$topic) {
    die("Đề tài không tồn tại!");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhập điểm & nhận xét</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex min-h-screen">

<?php include __DIR__ . '/../../menu.php'; ?>

<main class="flex-1 p-6">

    <h1 class="text-2xl font-bold mb-4">Nhập điểm & nhận xét đề tài</h1>

    <div class="bg-white p-6 rounded shadow max-w-2xl">

        <p class="text-lg"><b>Đề tài:</b> <?= htmlspecialchars($topic['topic_name']) ?></p>
        <p class="mb-4"><b>Giảng viên hướng dẫn:</b> <?= htmlspecialchars($topic['lecturer']) ?></p>

        <form action="/quan_ly_de_tai_nckh/handle/evaluation_input_process.php" method="POST" class="space-y-4">

            <input type="hidden" name="topic_id" value="<?= $topic_id ?>">

            <div>
                <label class="font-semibold">Điểm:</label>
                <input type="number" name="score" step="0.1" min="0" max="10"
                       class="w-full mt-1 p-2 border rounded" required>
            </div>

            <div>
                <label class="font-semibold">Nhận xét:</label>
                <textarea name="comment" rows="4"
                          class="w-full mt-1 p-2 border rounded" required></textarea>
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Lưu kết quả
            </button>

        </form>

    </div>

</main>
</body>
</html>
