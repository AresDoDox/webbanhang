<?php

namespace App\Middleware;

use App\Helpers\Session;

class AuthMiddleware
{
    public static function handle()
    {
        $user = Session::get('user');
        if (!isset($user)) {
            header('Location:' . BASE_PATH . '/login');
            exit;
        }
    }
}
