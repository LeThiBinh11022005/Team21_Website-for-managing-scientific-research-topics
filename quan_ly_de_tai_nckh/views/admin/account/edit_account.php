<?php
require_once __DIR__ . '/../../../functions/account_functions.php';
$id = $_GET['id'];
$acc = getAccountById($id);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sửa tài khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-6">

<h2 class="text-xl font-bold mb-4">Sửa tài khoản</h2>

<form action="../../../handle/account_process.php?action=edit" method="POST" class="space-y-3">
    <input type="hidden" name="id" value="<?= $acc['id'] ?>">

    <input name="username" value="<?= $acc['username'] ?>" required class="border px-3 py-2 w-full">

    <input name="fullname" value="<?= $acc['fullname'] ?>" required class="border px-3 py-2 w-full">

    <input name="email" type="email" value="<?= $acc['email'] ?>" required class="border px-3 py-2 w-full">

    <input name="password" placeholder="Để trống nếu không đổi" class="border px-3 py-2 w-full">

    <select name="role" class="border px-3 py-2 w-full">
        <option value="student"  <?= $acc['role']=='student'?'selected':'' ?>>Sinh viên</option>
        <option value="lecturer" <?= $acc['role']=='lecturer'?'selected':'' ?>>Giảng viên</option>
        <option value="admin"    <?= $acc['role']=='admin'?'selected':'' ?>>Quản trị</option>
    </select>

    <button class="px-4 py-2 bg-yellow-600 text-white rounded">Cập nhật</button>
</form>

</body>
</html>
