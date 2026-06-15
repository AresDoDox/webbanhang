<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>PHP Project</title>

    <link rel="stylesheet" href="/webbanhang/public/assets/css/app.css">
</head>

<body class="bg-slate-100 min-h-screen">

    <nav class="bg-indigo-600 text-white shadow">
        <div class="container mx-auto px-6 py-4 flex justify-between">

            <a href="?route=/" class="font-bold">
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

                    <a href="?route=dashboard">

                        Dashboard

                    </a>

                    <a href="?route=posts">

                        Posts

                    </a>

                    <?php if (
                        $_SESSION['user']['role']
                        === 'admin'
                    ): ?>

                        <a href="?route=admin/dashboard">

                            Admin Panel

                        </a>

                    <?php endif; ?>

                    <a href="?route=logout">

                        Logout

                    </a>

                <?php else: ?>

                    <a href="?route=login">

                        Login

                    </a>

                    <a href="?route=register">

                        Register

                    </a>

                <?php endif; ?>

            </div>

        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">