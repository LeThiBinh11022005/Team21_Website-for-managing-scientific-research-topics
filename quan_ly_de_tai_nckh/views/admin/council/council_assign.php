<?php
require_once dirname(__DIR__, 3) . '/functions/db_connection.php';

// Lấy danh sách hội đồng
$councils = $conn->query("SELECT * FROM councils");

// Lấy danh sách giảng viên
$teachers = $conn->query("SELECT id, fullname FROM accounts WHERE role = 'teacher'");

// Lấy id hội đồng đang chọn
$council_id = $_GET['id'] ?? 0;

$members = [];
if ($council_id) {
    $stmt = $conn->prepare("
        SELECT cm.id, a.fullname 
        FROM council_members cm
        JOIN accounts a ON a.id = cm.teacher_id
        WHERE cm.council_id = ?
    ");
    $stmt->bind_param("i", $council_id);
    $stmt->execute();
    $members = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Phân công thành viên hội đồng</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<!-- Sidebar -->
<?php include __DIR__ . '/../../menu.php'; ?>

<!-- Main -->
<main class="flex-1 p-6 overflow-auto">

    <h2 class="text-2xl font-bold mb-6">Phân công thành viên hội đồng</h2>

    <!-- Chọn hội đồng -->
    <form method="GET" class="mb-6">
        <label class="font-semibold">Chọn hội đồng:</label>
        <select name="id" onchange="this.form.submit()" class="border px-3 py-2 rounded">
            <option value="">-- Chọn hội đồng --</option>
            <?php while ($c = $councils->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>" <?= $council_id == $c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['council_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php if ($council_id): ?>

    <!-- Form thêm thành viên -->
    <div class="bg-white p-4 rounded shadow mb-6">
        <form action="/handle/council_assign_process.php" method="POST" class="flex gap-4 items-center">
            <input type="hidden" name="council_id" value="<?= $council_id ?>">

            <select name="teacher_id" class="border p-2 rounded">
                <option value="">-- Chọn giảng viên --</option>
                <?php while ($t = $teachers->fetch_assoc()): ?>
                    <option value="<?= $t['id'] ?>">
                        <?= htmlspecialchars($t['fullname']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Thêm vào hội đồng
            </button>
        </form>
    </div>

    <!-- Danh sách thành viên -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">Thành viên hội đồng</h3>

        <table class="w-full text-left">
            <thead>
                <tr class="border-b font-semibold">
                    <th class="py-2">Tên giảng viên</th>
                    <th class="py-2">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($members as $m): ?>
                <tr class="border-b">
                    <td class="py-2"><?= htmlspecialchars($m['fullname']) ?></td>
                    <td class="py-2">
                        <a href="/handle/council_assign_process.php?action=remove&id=<?= $m['id'] ?>&council=<?= $council_id ?>"
                           class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                           onclick="return confirm('Xoá thành viên khỏi hội đồng?')">
                           Xoá
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

    <?php endif; ?>

</main>

</body>
</html>
