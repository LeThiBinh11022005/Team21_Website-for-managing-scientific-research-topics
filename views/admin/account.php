<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/account_functions.php';

checkLogin(__DIR__ . '/../../index.php');

// Lọc phân quyền
$roleFilter = $_GET['role'] ?? '';
$accounts = getAllAccounts($roleFilter);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>DNU - Quản lý tài khoản</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<main class="flex-1 overflow-auto p-6">
    <div class="max-w-7xl mx-auto">

        <h3 class="text-2xl font-bold mb-6">DANH SÁCH TÀI KHOẢN</h3>

        <!-- Bộ lọc -->
        <form method="GET" class="mb-4 flex items-center gap-3">
            <label class="font-medium">Lọc theo phân quyền:</label>

            <select name="role" onchange="this.form.submit()" class="border rounded px-3 py-2">
                <option value="">Tất cả</option>
                <option value="student"  <?= $roleFilter=='student'?'selected':'' ?>>Sinh viên</option>
                <option value="lecturer" <?= $roleFilter=='lecturer'?'selected':'' ?>>Giảng viên</option>
                <option value="admin"    <?= $roleFilter=='admin'?'selected':'' ?>>Quản trị</option>
            </select>
        </form>

        <!-- Nút thêm / Xóa nhiều -->
        <div class="mb-4 flex gap-3">
            <a href="account/create_account.php"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Thêm tài khoản
            </a>

            <button id="deleteSelected"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 hidden"
                    onclick="deleteSelectedAccounts()">
                Xóa nhiều
            </button>
        </div>

        <!-- Bảng tài khoản -->
        <form id="accountsForm" method="POST"
              action="../../handle/account_process.php?action=delete_multiple">

            <div class="overflow-x-auto bg-white shadow-md rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-center">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-3 px-3">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th class="py-3 px-4">ID</th>
                            <th class="py-3 px-4">Tên tài khoản</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Họ và tên</th>
                            <th class="py-3 px-4">Phân quyền</th>
                            <th class="py-3 px-4">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        <?php if (!empty($accounts)): ?>
                            <?php foreach ($accounts as $acc): ?>
                                <tr class="hover:bg-gray-100">

                                    <td class="py-2 px-3">
                                        <input type="checkbox"
                                               class="selectItem"
                                               name="ids[]"
                                               value="<?= $acc['id'] ?>">
                                    </td>

                                    <td class="py-2 px-4"><?= $acc['id'] ?></td>
                                    <td class="py-2 px-4"><?= htmlspecialchars($acc['username']) ?></td>
                                    <td class="py-2 px-4"><?= htmlspecialchars($acc['email']) ?></td>
                                    <td class ="py-2 px-4"><?= htmlspecialchars($acc['fullname']) ?></td>

                                    <td class="py-2 px-4">
                                        <?= $acc['role']=='admin' ? "Quản trị" :
                                            ($acc['role']=='lecturer' ? "Giảng viên" : "Sinh viên") ?>
                                    </td>

                                    <td class="py-3 px-4 flex justify-center space-x-2">

                                        <!-- Nút sửa -->
                                        <a href="account/edit_account.php?id=<?= $acc['id'] ?>"
                                           class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs flex items-center gap-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M15.232 5.232l3.536 3.536M4 20h4l11-11-4-4-11 11v4z"/>
                                            </svg>
                                        </a>

                                        <!-- Nút xóa -->
                                        <a href="../../handle/account_process.php?action=delete&id=<?= $acc['id'] ?>"
                                           onclick="return confirm('Bạn chắc chắn muốn xóa tài khoản này?')"
                                           class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a1
                                                      1 0 00-1 1v1h6V4a1 1 0 00-1-1m-4 0h4" />
                                            </svg>
                                        </a>

                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-4 text-gray-500">
                                    Không có tài khoản nào.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </form>
    </div>
</main>

<script>
const selectAll = document.getElementById('selectAll');
const items = document.querySelectorAll('.selectItem');
const deleteBtn = document.getElementById('deleteSelected');

// Chọn tất cả
selectAll.addEventListener('change', () => {
    items.forEach(i => i.checked = selectAll.checked);
    toggleDeleteButton();
});

// Bật/tắt nút Xóa nhiều
items.forEach(i => i.addEventListener('change', toggleDeleteButton));

function toggleDeleteButton() {
    const anyChecked = [...items].some(i => i.checked);
    deleteBtn.classList.toggle('hidden', !anyChecked);
}

function deleteSelectedAccounts() {
    if (confirm('Bạn có chắc chắn muốn xóa các tài khoản đã chọn?')) {
        document.getElementById('accountsForm').submit();
    }
}
</script>

</body>
</html>
