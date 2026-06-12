<?php

namespace App\Middleware;

use App\Enums\Role;

class AdminMiddleware
{
    public static function handle()
    {
        if (!isset($_SESSION['user'])) {
            header('Location:?route=login');
            exit;
        }

        if (
            $_SESSION['user']['role']
            !==
            Role::ADMIN->value
        ) {
            http_response_code(403);

            require '../app/Views/errors/403.php';

            exit;
        }
    }
}
