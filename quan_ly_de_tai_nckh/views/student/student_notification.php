<?php
session_start();
require '../../functions/db_connection.php';

$account_id = $_SESSION['account_id'];

$sql = "
    SELECT message, created_at, is_read
    FROM notifications
    WHERE user_id = ?
    ORDER BY created_at DESC
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
    <title>Thông báo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<aside class="w-64 bg-white shadow-md flex flex-col h-screen">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<main class="flex-1 p-6">
    <h1 class="text-2xl font-bold mb-6">🔔 Thông báo</h1>

    <div class="bg-white p-5 rounded-lg shadow-md divide-y">

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>

                <div class="flex justify-between items-start py-4 
                    <?= $row['is_read'] ? '' : 'bg-blue-50' ?> rounded-md px-3">

                    <div>
                        <p class="text-base <?= $row['is_read'] ? 'text-gray-700' : 'text-blue-900 font-semibold' ?>">
                            <?= $row['message'] ?>
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            <?= date("d/m/Y - H:i", strtotime($row['created_at'])) ?>
                        </p>
                    </div>

                    <?php if (!$row['is_read']): ?>
                        <span class="text-xs bg-blue-500 text-white px-2 py-1 rounded-full">
                            Mới
                        </span>
                    <?php endif; ?>

                </div>

            <?php endwhile; ?>

        <?php else: ?>
            <p class="text-gray-600 text-center py-10">Không có thông báo nào.</p>
        <?php endif; ?>

    </div>
</main>

</body>
</html>
