<?php require '../app/Views/layouts/header.php'; ?>

<?php

use App\Helpers\Flash; ?>

<div class="max-w-lg mx-auto bg-white p-8 rounded shadow">

    <h1 class="text-2xl font-bold mb-6">
        Login
    </h1>
    <?php require '../app/Views/layouts/flash.php'; ?>

    <form method="POST" action="?route=login-post">

        <input type="email" name="email" placeholder="Email" class="border w-full p-2 mb-3" required>

        <input type="password" name="password" placeholder="Password" class="border w-full p-2 mb-3" required>

        <button class="bg-green-600 text-white px-4 py-2 rounded">

            Login

        </button>

    </form>

</div>

<?php require '../app/Views/layouts/footer.php'; ?>