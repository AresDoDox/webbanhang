<?php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;


class UserController extends Controller
{
    public function dashboard()
    {
        AuthMiddleware::handle();

        $this->view('user/dashboard');
    }
}
