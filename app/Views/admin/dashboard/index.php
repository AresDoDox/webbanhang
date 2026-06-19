<?php require '../app/Views/layouts/header.php'; ?>

<h1 class="text-3xl font-bold mb-4">
    Admin Dashboard
</h1>

<div class="grid grid-cols-3 gap-4">

    <a href="<?= BASE_PATH ?>/admin/users">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-500">Users</h2>
            <p class="text-4xl font-bold mt-2">
                <?= (isset($stats) && isset($stats['users']['total'])) ? $stats['users']['total'] : 0 ?>
            </p>
        </div>
    </a>

    <a href="<?= BASE_PATH ?>/admin/products">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-500">Products</h2>
            <p class="text-4xl font-bold mt-2">
                <?= (isset($stats) && isset($stats['products']['total'])) ? $stats['products']['total'] : 0 ?>
            </p>
        </div>
    </a>

    <a href="<?= BASE_PATH ?>/posts">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-500">Posts</h2>
            <p class="text-4xl font-bold mt-2">
                <?= (isset($stats) && isset($stats['posts']['total'])) ? $stats['posts']['total'] : 0 ?>
            </p>
        </div>
    </a>

    <canvas id="statsChart"></canvas>

</div>

<?php
$userMonthly = $stats['users']['monthly'] ?? [];
$productMonthly = $stats['products']['monthly'] ?? [];
$postMonthly = $stats['posts']['monthly'] ?? [];

$userMap = [];
foreach ($userMonthly as $item) {
    $userMap[(int) $item['month']] = (int) $item['total'];
}

$productMap = [];
foreach ($productMonthly as $item) {
    $productMap[(int) $item['month']] = (int) $item['total'];
}

$postMap = [];
foreach ($postMonthly as $item) {
    $postMap[(int) $item['month']] = (int) $item['total'];
}

$months = array_unique(array_merge(
    array_keys($userMap),
    array_keys($productMap),
    array_keys($postMap)
));
sort($months);

$monthNames = [
    1 => 'Jan',
    2 => 'Feb',
    3 => 'Mar',
    4 => 'Apr',
    5 => 'May',
    6 => 'Jun',
    7 => 'Jul',
    8 => 'Aug',
    9 => 'Sep',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dec'
];

$labels = [];
foreach ($months as $month) {
    $labels[] = $monthNames[$month] ?? $month;
}

$userData = [];
$productData = [];
$postData = [];
foreach ($months as $month) {
    $userData[] = $userMap[$month] ?? 0;
    $productData[] = $productMap[$month] ?? 0;
    $postData[] = $postMap[$month] ?? 0;
}
?>

<script>
const ctx = document.getElementById('statsChart').getContext('2d');
new Chart(
    ctx, {
        type: 'bar',
        data: {
            labels: [<?= implode(', ', array_map(fn($label) => "'" . addslashes($label) . "'", $labels)) ?>],
            datasets: [{
                    label: 'Users',
                    backgroundColor: 'rgba(59, 130, 246, 0.75)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    data: [<?= implode(', ', $userData) ?>]
                },
                {
                    label: 'Products',
                    backgroundColor: 'rgba(16, 185, 129, 0.75)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    data: [<?= implode(', ', $productData) ?>]
                },
                {
                    label: 'Posts',
                    backgroundColor: 'rgba(234, 88, 12, 0.75)',
                    borderColor: 'rgba(234, 88, 12, 1)',
                    data: [<?= implode(', ', $postData) ?>]
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    }
);
</script>
<?php require '../app/Views/layouts/footer.php'; ?>