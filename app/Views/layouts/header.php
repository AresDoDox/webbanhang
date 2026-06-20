<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>PHP Project</title>

    <link rel="stylesheet" href="<?= BASE_PATH ?>/assets/css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-slate-100 min-h-screen">

    <nav class="bg-indigo-600 text-white shadow">
        <div class="container mx-auto px-6 py-4 flex justify-between">

            <a href="<?= BASE_PATH ?>/" class="font-bold">
                PHP Project
            </a>

            <div class="space-x-4">

                <?php if (isset($_SESSION['user'])): ?>

                    <span>

                        Hello,

                        <?= htmlspecialchars(
                            $_SESSION['user']['name']
                        ) ?>

                    </span>

                    <span> | </span>

                    <a href="<?= BASE_PATH ?>/dashboard">

                        Dashboard

                    </a>

                    <a href="<?= BASE_PATH ?>/posts">

                        Posts

                    </a>

                    <?php if (
                        $_SESSION['user']['role']
                        === 'admin'
                    ): ?>

                        <a href="<?= BASE_PATH ?>/admin/dashboard">

                            Admin Panel

                        </a>

                    <?php endif; ?>

                    <a href="<?= BASE_PATH ?>/logout">

                        Logout

                    </a>

                <?php else: ?>

                    <a href="<?= BASE_PATH ?>/login">

                        Login

                    </a>

                    <a href="<?= BASE_PATH ?>/register">

                        Register

                    </a>

                <?php endif; ?>

            </div>

        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">