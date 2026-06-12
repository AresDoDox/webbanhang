<?php require '../app/Views/layouts/header.php'; ?>

<div class="bg-white p-8 rounded shadow">

    <h1 class="text-3xl font-bold">

        User Dashboard

    </h1>

    <p class="mt-3">

        Welcome

        <?= htmlspecialchars(
            $_SESSION['user']['name']
        ) ?>

    </p>

</div>

<?php require '../app/Views/layouts/footer.php'; ?>