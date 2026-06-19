<?php require '../app/Views/layouts/header.php'; ?>
<?php
// Ensure $result is defined to avoid undefined variable errors in the view
if (!isset($result) || !is_array($result)) {
    $result = [
        'data' => [],
        'totalPages' => 0,
        'keyword' => '',
    ];
}
?>

<div class="flex justify-between mb-6">

    <h1 class="text-3xl font-bold">
        Users
    </h1>

    <!-- <a href="?route=admin/users/create" class="bg-indigo-600 text-white px-4 py-2 rounded">
        Add Product
    </a> -->

</div>

<form method="GET">
    <div class="flex justify-between">
        <input type="hidden" name="route" value="admin/users">
        <input type="text" name="keyword" class="border w-full p-2 m-2">
        <button class="btn btn-blue">Search</button>
    </div>
</form>

<table class="w-full bg-white shadow">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($result['data'] ?? [] as $user): ?>

            <tr>

                <td>
                    <?= $user['id'] ?>
                </td>

                <td>
                    <?= htmlspecialchars($user['name']) ?>
                </td>

                <td>
                    <?= htmlspecialchars($user['email']) ?>
                </td>

                <td>
                    <?= $user['role'] ?>
                </td>

                <td>
                    <!-- <a href="?route=admin/users/show&id=<?= $user['id'] ?>" class="text-blue-500">
                    View
                </a>
                <a href="?route=admin/users/edit&id=<?= $user['id'] ?>" class="text-blue-500">
                    Edit
                </a>
                <a href="?route=admin/users/delete&id=<?= $user['id'] ?>" class="text-red-500">
                    Delete
                </a> -->
                </td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<div class="flex justify-center mt-2">
    <nav class="flex items-center gap-x-1" aria-label="Pagination">
        <div class="flex items-center gap-x-1">
            <?php if ($result['totalPages'] > 1): ?>
                <?php for ($i = 1; $i <= $result['totalPages']; $i++): ?>
                    <a href="?route=admin/users&page=<?= $i ?>&keyword=<?= urlencode($result['keyword']) ?>"
                        class="flex items-center justify-center min-w-9 h-9 px-3 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 <?= ($i == $result['page']) ? 'bg-blue-600 text-white' : 'bg-white' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </nav>
</div>

<?php require '../app/Views/layouts/footer.php'; ?>