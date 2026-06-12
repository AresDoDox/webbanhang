<?php require '../app/Views/layouts/header.php'; ?>

<?php

use App\Helpers\Flash; ?>

<div class="max-w-lg mx-auto bg-white p-8 rounded shadow">

    <h1 class="text-2xl font-bold mb-6">
        Login
    </h1>

    <?php if ($message = Flash::get('success')): ?>

        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>

    <?php if ($message = Flash::get('error')): ?>

        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">

            <?= htmlspecialchars($message) ?>

        </div>

    <?php endif; ?>

    <form method="POST" action="?route=login-post">

        <input type="email" name="email" placeholder="Email" class="border w-full p-2 mb-3" required>

        <input type="password" name="password" placeholder="Password" class="border w-full p-2 mb-3" required>

        <button class="bg-green-600 text-white px-4 py-2 rounded">

            Login

        </button>

    </form>

</div>

<?php require '../app/Views/layouts/footer.php'; ?>