<?php require '../app/Views/layouts/header.php'; ?>

<div class="flex justify-between mb-6">

    <h1 class="text-3xl font-bold">
        Products
    </h1>

    <a href="?route=admin/products/create" class="bg-indigo-600 text-white px-4 py-2 rounded">

        Add Product

    </a>

</div>

<form method="GET">

    <input type="hidden" name="route" value="admin/products">

    <input type="text" name="keyword" class="border w-full p-2 m-2">

</form>

<table class="w-full bg-white shadow">

    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($products ?? [] as $product): ?>

            <tr>

                <td>
                    <?= $product['id'] ?>
                </td>

                <td>
                    <?= htmlspecialchars(
                        $product['name']
                    ) ?>
                </td>

                <td>
                    <?= $product['price'] ?>
                </td>

                <td>
                    <img src="/webbanhang/storage/uploads/<?= $product['image'] ?>" class="w-20">
                </td>

                <td>
                    <a href="?route=admin/products/show&id=<?= $product['id'] ?>" class="text-blue-500">
                        View
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

    </tbody>

</table>

<?php require '../app/Views/layouts/footer.php'; ?>