<?php
session_start();
require '../../functions/db_connection.php';

$account_id = $_SESSION['account_id'];

$sql = "SELECT id, topic_name FROM topics WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $account_id);
$stmt->execute();
$stmt->bind_result($topic_id, $topic_name);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Nộp tiến độ</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

    <aside class="w-64 bg-white shadow-md flex flex-col h-screen">
        <?php include __DIR__ . '/../menu.php'; ?>
    </aside>

    <main class="flex-1 p-6 ml-64">
        <h1 class="text-2xl font-bold mb-4">Nộp tiến độ</h1>

        <?php if ($topic_id): ?>
            <form action="../../handle/upload_progress_handle.php" method="POST" enctype="multipart/form-data"
                class="bg-white p-6 rounded shadow w-full max-w-lg">

                <input type="hidden" name="topic_id" value="<?= $topic_id ?>">

                <p><strong>Đề tài:</strong> <?= $topic_name ?></p>

                <label class="block mt-4">Ghi chú</label>
                <textarea name="note" class="w-full border p-2 rounded" rows="4"></textarea>

                <label class="block mt-4">Tệp tiến độ</label>
                <input type="file" name="progress_file" class="w-full">

                <button
                    class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Nộp
                </button>
            </form>

        <?php else: ?>
            <div class="p-5 bg-red-100 text-red-600 rounded shadow">
                Bạn chưa có đề tài để nộp tiến độ.
            </div>
        <?php endif; ?>
    </main>

</body>

</html>
