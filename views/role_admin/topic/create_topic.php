<?php
require_once __DIR__ . '/../../../functions/auth.php';
require_once __DIR__ . '/../../../functions/db_connection.php';
checkLogin(__DIR__ . '/../../../index.php');

// Lấy danh sách giảng viên và sinh viên
$lecturers = mysqli_query($conn, "SELECT id, account_name FROM accounts WHERE role = 'lecturer'");
$students = mysqli_query($conn, "SELECT id, account_name FROM accounts WHERE role = 'student'");

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topic_code = $_POST['topic_code'];
    $topic_name = $_POST['topic_name'];
    $lecturer_id = !empty($_POST['lecturer_id']) ? $_POST['lecturer_id'] : null;
    $student_ids = $_POST['student_ids'] ?? [];
    $status = $_POST['status'];
    $start_date = $_POST['start_date'] ?: null;
    $end_date = $_POST['end_date'] ?: null;

    $sql = "INSERT INTO topics (topic_code, topic_name, lecturer_id, status, start_date, end_date)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssisss", $topic_code, $topic_name, $lecturer_id, $status, $start_date, $end_date);
    mysqli_stmt_execute($stmt);
    $topic_id = mysqli_insert_id($conn);

    // Gán sinh viên vào đề tài
    if (!empty($student_ids)) {
        foreach ($student_ids as $student_id) {
            mysqli_query($conn, "INSERT INTO topic_student (topic_id, student_id) VALUES ($topic_id, $student_id)");
        }
    }

    header("Location: ../topic.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm đề tài mới</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../../menu.php'; ?>
</aside>

<!-- Nội dung chính -->
<main class="flex-1 p-6 overflow-auto">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h3 class="text-2xl font-bold mb-6 text-gray-800">Thêm đề tài mới</h3>

        <form method="POST" class="space-y-5">
            <div>
                <label class="block font-semibold mb-1">Mã đề tài</label>
                <input type="text" name="topic_code" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-semibold mb-1">Tên đề tài</label>
                <input type="text" name="topic_name" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-semibold mb-1">Giảng viên hướng dẫn</label>
                <select name="lecturer_id" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">-- Chưa phân công --</option>
                    <?php while ($row = mysqli_fetch_assoc($lecturers)): ?>
                        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['account_name']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block font-semibold mb-1">Chọn sinh viên</label>
                <div class="grid grid-cols-2 gap-2 border rounded-lg p-3 max-h-48 overflow-y-auto">
                    <?php while ($s = mysqli_fetch_assoc($students)): ?>
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="student_ids[]" value="<?= $s['id'] ?>" class="accent-blue-600">
                            <span><?= htmlspecialchars($s['account_name']) ?></span>
                        </label>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold mb-1">Ngày bắt đầu</label>
                    <input type="date" name="start_date" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
                <div>
                    <label class="block font-semibold mb-1">Ngày kết thúc</label>
                    <input type="date" name="end_date" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>
            </div>

            <div>
                <label class="block font-semibold mb-1">Trạng thái</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="Chua phan cong">Chưa phân công</option>
                    <option value="Dang thuc hien">Đang thực hiện</option>
                    <option value="Hoan thanh">Hoàn thành</option>
                </select>
            </div>

            <div class="flex justify-end space-x-3 pt-4">
                <a href="../topic.php" class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">Hủy</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lưu</button>
            </div>
        </form>
    </div>
</main>
</body>
</html>
