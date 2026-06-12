<?php require '../app/Views/layouts/header.php'; ?>

<?php

use App\Helpers\Csrf; ?>

<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-6">
        Create Product
    </h1>

    <form action="?route=admin/products/store" method="POST" enctype="multipart/form-data">
        <!-- CSRF -->
        <input type="hidden" name="csrf" value="<?= Csrf::token() ?>">

        <div class="mb-4">

            <input type="text" name="name" placeholder="Name" class="border w-full p-2">

        </div>

        <div class="mb-4">

            <textarea name="description" class="border w-full p-2">
            </textarea>

        </div>

        <div class="mb-4">

            <input type="number" step="0.01" name="price" class="border w-full p-2">

        </div>

        <div class="mb-4">

            <input type="file" name="image">

        </div>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">

            Save

        </button>

    </form>

</div>

<?php require '../app/Views/layouts/footer.php'; ?>