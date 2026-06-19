<?php require '../app/Views/layouts/header.php'; ?>

<h1 class="text-3xl font-bold mb-4">
    Admin Dashboard
</h1>

<div class="grid grid-cols-3 gap-4">

    <a href="?route=admin/users">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-500">Users</h2>
            <p class="text-4xl font-bold mt-2">
                <?= (isset($stats) && isset($stats['users'])) ? $stats['users'] : 0 ?>
            </p>
        </div>
    </a>

    <a href="?route=admin/products">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-500">Products</h2>
            <p class="text-4xl font-bold mt-2">
                <?= (isset($stats) && isset($stats['products'])) ? $stats['products'] : 0 ?>
            </p>
        </div>
    </a>

    <a href="?route=posts">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-gray-500">Posts</h2>
            <p class="text-4xl font-bold mt-2">
                <?= (isset($stats) && isset($stats['posts'])) ? $stats['posts'] : 0 ?>
            </p>
        </div>
    </a>

</div>

<?php require '../app/Views/layouts/footer.php'; ?>