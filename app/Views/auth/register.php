<?php require '../app/Views/layouts/header.php'; ?>
<?php

use App\Helpers\Csrf; ?>

<div class="max-w-lg mx-auto bg-white p-8 rounded shadow">

    <h1 class="text-2xl font-bold mb-6">
        Register
    </h1>

    <form method="POST" action="?route=register-post">
        <?php require '../app/Views/layouts/flash.php'; ?>
        <input type="hidden" name="csrf" value="<?= Csrf::token() ?>">

        <input type="text" name="name" placeholder="Name" class="border w-full p-2 mb-3" required>

        <input type="email" name="email" placeholder="Email" class="border w-full p-2 mb-3" required>

        <input type="password" name="password" placeholder="Password" class="border w-full p-2 mb-3" required>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded">

            Register

        </button>

    </form>

</div>

<?php require '../app/Views/layouts/footer.php'; ?>