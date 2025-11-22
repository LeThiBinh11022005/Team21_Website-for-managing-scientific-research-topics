<?php
session_start();
require '../../functions/db_connection.php';

$account_id = $_SESSION['account_id'];

$sql = "
    SELECT t.topic_name, e.score, e.comment, e.status
    FROM evaluations e
    JOIN topics t ON e.topic_id = t.id
    WHERE t.student_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $account_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả đánh giá</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .status-badge {
            @apply px-3 py-1 text-sm rounded;
        }
    </style>
</head>

<body class="bg-gray-100 flex h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen fixed">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<!-- Main -->
<main class="flex-1 p-8 ml-64">

    <h1 class="text-3xl font-bold mb-6">Kết quả đánh giá</h1>

    <div class="bg-white p-6 rounded-lg shadow">

        <?php if ($result->num_rows > 0): ?>

            <?php while ($row = $result->fetch_assoc()): ?>

                <div class="border border-gray-200 rounded-xl p-5 mb-5 shadow-sm hover:shadow-md transition">

                    <p class="text-lg font-semibold mb-1">
                        📌 Đề tài: <span class="font-normal"><?= $row['topic_name'] ?></span>
                    </p>

                    <p class="mb-1">
                        ⭐ <strong>Điểm:</strong> 
                        <span class="text-blue-600 font-semibold"><?= $row['score'] ?></span>
                    </p>

                    <p class="mb-2">
                        📝 <strong>Nhận xét:</strong><br>
                        <span class="block bg-gray-50 p-3 rounded border"><?= $row['comment'] ?></span>
                    </p>

                    <p>
                        <strong>Trạng thái:</strong>

                        <?php
                            $color = match ($row['status']) {
                                'passed' => 'bg-green-100 text-green-700',
                                'failed' => 'bg-red-100 text-red-700',
                                default => 'bg-yellow-100 text-yellow-700'
                            };
                        ?>

                        <span class="status-badge <?= $color ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>
                    </p>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="p-5 bg-gray-50 border border-gray-200 rounded-lg text-gray-600">
                Chưa có đánh giá.
            </div>

        <?php endif; ?>

    </div>

</main>

</body>
</html>
