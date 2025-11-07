<?php
require_once __DIR__ . '/../../../functions/auth.php';
require_once __DIR__ . '/../../../functions/account_functions.php';
checkLogin(__DIR__ . '/../../../index.php');

$id = $_GET['id'] ?? 0;
$acc = getAccountById($id);
if (!$acc) {
    die("Không tìm thấy tài khoản");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa tài khoản</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow-md">
    <h3 class="text-xl font-bold mb-4 text-center">Sửa tài khoản</h3>
    <form method="POST" action="../../../handle/account_process.php?action=edit">
        <input type="hidden" name="id" value="<?= htmlspecialchars($acc['id']) ?>">
        <div class="mb-4">
            <label class="block font-medium mb-1">Tên tài khoản:</label>
            <input type="text" name="account_name" value="<?= htmlspecialchars($acc['account_name']) ?>" required class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($acc['email']) ?>" required class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">Mật khẩu (để trống nếu không đổi):</label>
            <input type="password" name="password" class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">Phân quyền:</label>
            <select name="role" class="border rounded w-full px-3 py-2">
                <option value="student" <?= $acc['role']=='student'?'selected':'' ?>>Sinh viên</option>
                <option value="lecturer" <?= $acc['role']=='lecturer'?'selected':'' ?>>Giảng viên</option>
                <option value="admin" <?= $acc['role']=='admin'?'selected':'' ?>>Quản trị</option>
            </select>
        </div>
        <div class="flex justify-between">
            <a href="../account.php" class="text-gray-600 hover:underline">← Quay lại</a>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Lưu</button>
        </div>
    </form>
</div>
</body>
</html>
