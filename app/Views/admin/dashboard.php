<?php require '../app/Views/layouts/header.php'; ?>

<h1 class="text-3xl font-bold mb-4">

    Admin Dashboard

</h1>

<div class="grid grid-cols-3 gap-4">

    <a href="?route=admin/users">
        <div class="bg-white p-6 rounded shadow">
            Users
        </div>
    </a>

    <a href="?route=admin/products">
        <div class="bg-white p-6 rounded shadow">
            Products
        </div>
    </a>

    <a href="?route=posts">
        <div class="bg-white p-6 rounded shadow">
            Posts
        </div>
    </a>

</div>

<?php require '../app/Views/layouts/footer.php'; ?>