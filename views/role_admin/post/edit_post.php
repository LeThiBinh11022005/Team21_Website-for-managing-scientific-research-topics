<?php
require_once __DIR__ . '/../../../functions/auth.php';
require_once __DIR__ . '/../../../functions/post_functions.php';
checkLogin(__DIR__ . '/../../../index.php');

$id = $_GET['id'] ?? null;
$post = $id ? getPostById($id) : null;

if (!$post) {
    die("Không tìm thấy thông báo.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title && $content) {
        if (updatePost($id, $title, $content)) {
            header("Location: ../post.php");
            exit;
        } else {
            $error = "Không thể cập nhật!";
        }
    } else {
        $error = "Vui lòng nhập đầy đủ thông tin.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Sửa Thông Báo</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex h-screen">

<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../../menu.php'; ?>
</aside>

<main class="flex-1 p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h3 class="text-2xl font-bold mb-6 text-gray-800">Sửa thông báo</h3>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Tiêu đề</label>
                <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-1">Nội dung</label>
                <textarea name="content" rows="6" required
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-300"><?= htmlspecialchars($post['content']) ?></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="../post.php" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Hủy</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Lưu</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>
