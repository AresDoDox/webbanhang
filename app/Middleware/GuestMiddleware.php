<?php

namespace App\Middleware;

use App\Helpers\Session;

class GuestMiddleware
{
    public static function handle()
    {
        $user = Session::get('user');

        if (isset($user)) {
            header('Location:' . BASE_PATH . '/dashboard');
            exit;
        }
    }
}
