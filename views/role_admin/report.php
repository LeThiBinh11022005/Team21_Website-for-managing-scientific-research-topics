<?php
require_once __DIR__ . '/../../functions/auth.php';
require_once __DIR__ . '/../../functions/report_functions.php';
checkLogin(__DIR__ . '/../../index.php');

$stats = getTopicStats();
$topics = getAllTopicsWithStatus();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>DNU - Dashboard Báo cáo</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 flex h-screen">

<!-- Sidebar -->
<aside class="w-64 bg-white shadow-md flex flex-col h-screen sticky top-0">
    <?php include __DIR__ . '/../menu.php'; ?>
</aside>

<!-- Main -->
<main class="flex-1 overflow-auto p-6">
    <div class="max-w-7xl mx-auto">
        <h3 class="text-2xl font-bold mb-6 text-gray-800">THỐNG KÊ & BÁO CÁO ĐỀ TÀI</h3>

        <!-- Tổng quan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-blue-100 border-l-4 border-blue-600 p-4 rounded-lg shadow">
                <p class="text-gray-700 font-semibold">Tổng số đề tài</p>
                <p class="text-3xl font-bold text-blue-700"><?= $stats['total'] ?? 0 ?></p>
            </div>
            <div class="bg-yellow-100 border-l-4 border-yellow-600 p-4 rounded-lg shadow">
                <p class="text-gray-700 font-semibold">Đang thực hiện</p>
                <p class="text-3xl font-bold text-yellow-700"><?= $stats['in_progress'] ?? 0 ?></p>
            </div>
            <div class="bg-green-100 border-l-4 border-green-600 p-4 rounded-lg shadow">
                <p class="text-gray-700 font-semibold">Hoàn thành</p>
                <p class="text-3xl font-bold text-green-700"><?= $stats['completed'] ?? 0 ?></p>
            </div>
            <div class="bg-gray-100 border-l-4 border-gray-600 p-4 rounded-lg shadow">
                <p class="text-gray-700 font-semibold">Chưa phân công</p>
                <p class="text-3xl font-bold text-gray-700"><?= $stats['unassigned'] ?? 0 ?></p>
            </div>
        </div>

        <!-- Dashboard: Biểu đồ + side list -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Doughnut chart -->
            <div class="bg-white shadow-md rounded-lg border border-gray-200 p-6 lg:w-1/2">
                <canvas id="progressChart" class="w-full h-72"></canvas>
            </div>

            <!-- Side panel danh sách đề tài -->
            <div class="bg-white shadow-md rounded-lg border border-gray-200 p-4 lg:w-1/2">
                <h4 class="text-lg font-bold mb-2">Danh sách đề tài</h4>
                <ul id="topicList" class="list-disc list-inside text-gray-700 max-h-96 overflow-y-auto">
                    <li class="text-gray-400 italic">Nhấn vào phần trên biểu đồ để xem đề tài</li>
                </ul>
            </div>
        </div>

        <!-- Nút xuất PDF -->
        <div class="mt-6 text-center">
            <a href="export_report.php"
               class="inline-block px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
               ⬇️ Xuất báo cáo PDF
            </a>
        </div>
    </div>
</main>

<script>
const total = <?= $stats['total'] ?? 0 ?>;
const completed = <?= $stats['completed'] ?? 0 ?>;
const inProgress = <?= $stats['in_progress'] ?? 0 ?>;
const unassigned = <?= $stats['unassigned'] ?? 0 ?>;

// Nhóm đề tài theo trạng thái
const topics = <?= json_encode($topics) ?>;
const groupedTopics = {
    'Hoàn thành': topics.filter(t => t.status === 'Hoan thanh').map(t=>t.topic_name),
    'Đang thực hiện': topics.filter(t => t.status === 'Dang thuc hien').map(t=>t.topic_name),
    'Chưa phân công': topics.filter(t => !t.status || t.status === 'Chua phan cong').map(t=>t.topic_name)
};

// Doughnut chart
const ctx = document.getElementById('progressChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Hoàn thành','Đang thực hiện','Chưa phân công'],
        datasets: [{
            data: [completed, inProgress, unassigned],
            backgroundColor: ['#16a34a','#f59e0b','#6b7280'],
            borderColor: '#fff',
            borderWidth: 2
        }]
    },
    options: {
        responsive:true,
        maintainAspectRatio:false,
        cutout:'55%',
        plugins:{
            legend:{ position:'bottom', labels:{boxWidth:12,padding:16,usePointStyle:true}},
            tooltip:{callbacks:{
                label:function(ctx){ 
                    const val = ctx.raw || 0;
                    const percent = total ? ((val/total)*100).toFixed(1):0;
                    return ctx.label + ': ' + val + ' (' + percent + '%)';
                }
            }}
        }
    }
});

// Click update side list
document.getElementById('progressChart').onclick = function(evt){
    const points = chart.getElementsAtEventForMode(evt,'nearest',{intersect:true},true);
    if(points.length){
        const label = chart.data.labels[points[0].index];
        const list = groupedTopics[label] || [];
        const topicList = document.getElementById('topicList');
        if(list.length){
            topicList.innerHTML = list.map(name=>`<li>${name}</li>`).join('');
        }else{
            topicList.innerHTML = '<li class="text-gray-400 italic">Không có đề tài nào</li>';
        }
    }
};
</script>

</body>
</html>
