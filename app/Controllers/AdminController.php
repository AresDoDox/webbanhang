<?php

namespace App\Controllers;

use App\Middleware\AdminMiddleware;

class AdminController extends Controller
{
    public function dashboard()
    {
        AdminMiddleware::handle();

        $this->view(
            'admin/dashboard'
        );
    }
}
