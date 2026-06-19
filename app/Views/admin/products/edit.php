<?php
$product = isset($product) ? $product : [
    'id' => '',
    'name' => '',
    'image' => '',
    'description' => '',
    'price' => ''
];
?>

<?php require '../app/Views/layouts/header.php'; ?>

<?php

use App\Helpers\Csrf; ?>

<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-6">
        Edit Product
    </h1>

    <form action="<?= BASE_PATH ?>/admin/products/update" method="POST" enctype="multipart/form-data">
        <!-- CSRF -->
        <input type="hidden" name="csrf" value="<?= Csrf::token() ?>">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <div class="mb-4">

            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" placeholder="Name"
                class="border w-full p-2">

        </div>

        <div class="mb-4">

            <textarea name="description" class="border w-full p-2">
        <?= htmlspecialchars($product['description']) ?>    
        </textarea>

        </div>

        <div class="mb-4">

            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" class="border w-full p-2">

        </div>

        <div class="mb-4">

            <input type="file" name="image">
            <?php if (!empty($product['image']) || !empty($product->image)): ?>
                <p class="text-sm text-gray-500 mt-1">Current image:
                    <?= is_array($product) ? basename($product['image']) : basename($product->image) ?></p>
            <?php endif; ?>
        </div>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">

            Save

        </button>

    </form>

</div>

<?php require '../app/Views/layouts/footer.php'; ?>