<?php require_once __DIR__ . '/../../../functions/account_functions.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thêm tài khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex justify-center items-center p-6">

<div class="bg-white w-full max-w-lg p-8 rounded-lg shadow-lg">

    <h2 class="text-2xl font-bold mb-6 text-center">Thêm tài khoản</h2>

    <form action="../../../handle/account_process.php?action=add" method="POST" class="space-y-4">

        <input name="username" required placeholder="Tên tài khoản"
               class="border px-4 py-3 w-full rounded">

        <input name="fullname" required placeholder="Họ và tên"
               class="border px-4 py-3 w-full rounded">

        <input name="email" type="email" required placeholder="Email"
               class="border px-4 py-3 w-full rounded">

        <input name="password" type="text" required placeholder="Mật khẩu"
               class="border px-4 py-3 w-full rounded">

        <select name="role" class="border px-4 py-3 w-full rounded">
            <option value="student">Sinh viên</option>
            <option value="lecturer">Giảng viên</option>
            <option value="admin">Quản trị</option>
        </select>

        <button class="w-full py-3 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700">
            Thêm
        </button>

    </form>

</div>

</body>
</html>
