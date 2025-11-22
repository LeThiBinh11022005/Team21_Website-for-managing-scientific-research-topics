<?php
session_start();
require '../../functions/db_connection.php';

$account_id = $_SESSION['account_id'];

$stmt = $conn->prepare("
    SELECT 
        i.*, 
        t.topic_name,
        u.fullname AS lecturer_name
    FROM invitations i
    JOIN topics t ON i.topic_id = t.id
    JOIN accounts u ON t.created_by = u.id
    WHERE i.student_id = ?
");
$stmt->bind_param("i", $account_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lời mời hướng dẫn</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md h-screen sticky top-0">
        <?php include __DIR__ . '/../menu.php'; ?>
    </aside>

    <!-- Main -->
    <main class="flex-1 pl-6 py-6">
        <h1 class="text-2xl font-bold mb-4">Lời mời hướng dẫn</h1>

        <div class="bg-white p-6 rounded shadow w-full max-w-5xl">
            <?php if ($result->num_rows > 0): ?>
                
                <table class="w-full border border-gray-300">
                    <tr class="bg-gray-100">
                        <th class="p-2 border">Giảng viên</th>
                        <th class="p-2 border">Đề tài</th>
                        <th class="p-2 border">Trạng thái</th>
                        <th class="p-2 border">Ngày gửi</th>
                        <th class="p-2 border">Hành động</th>
                    </tr>

                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border"><?= $row['lecturer_name'] ?></td>
                            <td class="p-2 border"><?= $row['topic_name'] ?></td>
                            <td class="p-2 border">
                                <span class="px-2 py-1 rounded 
                                    <?= $row['status']=='pending' ? 'bg-yellow-100 text-yellow-700' :
                                    ($row['status']=='accepted' ? 'bg-green-100 text-green-700' :
                                                                    'bg-red-100 text-red-600') ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                            <td class="p-2 border"><?= $row['created_at'] ?></td>

                            <!-- Cột mới: Hành động -->
                            <td class="p-2 border text-center">

                                <?php if ($row['status'] == 'pending'): ?>
                                    <!-- Accept -->
                                    <form action="respond_invitation_process.php" method="POST" class="inline">
                                        <input type="hidden" name="invitation_id" value="<?= $row['id'] ?>">
                                        <button name="action" value="accept"
                                            class="icon-btn bg-green-100 text-green-700 hover:bg-green-200">
                                            <!-- Tick icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>

                                    <!-- Reject -->
                                    <form action="respond_invitation_process.php" method="POST" class="inline ml-2">
                                        <input type="hidden" name="invitation_id" value="<?= $row['id'] ?>">
                                        <button name="action" value="reject"
                                            class="icon-btn bg-red-100 text-red-700 hover:bg-red-200">
                                            <!-- X icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>

                                <?php else: ?>
                                    <span class="text-gray-500 italic">
                                        Đã <?= $row['status'] ?>
                                    </span>
                                <?php endif; ?>

                            </td>
                        </tr>
                    <?php endwhile; ?>

                </table>

            <?php else: ?>
                <p class="text-gray-600">Chưa có lời mời nào.</p>
            <?php endif; ?>
        </div>

    </main>

</body>
</html>
