<?php

namespace App\Middleware;

use App\Enums\Role;
use App\Helpers\Session;

class AdminMiddleware
{
    public static function handle()
    {
        $user = Session::get('user');

        if (!isset($user)) {
            header('Location:' . BASE_PATH . '/login');
            exit;
        }

        if ($user['role'] !== Role::ADMIN->value) {
            http_response_code(403);

            require '../app/Views/errors/403.php';

            exit;
        }
    }
}
