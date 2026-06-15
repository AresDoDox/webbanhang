<?php require '../app/Views/layouts/header.php'; ?>

<?php

use App\Helpers\Csrf; ?>

<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-6">
        Create Post
    </h1>

    <form action="?route=posts/store" method="POST">
        <?php require '../app/Views/layouts/flash.php'; ?>
        <!-- CSRF -->
        <input type="hidden" name="csrf" value="<?= Csrf::token() ?>">

        <div class="mb-4">
            <input type="text" name="title" placeholder="Title" class="border w-full p-2">
        </div>

        <div class="mb-4">
            <textarea name="content" class="border w-full p-2">
            </textarea>
        </div>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">
            Save
        </button>

    </form>

</div>

<?php require '../app/Views/layouts/footer.php'; ?>