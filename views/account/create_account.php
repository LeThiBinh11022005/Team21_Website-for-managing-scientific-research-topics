<?php
require_once __DIR__ . '/../../../functions/auth.php';
checkLogin(__DIR__ . '/../../../index.php');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm tài khoản mới</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
<div class="max-w-lg mx-auto bg-white p-6 rounded shadow-md">
    <h3 class="text-xl font-bold mb-4 text-center">Thêm tài khoản mới</h3>
    <form method="POST" action="../../../handle/account_process.php?action=add">
        <div class="mb-4">
            <label class="block font-medium mb-1">Tên tài khoản:</label>
            <input type="text" name="account_name" required class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">Email:</label>
            <input type="email" name="email" required class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">Mật khẩu:</label>
            <input type="password" name="password" required class="border rounded w-full px-3 py-2">
        </div>
        <div class="mb-4">
            <label class="block font-medium mb-1">Phân quyền:</label>
            <select name="role" class="border rounded w-full px-3 py-2">
                <option value="student">Sinh viên</option>
                <option value="lecturer">Giảng viên</option>
                <option value="admin">Quản trị</option>
            </select>
        </div>
        <div class="flex justify-between">
            <a href="../account.php" class="text-gray-600 hover:underline">← Quay lại</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Thêm</button>
        </div>
    </form>
</div>
</body>
</html>
